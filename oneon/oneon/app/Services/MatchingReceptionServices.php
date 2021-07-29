<?php

namespace App\Services;

// use DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\SkillTags;
use App\Services\EmployeeServices;
use DateInterval;
use Carbon\Carbon;

class MatchingReceptionServices
{
  public function __contrust(EmployeeServices $employeeService)
  {
    $this->employeeService = $employeeService;
  }

  public function getMenteeEmployeeInfoByOneonId($oneonId)
  {
    return DB::table('t_employees')
      ->where('t_employees.oneon_id', $oneonId)
      ->select(DB::raw('
        t_employees.oneon_id,
        concat( t_employees.last_name, " ", t_employees.first_name) as full_name,
        t_employee_tags.tag_code,
        t_employee_tags.department_current_code,
        t_employee_tags.job_current_code
      '))
      ->join('t_employee_tags', 't_employees.oneon_id', '=', 't_employee_tags.oneon_id')
      ->whereRaw('t_employees.deleted_flag <> 1 && t_employee_tags.deleted_flag <> 1')
      ->first();
  }

  public function getReceptionMatchInfo($matchingHistoryId)
  {
    return DB::table('t_matching_histories')
      ->where('t_matching_histories.matching_history_id', $matchingHistoryId)
      ->select(DB::raw('
      t_matching_histories.mentee_oneon_id,
      t_matching_histories.mentee_message,
      t_matching_histories.hope_stance
      '))
      ->first();
  }

  public function updateMatchReception($matchingHistoryId, $mentorMessage)
  {
    $autoHide = new Carbon(Carbon::now());
    $autoHideExpireDate = date_create($autoHide->addDay(2));
    if ($mentorMessage == null) {
      $mentorMessage = '1oN依頼を承認しました！';
    }

    DB::table('t_matching_histories')
      ->where('matching_history_id', $matchingHistoryId)
      ->update([
        'matching_status' => '1016001',
        'mentor_message' => $mentorMessage,
        'auto_hide_expire_date' => $autoHideExpireDate,
        'auto_reject_expire_date' => NULL,
        'updated_at' => NOW()
      ]);

    DB::table('t_matching_histories')
      ->where('matching_history_id', $matchingHistoryId)->increment('version');
  }

  public function updateMatchNotReception($matchingHistoryId, $notReceptionMentorMessage)
  {
    $autoHide = new Carbon(Carbon::now());
    $autoHideExpireDate = date_create($autoHide->addDay(2));
    if ($notReceptionMentorMessage == null) {
      $notReceptionMentorMessage = 'ごめんなさい！他を当たってください！';
    }

    DB::table('t_matching_histories')
      ->where('matching_history_id', $matchingHistoryId)
      ->update([
        'matching_status' => '1016002',
        'mentor_message' => $notReceptionMentorMessage,
        'rejected_date' => NOW(),
        'rejected_reason' => $notReceptionMentorMessage,
        'auto_hide_expire_date' => $autoHideExpireDate,
        'auto_reject_expire_date' => NULL,
        'updated_at' => NOW()
      ]);

    DB::table('t_matching_histories')
      ->where('matching_history_id', $matchingHistoryId)->increment('version');
  }

  public function getOneonIdByMatchingHistoryId($matchingHistoryId)
  {
    return DB::table('t_matching_histories')
    ->where('t_matching_histories.matching_history_id', $matchingHistoryId)
    ->select(DB::raw('
      mentee_oneon_id as menteeOneonId,
      mentor_oneon_id as mentorOneonId
    '))
    ->first();
  }

  public function updateMatchCountUp($menteeOneonId, $mentorOneonId)
  {
    DB::table('t_employees')
      ->where('oneon_id', $menteeOneonId)->increment('mentee_times', 1, ['updated_at' => NOW()]);
    DB::table('t_employees')
      ->where('oneon_id', $mentorOneonId)->increment('mentor_times', 1, ['updated_at' => NOW()]);
  }


}
