<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MatchingExecuteRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    if ($this->path() == 'matching/request/execute')
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
      'matchOneonId' => 'required',
      'messageText' => 'required|between:0,400',
    ];
  }

  public function messages()
  {
      return [
        'matchOneonId.required' => trans('messages.ONEON0001', ['「メンター」']),
        'matchOneonId.required' => trans('messages.ONEON0002', ['「メッセージ」']),
        'matchOneonId.between' => trans('messages.ONEON0003'),
    ];
  }
}
