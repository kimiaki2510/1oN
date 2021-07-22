<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HomeServices;
use App\Services\CommonServices;
use App\Services\EmployeeServices;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class HomeController extends Controller
{
  protected $employeeService;

  /**
   * コンストラクタ作成
   * @param HomeServices
   */
  public function __construct(HomeServices $homeService, EmployeeServices $employeeService, CommonServices $commonService)
  {
    $this->homeService = $homeService;
    $this->employeeService = $employeeService;
    $this->commonService = $commonService;
  }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
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
      $userInfo = $this->homeService->getHomeEmployeeInfoByOneonId($oneonId);
      $userInfo = json_decode(json_encode($userInfo[0]), true);
      // //タグ情報の分割
      // $userInfoTagCode = $this->employeeService->getTagCodeSplitExecute($userInfo['tag_code']);
      // $userInfoDepartmentCurrentCode = $this->employeeService->getTagCodeSplitExecute($userInfo['department_current_code']);
      // $userInfoDepartmentPastCode = $this->employeeService->getTagCodeSplitExecute($userInfo['department_past_code']);
      // $userInfoJobCurrentCode = $this->employeeService->getTagCodeSplitExecute($userInfo['job_current_code']);
      // $userInfoJobPastCode = $this->employeeService->getTagCodeSplitExecute($userInfo['job_past_code']);
      //タグ名を取得
      $userSkillTagNames = json_decode(json_encode($this->commonService->getUserSkillTagNames($userInfo['tag_code'])), true);
      $userDepartmentTagNames = json_decode(json_encode($this->commonService->getUserFullDepartmentTagNames($userInfo['department_current_code'])), true);
      $userJobCurrentTagNames = json_decode(json_encode($this->commonService->getUserJobCurrentTagNames($userInfo['job_current_code'])), true);

      $this->information['fullName'] = $userInfo['full_name'];
      $this->information['menteeTimes'] = $userInfo['mentee_times'];
      $this->information['mentorTimes'] = $userInfo['mentor_times'];
      $this->information['userSkillTagNames'] = $userSkillTagNames;
      $this->information['userDepartmentTagNames'] = $userDepartmentTagNames;
      $this->information['userJobCurrentTagNames'] = $userJobCurrentTagNames;
      return view('home', $this->information);
    }
}
