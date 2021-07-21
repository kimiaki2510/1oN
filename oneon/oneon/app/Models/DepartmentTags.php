<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentTags extends Model
{
    //テーブル名
    protected $table = 't_department_tags';

    //主キーのリセット
    protected $primaryKey = 'department_tag_id';
}
