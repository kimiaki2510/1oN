<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MatchingSearchRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    if ($this->path() == 'matching/search')
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
      'stance' => 'required',
      'skillTags' => 'required',
    ];
  }

  public function messages()
  {
    return [
      'stance.required' => trans('messages.ONEON0001', ['「1oNのスタンス」']),
      'skillTags.required' => trans('messages.ONEON0001', ['「希望するメンターのタグ」']),
    ];
  }
}
