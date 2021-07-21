<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class SkillTags extends Model
{
  //テーブル名
  protected $table = 't_skill_tags';

  //主キーのリセット
  protected $primaryKey = 'skill_tag_id';
}
