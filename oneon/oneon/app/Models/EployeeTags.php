<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EployeeTags extends Model
{
    //テーブル名
    protected $table = 't_employee_tags';

    //主キーのリセット
    protected $primaryKey = 't_employee_tag_id';
}
