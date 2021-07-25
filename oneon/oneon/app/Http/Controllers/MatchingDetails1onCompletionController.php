<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\CommonServices;
use App\Services\MatchingDetails1onCompletionServices;
class MatchingDetails1onCompletionController extends Controller
{
    protected $matchingDetails1onCompletionServices;
    /**
     * コンストラクタ作成
     * @param EmployeeService
     */
    public function __construct(MatchingDetails1onCompletionServices $matchingDetails1onCompletionServices, CommonServices $commonService)
    {
        $this->matchingDetails1onCompletionServices = $matchingDetails1onCompletionServices;
        $this->commonService = $commonService;
    }
    /**
     * 初期表示
     * @return マッチング詳細
     */
    public function init(Request $request){
        $matchingHistoryId = 27;
        
        //社員同士のマッチングデータの取得
        $getEmployeeData = $this->matchingDetails1onCompletionServices->getMatchingData($matchingHistoryId);

        //社員情報取得
        //$getMatchingData = $this->matchingDetails1onCompletionServices->getEmployeesData($getEmployeeData->mentee_oneon_id, $getEmployeeData->mentor_oneon_id);

        //社員情報取得
        $getMatchingDataMentee = $this->matchingDetails1onCompletionServices->getEmployeeData($getEmployeeData->mentee_oneon_id);
        $getMatchingDataMentor = $this->matchingDetails1onCompletionServices->getEmployeeData($getEmployeeData->mentor_oneon_id);

        //メンティー部署名取得
        $departmentCurrentCodeMentee = $this->commonService->getUserFullDepartmentTagNames($getMatchingDataMentee->department_current_code);
        $departmentPastCodeMentee = $this->commonService->getUserFullDepartmentTagNames($getMatchingDataMentee->department_past_code);

        //メンター部署名取得
        $departmentCurrentCodeMentor = $this->commonService->getUserFullDepartmentTagNames($getMatchingDataMentor->department_current_code);
        $departmentPastCodeMentor = $this->commonService->getUserFullDepartmentTagNames($getMatchingDataMentor->department_past_code);

        //メンティータグコード名
        $tagCodeMentee = $this->commonService->getUserSkillTagNames($getMatchingDataMentee->tag_code);
        //メンタータグコード名
        $tagCodeMentor = $this->commonService->getUserSkillTagNames($getMatchingDataMentor->tag_code);

        $getEmployeeData = json_decode(json_encode($getEmployeeData), true);
        $getMatchingDataMentee = json_decode(json_encode($getMatchingDataMentee), true);
        $getMatchingDataMentor = json_decode(json_encode($getMatchingDataMentor), true);

        //viewにデータを渡す
        $this->information['getEmployeeData'] = $getEmployeeData;
        $this->information['getMatchingDataMentee'] = $getMatchingDataMentee;
        $this->information['getMatchingDataMentor'] = $getMatchingDataMentor;
        $this->information['departmentCurrentCodeMentee'] = $departmentCurrentCodeMentee;
        $this->information['departmentPastCodeMentee'] = $departmentPastCodeMentee;
        $this->information['departmentCurrentCodeMentor'] = $departmentCurrentCodeMentor;
        $this->information['departmentPastCodeMentor'] = $departmentPastCodeMentor;
        $this->information['tagCodeMentee'] = $tagCodeMentee;
        $this->information['tagCodeMentor'] = $tagCodeMentor;
        return view('pages/matching/matchingDetails1onCompletion', $this->information);
    }
}