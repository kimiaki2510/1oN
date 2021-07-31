@php
  $title = '1oN | マッチング詳細';
@endphp
@section('title', $title)

@extends('layouts.app')
@push('styles')
  <link href="{{ asset(mix('css/style.css')) }}" rel="stylesheet">
  <link href="{{ asset(mix('css/matchingRequest.css')) }}" rel="stylesheet">
  <link href="{{ asset(mix('css/matchingDetails.css')) }}" rel="stylesheet">
@endpush

@section('body')
<!-- 不備箇所 -->
<!-- aタグのリンク先 -->
<!-- ユーザ画像 -->
<!-- 日付変更 -->
<!-- ログインユーザid -->

  <div class="content-container">
    <div class="card-background-white">
      <h3 class="matching-detail-title">メンター依頼</h3>
      <p class="matching-detail-Message">メンターとマッチングしました。当日になったら1on1を開始しましょう!当日の流れは<a class="matching-detail-link" href="#">こちら</a></p>
      <!-- メンティー情報 -->
      <div class="user-group">
        <div class="mentee-reception-image-group">
          <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 36 36"><path d="M0,0H36V36H0Z" fill="none"/><path d="M12.842,17.1a1.936,1.936,0,1,0,1.936,1.936A1.937,1.937,0,0,0,12.842,17.1Zm9.293,0a1.936,1.936,0,1,0,1.936,1.936A1.937,1.937,0,0,0,22.134,17.1ZM17.488,2A15.488,15.488,0,1,0,32.976,17.488,15.494,15.494,0,0,0,17.488,2Zm0,27.878A12.407,12.407,0,0,1,5.1,17.488a12.557,12.557,0,0,1,.077-1.332,15.584,15.584,0,0,0,8.069-8.317A15.448,15.448,0,0,0,25.883,14.39a15.117,15.117,0,0,0,3.485-.4A12.371,12.371,0,0,1,17.488,29.878Z" transform="translate(0.512 0.512)" fill="#ddd"/></svg>
        </div>
        <div class="mentee-reception-info-group">
          <p class="matching-reception-name">{{ $getMatchingDataMentee['last_name'] }} {{ $getMatchingDataMentee['first_name'] }}</p>
          <div class="reception-current-department-container">
            @foreach ($departmentCurrentCodeMentee as $userDepartmentTagName)
              <p class="reception-current-department">{{ $userDepartmentTagName }}</p>
            @endforeach
          </div>
          <div class="mentor-search-tag-group">
            @foreach ($menteeJobCurrentTagNames as $jobCurrent)
                <p class="mentor-search-tag">{{ $jobCurrent }}</p>
            @endforeach
            @foreach ($tagCodeMentee as $skillTag)
              <p class="mentor-search-tag">{{ $skillTag }}</p>
            @endforeach
          </div>
        </div>
        <div class="card-message-white matching-reception-message">
          <p id="mentyIntroduce">{{ $getEmployeeData['mentee_message'] }}</p>
        </div>
      </div>
      <!-- メンター情報 -->
      <div class="user-group">
        <div class="mentee-reception-image-group">
          <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 36 36"><path d="M0,0H36V36H0Z" fill="none"/><path d="M12.842,17.1a1.936,1.936,0,1,0,1.936,1.936A1.937,1.937,0,0,0,12.842,17.1Zm9.293,0a1.936,1.936,0,1,0,1.936,1.936A1.937,1.937,0,0,0,22.134,17.1ZM17.488,2A15.488,15.488,0,1,0,32.976,17.488,15.494,15.494,0,0,0,17.488,2Zm0,27.878A12.407,12.407,0,0,1,5.1,17.488a12.557,12.557,0,0,1,.077-1.332,15.584,15.584,0,0,0,8.069-8.317A15.448,15.448,0,0,0,25.883,14.39a15.117,15.117,0,0,0,3.485-.4A12.371,12.371,0,0,1,17.488,29.878Z" transform="translate(0.512 0.512)" fill="#ddd"/></svg>
        </div>
        <div class="mentee-reception-info-group">
          <p class="matching-reception-name">{{ $getMatchingDataMentor['last_name'] }} {{ $getMatchingDataMentor['first_name'] }}</p>
          <div class="reception-current-department-container">
            @foreach ($departmentCurrentCodeMentor as $userDepartmentTagName)
              <p class="reception-current-department">{{ $userDepartmentTagName }}</p>
            @endforeach
          </div>
          <div class="mentor-search-tag-group">
            @foreach ($mentorJobCurrentTagNames as $jobCurrent)
              <p class="mentor-search-tag">{{ $jobCurrent }}</p>
            @endforeach
            @foreach ($tagCodeMentor as $skillTag)
              <p class="mentor-search-tag">{{ $skillTag }}</p>
            @endforeach
          </div>
        </div>
        <div class="card-message-white matching-reception-message">
          <p id="mentorIntroduce">{{ $getEmployeeData['mentor_message'] }}</p>
        </div>
      </div>
      <h4 class="matching-detail-footer-message">メンティーの{{ $getMatchingDataMentee['last_name'] }}さんがメンターの{{ $getMatchingDataMentor['last_name'] }}さんのスケジュールを入れましょう</h4>
      <p class="matching-detail-link-message">1oN成立後の流れは<a class="matching-detail-link" href="#">こちら</a></p>
      <a href="/home" class="btn-sub-S btn-hover">戻る</a>
    </div>
  </div>

  <script>
    const loginUserId = '{{ $getEmployeeData["mentee_oneon_id"] }}';
    const mentee_oneon_id = '{{ $getEmployeeData["mentee_oneon_id"] }}';
    let elementMenteeInfo = document.getElementById('mentyIntroduce');
    const mentor_oneon_id = '{{ $getEmployeeData["mentor_oneon_id"] }}';
    let elementMentorInfo = document.getElementById('mentorIntroduce');

    //カラー変更
    if(loginUserId == mentee_oneon_id){
      elementMenteeInfo.parentNode.className = 'card-message-fanction';
      elementMenteeInfo.style.color = "#FFFFFF";
    }else if(loginUserId == mentor_oneon_id){
      elementMentorInfo.style.color = "#FFFFFF";
      elementMentorInfo.parentNode.className = 'card-message-fanction';
    }
  </script>
@endsection

