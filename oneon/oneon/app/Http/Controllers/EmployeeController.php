<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmployeeServices;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class EmployeeController extends Controller
{
  protected $employeeService;
  
  /**
   * コンストラクタ作成
   * @param EmployeeService
   */
  public function __construct(EmployeeServices $employeeService)
  {
    $this->employeeService = $employeeService;
  }

  //会員登録
  public function definitiveRegist() {
    //変数宣言
    $allSkills = [];
    $tmpSkill = [];
    $allDepartments = [];
    $tmpDepartment = [];

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
    //dd($allSkills);

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
    //dd($allDepartments);
    

    $this->information['skills'] = $allSkills;
    $this->information['departments'] = $allDepartments;
    return view('pages.employee.definitive-regist', $this->information);
  }

  public function definitiveExecute(Request $request) {

    // ONEONを取得
    // $oneonId = Auth::user()->oneon_id;
    $oneonId = 1000000001;
    
    //tagコードを連結
    $currentDepartmentTags = $this->employeeService->getJoinParameter($request->currentDepartmentTags);
    $pastDepartmentTags = $this->employeeService->getJoinParameter($request->pastDepartmentTags);
    $currentJob = $this->employeeService->getJoinParameter($request->currentJob);
    $pastJob = $this->employeeService->getJoinParameter($request->pastJob);
    $skillTags = $this->employeeService->getJoinParameter($request->skillTags);
    $sex = (int) $request->sex;

    //社員タグテーブルを作成
    $this->employeeService->createEmployeeTags($oneonId, $currentDepartmentTags, $pastDepartmentTags, $currentJob ,$pastJob ,$skillTags); 

    //社員テーブルを更新
    $this->employeeService->updateRegistEmployee($oneonId, $sex);

    return redirect()->route('home', []);
  }

  //会員情報変更
  public function update() {

    //変数宣言
    $allSkills = [];
    $allDepartments = [];

    // ONEONを取得
    // $oneonId = Auth::user()->oneon_id;
    $oneonId = 1000000001;

    if (empty($oneonId)) {
      throw new UnprocessableEntityHttpException("Unprocessable Entity Excetion");
    }

    //会員情報を取得
    $userInfo = $this->employeeService->getEmployeeInfoByOneonId($oneonId);
    $userInfo = json_decode(json_encode($userInfo[0]), true);

    $userInfoSex = $this->employeeService->getTagCodeSplitExecute($userInfo['sex']);
    $userInfoTagCode = $this->employeeService->getTagCodeSplitExecute($userInfo['tag_code']);
    $userInfoDepartmentCurrentCode = $this->employeeService->getTagCodeSplitExecute($userInfo['department_current_code']);
    $userInfoDepartmentPastCode = $this->employeeService->getTagCodeSplitExecute($userInfo['department_past_code']);
    $userInfoJobCurrentCode = $this->employeeService->getTagCodeSplitExecute($userInfo['job_current_code']);
    $userInfoJobPastCode = $this->employeeService->getTagCodeSplitExecute($userInfo['job_past_code']);
    
    //dd($userInfoTagCode);
  
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
    $allSkills = $this->employeeService->getSkillTagsProcessing($allSkillGroup, $allSkillTags);
    //部署タグ加工
    $allDepartments = $this->employeeService->getDepartmentTagsProcessing($allDepartmentGroup, $allDepartmentTags);
    //dd($allSkills);

    //dd(in_array('7001' , $userInfoTagCode) ? "checked" : false);

    $this->information['skills'] = $allSkills;
    $this->information['departments'] = $allDepartments;
    $this->information['userInfoTagCode'] = $userInfoTagCode;
    $this->information['userInfoDepartmentCurrentCode'] = $userInfoDepartmentCurrentCode;
    $this->information['userInfoDepartmentPastCode'] = $userInfoDepartmentPastCode;
    $this->information['userInfoJobCurrentCode'] = $userInfoJobCurrentCode;
    $this->information['userInfoJobPastCode'] = $userInfoJobPastCode;
    $this->information['userInfoSex'] = $userInfoSex;

    return view('pages.employee.update', $this->information);
  }

  public function updateExecute(Request $request) {

    // ONEONを取得
    // $oneonId = Auth::user()->oneon_id;
    $oneonId = 1000000001;


    //tagコードを連結
    $currentDepartmentTags = $this->employeeService->getJoinParameter($request->currentDepartmentTags);
    $pastDepartmentTags = $this->employeeService->getJoinParameter($request->pastDepartmentTags);
    $currentJob = $this->employeeService->getJoinParameter($request->currentJob);
    $pastJob = $this->employeeService->getJoinParameter($request->pastJob);
    $skillTags = $this->employeeService->getJoinParameter($request->skillTags);
    $sex = (int) $request->sex;

    //社員タグテーブルを作成
    $this->employeeService->updateEmployeeTags($oneonId, $currentDepartmentTags, $pastDepartmentTags, $currentJob ,$pastJob ,$skillTags); 

    //社員テーブルを更新
    $this->employeeService->updateEmployee($oneonId, $sex);
    return redirect()->route('home', []);
  }



}
