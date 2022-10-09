<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatchingDetails1onCompletionServices
{
    /**
     * マッチングデータの取得
     * 
     */
    public function getMatchingData($matchingHistoryId){
        return DB::table('t_matching_histories')
        ->select(DB::raw('
            t_matching_histories.mentee_oneon_id
            ,t_matching_histories.mentor_oneon_id
            ,t_matching_histories.mentee_message
            ,t_matching_histories.mentor_message
        '))
        ->whereRaw("t_matching_histories.matching_history_id = '$matchingHistoryId'")
        ->first();
    }
    
    /**
     * 社員情報取得
     * 使用していない
     * 
     */
    public function getEmployeesData($menteeOneOnId, $mentorOneOnId){
        return DB::table('t_employees')
        ->join('t_employee_tags', 't_employees.oneon_id', '=', 't_employee_tags.oneon_id')
        ->leftJoin('t_profile_images', 't_employees.oneon_id', '=', 't_profile_images.oneon_id')
        ->select(DB::raw('
            t_employees.oneon_id
            ,t_employees.last_name
            ,t_employees.first_name
            ,t_employee_tags.department_current_code
            ,t_employee_tags.department_past_code
            ,t_employee_tags.tag_code
            ,t_profile_images.profile_photo_path
        '))
        ->whereIn('t_employees.oneon_id' , [$menteeOneOnId, $mentorOneOnId])
        ->whereRaw('t_employees.deleted_flag <> 1')
        ->get();
    }

    /**
     * 社員情報取得
     * 
     */
    public function getEmployeeData($employeeneOnId){
        return DB::table('t_employees')
        ->join('t_employee_tags', 't_employees.oneon_id', '=', 't_employee_tags.oneon_id')
        ->leftJoin('t_profile_images', 't_employees.oneon_id', '=', 't_profile_images.oneon_id')
        ->select(DB::raw('
            t_employees.oneon_id
            ,t_employees.last_name
            ,t_employees.first_name
            ,t_employee_tags.department_current_code
            ,t_employee_tags.department_past_code
            ,t_employee_tags.tag_code
            ,t_employee_tags.job_current_code
            ,t_profile_images.profile_photo_path
        '))
        ->whereRaw("t_employees.oneon_id = '$employeeneOnId'")
        ->whereRaw('t_employees.deleted_flag <> 1')
        ->first();
    }

    public function matchingHistoryList($oneonId) {
        return DB::table('t_matching_histories')
        ->select(DB::raw('
            mentee_oneon_id
            ,mentor_oneon_id
            ,mentee_message
            ,mentor_message
            ,date_format(updated_at, "%Y/%m/%d") as updated_at
        '))
        ->whereRaw("
        matching_status = '1016001'
        AND (mentee_oneon_id = '$oneonId'
        OR mentor_oneon_id = '$oneonId')
        ")
        ->orderByRaw('updated_at DESC')
        ->get();
    }

    //一致する社員データ一覧の取得
    public function getUserList ($userList) {
        return DB::table('t_employees')
        ->join('t_employee_tags', 't_employees.oneon_id', '=', 't_employee_tags.oneon_id')
        ->leftJoin('t_profile_images', 't_employees.oneon_id', '=', 't_profile_images.oneon_id')
        ->select(DB::raw('
            t_employees.oneon_id
            ,t_employees.last_name
            ,t_employees.first_name
            ,t_employee_tags.department_current_code
            ,t_employee_tags.department_past_code
            ,t_employee_tags.tag_code
            ,t_employee_tags.job_current_code
            ,t_profile_images.profile_photo_path
        '))
        ->whereRaw("t_employees.oneon_id = '$userList'")
        ->whereRaw('t_employees.deleted_flag <> 1')
        ->get();
    }
}