<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CommonServices;
use App\Services\EmployeeServices;
use App\Services\MatchingServices;
use App\Services\MatchingReceptionServices;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class MatchingReceptionController extends Controller
{
  protected $employeeService;

  /**
   * コンストラクタ作成
   * @param MatchingServices
   */
  public function __construct(MatchingReceptionServices $matchingReceptionService, MatchingServices $matchingService, EmployeeServices $employeeService, CommonServices $commonService)
  {
    $this->matchingService = $matchingService;
    $this->employeeService = $employeeService;
    $this->commonService = $commonService;
    $this->matchingReceptionService = $matchingReceptionService;
  }

  public function reception(Request $request) {
    // ONEONを取得
    // $oneonId = Auth::user()->oneon_id;
    $oneonId = 1000000001;
    if (empty($oneonId)) {
      throw new UnprocessableEntityHttpException("Unprocessable Entity Excetion");
    }

    $menteeOneonId = $request->menteeOneonId;
    $matchingHistoryId = $request->matchingHistoryId;
    //メンティー情報を取得
    $menteeUserInfo = json_decode(json_encode($this->matchingReceptionService->getMenteeEmployeeInfoByOneonId($menteeOneonId)), true);
    //タグ名を取得
    $userSkillTagNames = json_decode(json_encode($this->commonService->getUserSkillTagNames($menteeUserInfo['tag_code'])), true);
    $userDepartmentTagNames = json_decode(json_encode($this->commonService->getUserFullDepartmentTagNames($menteeUserInfo['department_current_code'])), true);
    $userJobCurrentTagNames = json_decode(json_encode($this->commonService->getUserJobCurrentTagNames($menteeUserInfo['job_current_code'])), true);
    //マッチング情報を取得
    $matchInfo = json_decode(json_encode($this->matchingReceptionService->getReceptionMatchInfo($matchingHistoryId)), true);
    $hopeStance = $this->employeeService->getTagCodeSplitExecute($matchInfo['hope_stance']);

    $this->information['matchingHistoryId'] = $matchingHistoryId;
    $this->information['menteeUserInfo'] = $menteeUserInfo;
    $this->information['userSkillTagNames'] = $userSkillTagNames;
    $this->information['userDepartmentTagNames'] = $userDepartmentTagNames;
    $this->information['userJobCurrentTagNames'] = $userJobCurrentTagNames;
    $this->information['matchInfo'] = $matchInfo;
    $this->information['hopeStance'] = $hopeStance;
    return view('pages.matching.matching-reception', $this->information);
  }

  public function receptionExecute(Request $request) {
     //dd($request);

    $matchingHistoryId = $request['matchingHistoryId'];
    $receptionMentorMessage = $request['receptionMessageText'];
    $notReceptionMentorMessage = $request['notReceptionMessageText'];

    //メンターを受けない場合
    if (strcmp($request->back, "back") == 0) {
      $this->matchingReceptionService->updateMatchNotReception($matchingHistoryId, $notReceptionMentorMessage);
      return redirect()->route('home', []);
    }

    //メンターを受ける場合
    $this->matchingReceptionService->updateMatchReception($matchingHistoryId, $receptionMentorMessage);
    return redirect()->route('home', []);

  }


}
