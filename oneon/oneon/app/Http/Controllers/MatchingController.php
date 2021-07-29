<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CommonServices;
use App\Services\EmployeeServices;
use App\Services\MatchingServices;
use App\Http\Requests\MatchingSearchRequest;
use App\Http\Requests\MatchingExecuteRequest;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class MatchingController extends Controller
{
  protected $employeeService;

  /**
   * コンストラクタ作成
   * @param MatchingServices
   */
  public function __construct(MatchingServices $matchingService, EmployeeServices $employeeService, CommonServices $commonService)
  {
    $this->matchingService = $matchingService;
    $this->employeeService = $employeeService;
    $this->commonService = $commonService;
  }

  public function matchingRequest(Request $request) {
    $data = json_decode(json_encode($request['selectDatas']), true);
    //dd($data);

    //変数宣言
    $allSkills = [];
    $tmpSkill = [];
    $allDepartments = [];
    $tmpDepartment = [];

    $oldStance = !empty($data['stance']) ? $data['stance'] : [NULL];
    $oldSkillTags = !empty($data['skillTags']) ? $data['skillTags'] : [NULL];
    $oldcurrentDepartmentTags = !empty($data['currentDepartmentTags']) ? $data['currentDepartmentTags'] : [NULL];
    $oldcurrentJob = !empty($data['currentJob']) ? $data['currentJob'] : [NULL];
    $oldpastDepartmentTags = !empty($data['pastDepartmentTags']) ? $data['pastDepartmentTags'] : [NULL];
    $oldpastJob = !empty($data['pastJob']) ? $data['pastJob'] : [NULL];
    //dd($oldpastJob);

    //スキルタグ取得
    $allSkillTags = $this->employeeService->getSkillTags();
    $allSkillGroup = $this->employeeService->getTagGroups();
    $allSkillTags = json_decode(json_encode($allSkillTags), true);
    $allSkillGroup = json_decode(json_encode($allSkillGroup), true);
    //部署タグ取得
    $allDepartmentTags = $this->employeeService->getDepartmentTags();
    $allDepartmentGroup = $this->employeeService->getDepartmentGroups();
    $allDepartmentTags = json_decode(json_encode($allDepartmentTags), true);
    $allDepartmentGroup = json_decode(json_encode($allDepartmentGroup), true);

    //スキルタグ加工
    foreach ($allSkillGroup as $skillGroup) {
      $tmpSkill = [$skillGroup];
      foreach ($allSkillTags as $skillTag) {
        if ($skillTag["tag_group_code"] == $skillGroup["tag_group_code"]) {
          array_push($tmpSkill, $skillTag);
        }
      }
      array_push($allSkills, $tmpSkill);
    }
    //部署タグ加工
    foreach ($allDepartmentGroup as $departmentGroup) {
      $tmpDepartment = [$departmentGroup];
      foreach ($allDepartmentTags as $departmentTag) {
        if ($departmentTag["department_group_code"] == $departmentGroup["department_group_code"]) {
          array_push($tmpDepartment, $departmentTag);
        }
      }
      array_push($allDepartments, $tmpDepartment);
    }
  
    $this->information['skills'] = $allSkills;
    $this->information['departments'] = $allDepartments;
    $this->information['oldStance'] = $oldStance;
    $this->information['oldSkillTags'] = $oldSkillTags;
    $this->information['oldcurrentDepartmentTags'] = $oldcurrentDepartmentTags;
    $this->information['oldcurrentJob'] = $oldcurrentJob;
    $this->information['oldpastDepartmentTags'] = $oldpastDepartmentTags;
    $this->information['oldpastJob'] = $oldpastJob;
    return view('pages.matching.matching-request', $this->information);
  }

  public function matchingSearchExecute(MatchingSearchRequest $request) {
    //dd($request->all());
    // ONEONを取得
    // $oneonId = Auth::user()->oneon_id;
    $oneonId = 1000000001;

    if (empty($oneonId)) {
      throw new UnprocessableEntityHttpException("Unprocessable Entity Excetion");
    }

    $selectStance = $request->stance;
    $selectSkillTags = $request->skillTags;
    $selectCurrentDepartmentTags = $request->currentDepartmentTags;
    $selectCurrentJob = $request->currentJob;
    $selectPastDepartmentTags = $request->pastDepartmentTags;
    $selectPastJob = $request->pastJob;

    //dd($selectSkillTags);
    //検索条件を1つの配列にする
    $allSelectSearchTags = $this->matchingService->getJoinSelectSearchTags($selectSkillTags, $selectCurrentDepartmentTags, $selectCurrentJob, $selectPastDepartmentTags, $selectPastJob);
    //dd($allSelectSearchTags);

    $allUserInfo = $this->matchingService->getAllUserInfo($oneonId);
    $allUserInfo = json_decode(json_encode($allUserInfo), true);
    //マッチングアルゴリズムからマッチングしたユーザーを取得
    $matchingUsersInfo = $this->matchingService->getMatchingSearchExecute($allUserInfo, $allSelectSearchTags);
    
    //dd($matchingUsersInfo);
    if (!empty($matchingUsersInfo)) {
      //$matchingUsersInfo = $this->matchingService->getUserTagsSplit($matchingUsersInfo);
      for ($i=0; $i < count($matchingUsersInfo); $i++) {
        $matchingUsersInfo[$i]['tag_code'] = json_decode(json_encode($this->commonService->getUserSkillTagNames($matchingUsersInfo[$i]['tag_code'])), true);
        $matchingUsersInfo[$i]['job_current_code'] = json_decode(json_encode($this->commonService->getUserJobCurrentTagNames($matchingUsersInfo[$i]['job_current_code'])), true);
        $matchingUsersInfo[$i]['job_past_code'] = json_decode(json_encode($this->commonService->getUserJobCurrentTagNames($matchingUsersInfo[$i]['job_past_code'])), true);
      }
    }

    $this->information['request'] = $request->all();
    $this->information['matchingUsersInfo'] = $matchingUsersInfo;
    $this->information['selectStance'] = $selectStance;
    return view('pages.matching.mentor-search', $this->information);
  }

  public function matchingRequestExecute(Request $request) {
    //dd($request->all());
    if (strcmp($request->back, "back") == 0) {
      $input = $request->all();
      //dd($request->all());
      return redirect()->route('matching.request', $request->all());
    }

    // ONEONを取得
    // $oneonId = Auth::user()->oneon_id;
    $menteeOneonId = 1000000001;
    if (empty($menteeOneonId)) {
      throw new UnprocessableEntityHttpException("Unprocessable Entity Excetion");
    }
    $mentorOneonId = $request->matchOneonId;
    $stance = $request->selectDatas['stance'];
    $menteeMessage = $request->messageText;
    $hopeStance = $this->commonService->getJoinParameter($stance);
    //検索したタグ情報を取得
    $selectSkillTags = $this->commonService->getJoinParameter( !empty($request->selectDatas['skillTags']) ? $request->selectDatas['skillTags'] : NULL);
    $selectCurrentDepartmentTags = $this->commonService->getJoinParameter( !empty($request->selectDatas['currentDepartmentTags']) ? $request->selectDatas['currentDepartmentTags'] : NULL);
    $selectCurrentJob = $this->commonService->getJoinParameter( !empty($request->selectDatas['currentJob']) ? $request->selectDatas['currentJob'] : NULL);
    $selectPastDepartmentTags = $this->commonService->getJoinParameter( !empty($request->selectDatas['pastDepartmentTags']) ? $request->selectDatas['pastDepartmentTags'] : NULL);
    $selectPastJob = $this->commonService->getJoinParameter( !empty($request->selectDatas['pastJob']) ? $request->selectDatas['pastJob'] : NULL);
        
    //マッチング履歴を作成
    $this->matchingService->createMatchingHistory($menteeOneonId, $mentorOneonId, $hopeStance, $menteeMessage);
    //タグ検索履歴を作成
    $this->matchingService->createTagsSearchHistory($menteeOneonId, $selectSkillTags, $selectCurrentDepartmentTags, $selectCurrentJob, $selectPastDepartmentTags, $selectPastJob);

    return redirect()->route('home', []);
  }

}
