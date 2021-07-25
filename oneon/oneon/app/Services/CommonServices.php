<?php

namespace App\Services;

// use DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\SkillTags;
use App\Services\HomeServices;

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

  public function getOneonStanceNames($stance_code)
  {
    return DB::table('m_codes')
    ->select(DB::raw('
      m_codes.code_name
    '))
    ->whereRaw("
      m_codes.deleted_flag <> 1
      AND m_codes.code IN ($stance_code)
    ")
    ->get();
  }

  public function arrayArrange($array, $code_name) {
    $resultArray = [];

    foreach ($array as $a) {
      // $a = json_decode(json_encode($a, true));
      array_push($resultArray, $a->$code_name);
    }
    return $resultArray;
  }

  public function getJoinParameter($array)
  {
    if ($array != null) {
      return join(',', $array);
    }
    return NULL;
  }

    //社員履歴登録処理
    public function createEmployeeHistory($oneonId)
    {
      $employeeInformation = $this->employeeInformation($oneonId);
      DB::table('t_employee_histories')
      ->insert(
        [
        'oneon_id' => $employeeInformation->oneon_id
        , 'employee_number' => $employeeInformation->employee_number
        , 'last_name' => $employeeInformation->last_name
        , 'first_name' => $employeeInformation->first_name
        , 'sex' => $employeeInformation->sex
        , 'authority_status' => $employeeInformation->authority_status
        , 'member_status' => $employeeInformation->member_status
        , 'oneon_temporary_admission_date' => $employeeInformation->oneon_temporary_admission_date
        , 'oneon_admission_date' => $employeeInformation->oneon_admission_date
        , 'temporary_expire_date' => $employeeInformation->temporary_expire_date
        , 'one_time_password_expire_date' => $employeeInformation->one_time_password_expire_date
        , 'mail_address_temporary' => $employeeInformation->mail_address_temporary
        , 'mail_address' => $employeeInformation->mail_address
        , 'mentee_times' => $employeeInformation->mentee_times
        , 'mentor_times' => $employeeInformation->mentor_times
        , 'withdrawal_at' => $employeeInformation->withdrawal_at
        , 'destination_designation_flag' => $employeeInformation->destination_designation_flag
        , 'deleted_flag' => $employeeInformation->deleted_flag
        , 'created_at' => NOW()
        , 'updated_at' => NOW()]
      );
    }
  
  
    public function employeeInformation($oneonId)
    {
      return DB::table('t_employees')
        ->select(DB::raw('
        employee_id
        ,oneon_id
        ,employee_number
        ,last_name
        ,first_name
        ,sex
        ,authority_status
        ,member_status
        ,oneon_temporary_admission_date
        ,oneon_admission_date
        ,temporary_expire_date
        ,one_time_password_expire_date
        ,mail_address_temporary
        ,mail_address
        ,mentee_times
        ,mentor_times
        ,withdrawal_at
        ,destination_designation_flag
        ,deleted_flag
        ,version
        '))
        ->first();
    }


}
