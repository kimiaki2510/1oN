@php
  $title = '1oN | 会員登録';
@endphp
@section('title', $title)

@extends('layouts.app')
@push('styles')
  <link href="{{ asset(mix('css/matchingRequest.css')) }}" rel="stylesheet">
  <link href="{{ asset(mix('css/employee.css')) }}" rel="stylesheet">
  <link href="{{ asset(mix('css/home.css')) }}" rel="stylesheet">
@endpush

@section('body')
  <div>
  <div class="">
      <div class="card-background-white card-background-white-mg">
        
      <form method="POST" action="/regist/execute">
        @csrf

        <h3 class="mentor-search-title">あなたにマッチングしたメンター</h3>
        <p class="mentor-search-comment">気になったメンターにチェックを入れて、1oNを申請しましょう！</p>

        <div class="mentor-search-container">
          @foreach ($matchingUsersInfo as $matchingUser)
            <div class="mentor-search-group">
              <div class="mentor-relative">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 36 36"><path d="M0,0H36V36H0Z" fill="none"/><path d="M12.842,17.1a1.936,1.936,0,1,0,1.936,1.936A1.937,1.937,0,0,0,12.842,17.1Zm9.293,0a1.936,1.936,0,1,0,1.936,1.936A1.937,1.937,0,0,0,22.134,17.1ZM17.488,2A15.488,15.488,0,1,0,32.976,17.488,15.494,15.494,0,0,0,17.488,2Zm0,27.878A12.407,12.407,0,0,1,5.1,17.488a12.557,12.557,0,0,1,.077-1.332,15.584,15.584,0,0,0,8.069-8.317A15.448,15.448,0,0,0,25.883,14.39a15.117,15.117,0,0,0,3.485-.4A12.371,12.371,0,0,1,17.488,29.878Z" transform="translate(0.512 0.512)" fill="#ddd"/></svg>
                <div class="stance-checkbox-group mentor-absolute">
                    <input id="{{ $matchingUser['oneon_id'] }}" name="stance[]" value="1088000" class="stance-input-checkbox" type="checkbox">
                    <label for="{{ $matchingUser['oneon_id'] }}" class="stance-laravel-checkbox">✔️</label>
                </div>
              </div>
              <p class="profile-name">{{ $matchingUser['full_name'] }}</p>
              <div class="mentor-search-tag-group">
                @foreach ($matchingUser['job_current_code'] as $jobCurrent)
                  <p class="mentor-search-tag">{{ $jobCurrent }}</p>
                @endforeach
                @foreach ($matchingUser['tag_code'] as $skillTag)
                 <p class="mentor-search-tag">{{ $skillTag }}</p>
                @endforeach
              </div>
            </div>
          @endforeach
          <!-- <br style="clear:both;"/> -->
        </div>

        <div class="mentor-search-message">
          <p>メッセージ</p>
          <textarea class="form-textarea-long" name=""></textarea>
        </div>


        <button type="submit" class="btn-primary-L btn-primary-L-mg-bottom">申請</button>
        <button type="submit" class="btn-sub-S">戻る（再検索）</button>
        </form>
      </div>
    </div>
  </div>
@endsection