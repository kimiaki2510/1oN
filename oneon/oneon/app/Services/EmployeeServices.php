<?php

namespace App\Services;

// use DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\SkillTags;

class EmployeeServices
{
  public function __contrust(SkillTags $skillTags)
  {
    $this->skillTags = $skillTags;
  }

  public function getSkillTags()
  {

    return DB::table('t_skill_tags')
      ->select(DB::raw('
        t_skill_tags.tag_group_code,
        t_skill_tags.tag_group_name,
        t_skill_tags.tag_code,
        t_skill_tags.tag_code_name,
        t_skill_tags.display_order
      '))
      ->whereRaw('t_skill_tags.deleted_flag <> 1')
      ->get();
  }

  public function getTagGroups()
  {

    return DB::table('t_skill_tags')
      ->select(DB::raw('
        t_skill_tags.tag_group_code,
        t_skill_tags.tag_group_name
      '))
      ->distinct()
      ->get();
  }

  public function getDepartmentTags()
  {

    return DB::table('t_department_tags')
      ->select(DB::raw('
        department_group_code,
        department_group_name,
        department_code,
        department_code_name,
        display_order
      '))
      ->whereRaw('t_department_tags.deleted_flag <> 1')
      ->get();
  }

  public function getDepartmentGroups()
  {

    return DB::table('t_department_tags')
      ->select(DB::raw('
        department_group_code,
        department_group_name
      '))
      ->distinct()
      ->get();
  }

  public function getJoinParameter($array)
  {
    if ($array != null) {
      return join(',', $array);
    }
    return NULL;
  }

  public function createEmployeeTags($oneonId, $currentDepartmentTags, $pastDepartmentTags, $currentJob, $pastJob, $skillTags)
  {
    DB::table('t_employee_tags')
      ->insert(
        ['t_employee_tags.oneon_id' => $oneonId, 't_employee_tags.department_current_code' => $currentDepartmentTags, 't_employee_tags.department_past_code' => $pastDepartmentTags, 't_employee_tags.job_current_code' => $currentJob, 't_employee_tags.job_past_code' => $pastJob, 't_employee_tags.tag_code' => $skillTags, 'created_at' => NOW(), 'updated_at' => NOW()]
      );
  }

  public function updateRegistEmployee($oneonId, $sex)
  {
    DB::table('t_employees')
      ->where('oneon_id', $oneonId)
      ->update([
        'sex' => $sex,
        'member_status' => '10860001',
        'oneon_admission_date' => NOW(),
        'temporary_expire_date' => NULL,
        'one_time_password_expire_date' => NULL,
        'mail_address' => NULL,
        'destination_designation_flag' => '1',
        'updated_at' => NOW()
      ]);

    DB::table('t_employees')
      ->where('oneon_id', $oneonId)->increment('version');
  }

  public function getSkillTagsProcessing($allGroups, $allTags)
  {
    $allInfo = [];
    $tmpGroup = [];

    foreach ($allGroups as $group) {
      $tmpGroup = [$group];
      foreach ($allTags as $tag) {
        if ($tag["tag_group_code"] == $group["tag_group_code"]) {
          array_push($tmpGroup, $tag);
        }
      }
      array_push($allInfo, $tmpGroup);
    }

    return $allInfo;
  }

  public function getDepartmentTagsProcessing($allGroups, $allTags)
  {
    $allInfo = [];
    $tmpGroup = [];

    foreach ($allGroups as $group) {
      $tmpGroup = [$group];
      foreach ($allTags as $tag) {
        if ($tag["department_group_code"] == $group["department_group_code"]) {
          array_push($tmpGroup, $tag);
        }
      }
      array_push($allInfo, $tmpGroup);
    }

    return $allInfo;
  }

  public function getEmployeeInfoByOneonId($oneonId)
  {
    return DB::table('t_employees')
      ->where('t_employees.oneon_id', $oneonId)
      ->select(DB::raw('
        t_employees.oneon_id,
        t_employees.last_name,
        t_employees.first_name,
        t_employees.sex,
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

  public function getTagCodeSplitExecute($code)
  {
    $result =  preg_split('/[,]/', $code);
    return $result;
  }

  public function updateEmployee($oneonId, $sex)
  {
    DB::table('t_employees')
      ->where('oneon_id', $oneonId)
      ->update([
        'sex' => $sex,
        'updated_at' => NOW()
      ]);

    DB::table('t_employees')
      ->where('oneon_id', $oneonId)->increment('version');
  }

  public function updateEmployeeTags($oneonId, $currentDepartmentTags, $pastDepartmentTags, $currentJob, $pastJob, $skillTags)
  {
    DB::table('t_employee_tags')
      ->where('oneon_id', $oneonId)
      ->update([
        't_employee_tags.department_current_code' => $currentDepartmentTags,
        't_employee_tags.department_past_code' => $pastDepartmentTags,
        't_employee_tags.job_current_code' => $currentJob,
        't_employee_tags.job_past_code' => $pastJob,
        't_employee_tags.tag_code' => $skillTags,
        'updated_at' => NOW()
      ]);

    DB::table('t_employee_tags')
      ->where('oneon_id', $oneonId)->increment('version');

  }



}
