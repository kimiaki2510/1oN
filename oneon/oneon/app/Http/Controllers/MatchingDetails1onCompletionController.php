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

        $matchingHistoryId = $request->matchingHistoryId;
        //社員同士のマッチングデータの取得
        $getEmployeeData = $this->matchingDetails1onCompletionServices->getMatchingData($matchingHistoryId);

        //社員情報取得
        $getMatchingDataMentee = $this->matchingDetails1onCompletionServices->getEmployeeData($getEmployeeData->mentee_oneon_id);
        $getMatchingDataMentor = $this->matchingDetails1onCompletionServices->getEmployeeData($getEmployeeData->mentor_oneon_id);

        //現在の職種コード取得
        $menteeJobCurrentTagNames = $this->commonService->getUserJobCurrentTagNames($getMatchingDataMentee->job_current_code);
        $mentorJobCurrentTagNames = $this->commonService->getUserJobCurrentTagNames($getMatchingDataMentor->job_current_code);

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
        $this->information['menteeJobCurrentTagNames'] = $menteeJobCurrentTagNames;
        $this->information['mentorJobCurrentTagNames'] = $mentorJobCurrentTagNames;
        $this->information['departmentCurrentCodeMentee'] = $departmentCurrentCodeMentee;
        $this->information['departmentPastCodeMentee'] = $departmentPastCodeMentee;
        $this->information['departmentCurrentCodeMentor'] = $departmentCurrentCodeMentor;
        $this->information['departmentPastCodeMentor'] = $departmentPastCodeMentor;
        $this->information['tagCodeMentee'] = $tagCodeMentee;
        $this->information['tagCodeMentor'] = $tagCodeMentor;
        return view('pages/matching/matchingDetails1onCompletion', $this->information);
    }

    /**
     * マッチング履歴
     * @return マッチング履歴
     */
    public function history(Request $request){
        $mentee = [];
        $mentor = [];
        $menteeDepCurrent = [];
        $menteeDepPast = [];
        $mentorDepCurrent = [];
        $mentorDepPast = [];
        $menteeTagCode = [];
        $mentorTagCode = [];
        $menteeJobCurrentTagNames = [];
        $mentorJobCurrentTagNames = [];

        //oneOnIdの取得
        // $oneonId = $request->matchingHistoryId;
        $oneonId = 1000000001;

        //履歴一覧の取得
        $matchingHistoryList = $this->matchingDetails1onCompletionServices->matchingHistoryList($oneonId);
        
        //曜日取得
        if (!empty($matchingHistoryList)) {
          for ($i=0; $i < count($matchingHistoryList); $i++) {
            $DayOfWeek[$i] = $this->getDayOfWeek($matchingHistoryList[$i]->updated_at);              
          }
        }
        // dd($DayOfWeek);
        

        //ユーザ情報の取得
        if (!empty($matchingHistoryList)) {
            for ($i=0; $i < count($matchingHistoryList); $i++) {
                $mentee[$i] = json_decode(json_encode($this->matchingDetails1onCompletionServices->getUserList($matchingHistoryList[$i]->mentee_oneon_id)), true);
                $mentor[$i] = json_decode(json_encode($this->matchingDetails1onCompletionServices->getUserList($matchingHistoryList[$i]->mentor_oneon_id)), true);
            }
          }
        
        //メンティー現在の職種コード取得
        if (!empty($mentee)) {
          for ($i=0; $i < count($mentee); $i++) {
            $menteeJobCurrentTagNames[$i] = json_decode(json_encode($this->commonService->getUserJobCurrentTagNames($mentee[$i][0]['job_current_code'])), true);            
          }
        }
        // dd($menteeJobCurrentTagNames);

        //メンター現在の職種コード取得
        if (!empty($mentor)) {
          for ($i=0; $i < count($mentor); $i++) {
            $mentorJobCurrentTagNames[$i] = json_decode(json_encode($this->commonService->getUserJobCurrentTagNames($mentor[$i][0]['job_current_code'])), true);            
          }
        }

        //メンティー部署名取得
        if (!empty($mentee)) {
            for ($i=0; $i < count($mentee); $i++) {
                $menteeDepCurrent[$i] = json_decode(json_encode($this->commonService->getUserFullDepartmentTagNames($mentee[$i][0]['department_current_code'])), true);
                $menteeDepPast[$i] = json_decode(json_encode($this->commonService->getUserFullDepartmentTagNames($mentee[$i][0]['department_past_code'])), true);
            }
          }

        //   dd($menteeDepCurrent);
        //メンター部署名取得
        if (!empty($mentor)) {
            for ($i=0; $i < count($mentor); $i++) {
                $mentorDepCurrent[$i] = json_decode(json_encode($this->commonService->getUserFullDepartmentTagNames($mentor[$i][0]['department_current_code'])), true);
                $mentorDepPast[$i] = json_decode(json_encode($this->commonService->getUserFullDepartmentTagNames($mentor[$i][0]['department_past_code'])), true);
            }
          }
        //   dd($mentorDepCurrent);
        //メンティータグコード名
        if (!empty($mentee)) {
            for ($i=0; $i < count($mentee); $i++) {
                $menteeTagCode[$i] = json_decode(json_encode($this->commonService->getUserSkillTagNames($mentee[$i][0]['tag_code'])), true);
            }
          }

        //   dd($menteeTagCode);
        //メンタータグコード名
        if (!empty($mentor)) {
            for ($i=0; $i < count($mentor); $i++) {
                $mentorTagCode[$i] = json_decode(json_encode($this->commonService->getUserSkillTagNames($mentor[$i][0]['tag_code'])), true);
            }
          }

        $matchingHistoryList = json_decode(json_encode($matchingHistoryList), true);
          // dd($matchingHistoryList[0]->mentee_oneon_id);
        //viewにデータを渡す
        $this->information['matchingHistoryList'] = $matchingHistoryList;
        $this->information['mentee'] = $mentee;
        $this->information['mentor'] = $mentor;
        $this->information['DayOfWeek'] = $DayOfWeek;
        $this->information['menteeJobCurrentTagNames'] = $menteeJobCurrentTagNames;
        $this->information['mentorJobCurrentTagNames'] = $mentorJobCurrentTagNames;
        $this->information['menteeDepCurrent'] = $menteeDepCurrent;
        $this->information['menteeDepPast'] = $menteeDepPast;
        $this->information['mentorDepCurrent'] = $mentorDepCurrent;
        $this->information['mentorDepPast'] = $mentorDepPast;
        $this->information['menteeTagCode'] = $menteeTagCode;
        $this->information['mentorTagCode'] = $mentorTagCode;

        return view('pages/matching/matchingHistory', $this->information);
    }

    /**
     * 曜日取得
     * @$dating 日付(string型)
     * @return 曜日
     */
    public function getDayOfWeek($dating){
      // dd(gettype($dating));
      //yyyy/mm/ddをyyyymmddの形式に変更
      $dating = trim($dating, '/');

      $date = date('w', strtotime($dating));

      $week = [
        '(日)', //0
        '(月)', //1
        '(火)', //2
        '(水)', //3
        '(木)', //4
        '(金)', //5
        '(土)', //6
      ];
      return $week[$date];
    }
    
}