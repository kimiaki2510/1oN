<?php

namespace App\Services;

// use DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\SkillTags;

class HomeServices
{
  public function __contrust(SkillTags $skillTags)
  {
    $this->skillTags = $skillTags;
  }

  public function getHomeEmployeeInfoByOneonId($oneonId)
  {
    return DB::table('t_employees')
      ->where('t_employees.oneon_id', $oneonId)
      ->select(DB::raw('
        t_employees.oneon_id,
        concat( t_employees.last_name, " ", t_employees.first_name) as full_name,
        t_employees.mentee_times,
        t_employees.mentor_times,
        t_employee_tags.tag_code,
        t_employee_tags.department_current_code,
        t_employee_tags.department_past_code,
        t_employee_tags.job_current_code,
        t_employee_tags.job_past_code
      '))
      ->join('t_employee_tags', 't_employees.oneon_id', '=', 't_employee_tags.oneon_id')
      ->whereRaw('t_employees.deleted_flag <> 1 && t_employee_tags.deleted_flag <> 1')
      ->get();
  }

  public function getHomeMenteeMatchInfoByOneonId($oneonId)
  {
    return DB::table('t_matching_histories')
      ->where('t_matching_histories.mentee_oneon_id', '=', $oneonId)
      ->select(DB::raw('
      concat( t_employees.last_name, " ", t_employees.first_name) as full_name,
      t_matching_histories.matching_history_id,
      t_matching_histories.mentee_oneon_id,
      t_matching_histories.mentor_oneon_id,
      left(t_matching_histories.mentee_message, 60) as mentee_message,
      t_matching_histories.matching_status,
      t_matching_histories.rejected_reason,
      t_matching_histories.auto_reject_expire_date,
      t_matching_histories.auto_hide_expire_date,
      t_profile_images.profile_photo_path
      '))
      ->join('t_employees', 't_matching_histories.mentor_oneon_id', '=', 't_employees.oneon_id')
      ->leftJoin('t_profile_images', 't_matching_histories.mentor_oneon_id', '=', 't_profile_images.oneon_id')
      ->whereRaw('(t_matching_histories.matching_status = 1016000 || t_matching_histories.matching_status = 1016001) && t_employees.deleted_flag <> 1 && t_matching_histories.deleted_flag <> 1')
      ->get();
  }

  public function getHomeMentorMatchInfoByOneonId($oneonId)
  {
    return DB::table('t_matching_histories')
      ->where('t_matching_histories.mentor_oneon_id', '=', $oneonId)
      ->select(DB::raw('
      concat( t_employees.last_name, " ", t_employees.first_name) as full_name,
      t_matching_histories.matching_history_id,
      t_matching_histories.mentee_oneon_id,
      t_matching_histories.mentor_oneon_id,
      left(t_matching_histories.mentee_message, 60) as mentee_message,
      t_matching_histories.matching_status,
      t_matching_histories.rejected_reason,
      t_matching_histories.auto_reject_expire_date,
      t_matching_histories.auto_hide_expire_date,
      t_profile_images.profile_photo_path
      '))
      ->join('t_employees', 't_matching_histories.mentee_oneon_id', '=', 't_employees.oneon_id')
      ->leftJoin('t_profile_images', 't_matching_histories.mentee_oneon_id', '=', 't_profile_images.oneon_id')
      ->whereRaw('(t_matching_histories.matching_status = 1016000 || t_matching_histories.matching_status = 1016001) && t_employees.deleted_flag <> 1 && t_matching_histories.deleted_flag <> 1')
      ->get();
  }

  public function getSeparateMatchInfo($menteeMatchInfo, $mentorMatchReceptionInfo)
  {
    //dd($menteeMatchInfo);
    $result = [];
    $tmpMenteeRequest = [];
    $tmpMentorRequest = [];
    $tmpCompletion = [];

    //メンティー側の分割
    if (!empty($menteeMatchInfo)) {
      foreach ($menteeMatchInfo as $menteeMatch) {
        if ($menteeMatch['matching_status'] == 1016000) {
          array_push($tmpMenteeRequest, $menteeMatch);
        } elseif ($menteeMatch['matching_status'] == 1016001) {
          array_push($tmpCompletion, $menteeMatch);
        }
      }
    }
    //メンター側の分割
    if (!empty($mentorMatchReceptionInfo)) {
      foreach ($mentorMatchReceptionInfo as $mentorMatchReception) {
        if ($mentorMatchReception['matching_status'] == 1016000) {
          array_push($tmpMentorRequest , $mentorMatchReception);
        } elseif ($mentorMatchReception['matching_status'] == 1016001) {
          array_push($tmpCompletion, $mentorMatchReception);
        }
      }
    }

    $result = ['menteeRequest' => $tmpMenteeRequest, 'mentorRequest' => $tmpMentorRequest, 'completion' => $tmpCompletion];
    return $result;
  }


}
