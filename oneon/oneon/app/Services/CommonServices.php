<?php

namespace App\Services;

// use DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\SkillTags;

class CommonServices
{
  public function __contrust(SkillTags $skillTags)
  {
    $this->skillTags = $skillTags;
  }

  //スキルタグ名を取得
  public function getUserSkillTagNames($userInfoTagCode)
  {
    $arrays = DB::table('t_skill_tags')
    ->select(DB::raw('
      t_skill_tags.tag_code_name
    '))
    ->whereRaw("
      t_skill_tags.deleted_flag <> 1
      AND t_skill_tags.tag_code IN ($userInfoTagCode)
    ")
    ->get();

    $result = $this->arrayArrange($arrays, "tag_code_name");
    return $result;
  }

  //部署タグ名を取得
  public function getUserFullDepartmentTagNames($department_current_code)
  {
    $arrays = DB::table('t_department_tags')
    ->select(DB::raw('
      concat( t_department_tags.department_group_name, "/", t_department_tags.department_code_name) as full_department_name
    '))
    ->whereRaw("
      t_department_tags.deleted_flag <> 1
      AND t_department_tags.department_code IN ($department_current_code)
    ")
    ->get();

    $result = $this->arrayArrange($arrays, "full_department_name");
    return $result;
  }

  //職種タグ名を取得
  public function getUserJobCurrentTagNames($job_current_code)
  {
    $arrays = DB::table('m_codes')
    ->select(DB::raw('
      m_codes.code_name
    '))
    ->whereRaw("
      m_codes.deleted_flag <> 1
      AND m_codes.code IN ($job_current_code)
    ")
    ->get();

    $result = $this->arrayArrange($arrays, "code_name");
    return $result;
  }

  public function arrayArrange($array, $code_name) {
    $resultArray = [];

    foreach ($array as $a) {
      // $a = json_decode(json_encode($a, true));
      array_push($resultArray, $a->$code_name);
    }
    return $resultArray;
  }



}
