<?php

namespace App\Services;

// use DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\SkillTags;
use App\Services\EmployeeServices;
use DateInterval;
use Carbon\Carbon;

class MatchingServices
{
  public function __contrust(EmployeeServices $employeeService)
  {
    $this->employeeService = $employeeService;
  }

  public function getAllUserInfo($oneonId)
  {
    return DB::table('t_employees')
      ->where('t_employees.oneon_id', '!=', $oneonId)
      ->select(DB::raw('
        t_employees.oneon_id,
        concat( t_employees.last_name, " ", t_employees.first_name) as full_name,
        t_employee_tags.job_current_code,
        t_employee_tags.job_past_code,
        t_employee_tags.tag_code,
        concat( t_employee_tags.tag_code, "," , t_employee_tags.job_current_code, "," , t_employee_tags.department_current_code, ",", t_employee_tags.job_past_code, ",", t_employee_tags.department_past_code) as user_tags_for_match,
        t_profile_images.profile_photo_path
    '))
      ->join('t_employee_tags', 't_employees.oneon_id', '=', 't_employee_tags.oneon_id')
      ->leftJoin('t_profile_images', 't_employees.oneon_id', '=', 't_profile_images.oneon_id')
      ->whereRaw('t_employees.deleted_flag <> 1 && t_employee_tags.deleted_flag <> 1')
      ->get();
  }

  public function getJoinSelectSearchTags($selectSkillTags, $selectCurrentDepartmentTags, $selectCurrentJob, $selectPastDepartmentTags, $selectPastJob)
  {
    $resultArray = [];
    if (!empty($selectSkillTags)) {
      $resultArray = array_merge($resultArray, $selectSkillTags);
    } 
    if (!empty($selectCurrentDepartmentTags)) {
      $resultArray = array_merge($resultArray, $selectCurrentDepartmentTags);
    }
    if (!empty($selectCurrentJob)) {
      $resultArray = array_merge($resultArray, $selectCurrentJob);
    }
    if (!empty($selectPastDepartmentTags)) {
      $resultArray = array_merge($resultArray, $selectPastDepartmentTags);
    }
    if (!empty($selectPastJob)) {
      //dd("empty job");
      $resultArray = array_merge($resultArray, $selectPastJob);
    }

    return $resultArray;
  }

  public function getMatchingSearchExecute($allUserInfo, $allSelectSearchTags)
  {
    $resultArray = [];
    $completeMatchUsers = [];
    $partMatchUsers = [];
    $selectSearchTagsCount = count($allSelectSearchTags);
    foreach ($allUserInfo as $user) {
      $userTagsForMatch =  preg_split('/[,]/', $user["user_tags_for_match"]);
      $matchArray = array_intersect($userTagsForMatch, $allSelectSearchTags);
      $matchCount = count($matchArray);
      if (0 < $matchCount) {
        if ($matchCount == $selectSearchTagsCount) {
          array_push($completeMatchUsers, $user);
        } else {
          $user += array('match_count' => $matchCount);
          array_push($partMatchUsers, $user);
        }
      }
    }
    //部分一致の降順
    $ids = array_column($partMatchUsers, 'match_count');
    array_multisort($ids, SORT_DESC, $partMatchUsers);

    if (0 == count($completeMatchUsers) && 0 == count($partMatchUsers)) {
      //マッチングしなかった場合
      return $resultArray;
    } elseif (5 < count($completeMatchUsers)) {
      //完全一致の場合
      return $completeMatchUsers;
    } else {
      //完全一致+部分一致 or 部分一致の場合
      foreach ($partMatchUsers as $partUser) {
        array_push($completeMatchUsers, $partUser);
        if (5 < count($completeMatchUsers)) {
          break;
        }
      }
      return $completeMatchUsers;
    }
  }

  public function getUserTagsSplit($matchingUsersInfo)
  {

    for ($i=0; $i < count($matchingUsersInfo); $i++) {
      $matchingUsersInfo[$i]['tag_code'] = preg_split('/[,]/', $matchingUsersInfo[$i]['tag_code']);
      $matchingUsersInfo[$i]['job_current_code'] = preg_split('/[,]/', $matchingUsersInfo[$i]['job_current_code']);
      $matchingUsersInfo[$i]['job_past_code'] = preg_split('/[,]/', $matchingUsersInfo[$i]['job_past_code']);
    }
    return $matchingUsersInfo;
  }

  public function createMatchingHistory($menteeOneonId, $mentorOneonId, $hopeStance, $menteeMessage)
  {
    $autoReject = new Carbon(Carbon::now());
    $autoHide = new Carbon(Carbon::now());
    $autoRejectExpireDate = date_create($autoReject->addDay(3));
    $autoHideExpireDate = date_create($autoHide->addDay(5));

    $insertData = [];
    $matchingStatus = 1016000;
    for ($i=0; $i < count($mentorOneonId); $i++) {
      array_push($insertData, ['t_matching_histories.mentee_oneon_id' => $menteeOneonId, 't_matching_histories.mentor_oneon_id' => $mentorOneonId[$i] , 't_matching_histories.hope_stance' => $hopeStance, 't_matching_histories.mentee_message' => $menteeMessage, 't_matching_histories.matching_status' => $matchingStatus, 't_matching_histories.auto_reject_expire_date' =>  $autoRejectExpireDate, 't_matching_histories.auto_hide_expire_date' => $autoHideExpireDate,'created_at' => NOW(), 'updated_at' => NOW()]);
    }

    DB::table('t_matching_histories')
      ->insert($insertData);
  }

  public function createTagsSearchHistory($oneonId, $selectSkillTags, $selectCurrentDepartmentTags, $selectCurrentJob, $selectPastDepartmentTags, $selectPastJob)
  {
    DB::table('t_tag_search_histories')
      ->insert(
        ['t_tag_search_histories.oneon_id' => $oneonId, 't_tag_search_histories.tag_code' => $selectSkillTags, 't_tag_search_histories.department_current_code' => $selectCurrentDepartmentTags , 't_tag_search_histories.job_current_code' => $selectCurrentJob , 't_tag_search_histories.department_past_code' => $selectPastDepartmentTags, 't_tag_search_histories.job_past_code' => $selectPastJob ,'created_at' => NOW(), 'updated_at' => NOW()]
      );
  }



}
