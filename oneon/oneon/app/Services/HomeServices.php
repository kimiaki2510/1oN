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

}
