<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DefinitiveRegistRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    if ($this->path() == 'regist/execute')
    {
      return true;
    } else {
      return false;
    }

  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'currentDepartmentTags' => 'required',
      'currentJob' => 'required',
      'sex' => 'required',
      'skillTags' => 'required',
    ];
  }

  public function messages()
  {
    return [
      'currentDepartmentTags.required' => trans('messages.ONEON0001', ['「現在の部署」']),
    'currentJob.required' => trans('messages.ONEON0001', ['「現在の職種」']),
    // 'sex.required' => trans('messages.ONEON0001', ['「性別」']),
    'skillTags.required' => trans('messages.ONEON0001', ['「自分自身を表すタグ」']),
    ];
  }

}
