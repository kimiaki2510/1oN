@php
  $title = '1oN | マッチング詳細';
@endphp
@section('title', $title)

@extends('layouts.app')
@push('styles')
  <link href="{{ asset(mix('css/style.css')) }}" rel="stylesheet">
  <link href="{{ asset(mix('css/matchingDetails.css')) }}" rel="stylesheet">
@endpush

@section('body')
<!-- 不備箇所 -->
<!-- aタグのリンク先 -->
<!-- ユーザ画像 -->
<!-- ログインユーザid -->

  <div class="card-background-white" style="text-align: center;">
    <h1 id="actionTitle" class="actionTitle">1oN成立</h1>
    <p id="actionMessage" class="actionMessage">メンターとマッチングしました。当日になったら1on1を開始しましょう!当日の流れは<a class="link" href="#">こちら</a></p>
    <div>
      <!-- メンティー情報 -->
      <div id="mentyPhoto" class="mentyPhoto" name="profile_photo_path">
        <img class="icon_profile" src="images/icon/icon_profile.svg" alt="icon_profile">
      </div>
      <div id="mentyName" class="mentyName" name="fill_name">{{ $getMatchingDataMentee['last_name'] }}{{ $getMatchingDataMentee['first_name'] }}</div>
      <div id="mentyInfo" class="mentyInfo" name="departmentCode">{{ $departmentCurrentCodeMentee[0] }}</div>
      <div>
        @foreach ($tagCodeMentee as $tagMentee)
          <p class="tag-selected-cols" style="margin-bottom: 0px;">{{ $tagMentee }}</p>
        @endforeach
      </div>
    </div>
    <div class="card-message-white">
      <p id="mentyIntroduce" class="mentyIntroduce" name="mentee_message" value=''>{{ $getEmployeeData['mentee_message'] }}</p>
    </div>
    <!-- メンター情報 -->
    <div>
      <div id="mentorPhoto" class="mentorPhoto">
      <img class="icon_profile" src="images/icon/icon_profile.svg" alt="icon_profile">
      </div>
      <div id="mentorName" class="mentorName" name="fullName">{{ $getMatchingDataMentor['last_name'] }}{{ $getMatchingDataMentor['first_name'] }}</div>
      <div id="mentorInfo" class="mentorInfo">{{ $departmentCurrentCodeMentor[0] }}</div>
        @foreach ($tagCodeMentor as $tagMentor)
          <p class="tag-selected-cols" style="margin-bottom: px;">{{ $tagMentor }}</p>
        @endforeach
      </div>
      <div class="card-message-white">
        <p id="menorIntroduce" class="mentorIntroduce" name="mentee_message" value=''>{{ $getEmployeeData['mentor_message'] }}</p>
      </div>
      <h4 id="actionFooterMessage" class="actionFooterMessage">メンティーの{{ $getMatchingDataMentee['last_name'] }}さんがメンターの{{ $getMatchingDataMentor['last_name'] }}さんのスケジュールを入れましょう</h4>
      <p id="footerMessage" class="footerMessage">1oN成立後の流れは<a class="link" href="#">こちら</a></p>
      <form name="form" action="/home" method="GET">
        <div class="btn-mg">
          <button type="submit" class="btn-sub-S" id="returnBtn" class="returnBtn">戻る</button>
        </div>
        <div class="abc">
          <div id="def" class="def"></div>
        </div>
      </form>
    </div>
  </div>
  <script>
    const loginUserId = '{{ $getEmployeeData['mentee_oneon_id'] }}';
    const mentee_oneon_id = '{{ $getEmployeeData['mentee_oneon_id'] }}';
    let elementMenteeInfo = document.getElementById('mentyIntroduce');
    const mentor_oneon_id = '{{ $getEmployeeData['mentor_oneon_id'] }}';
    let elementMentorInfo = document.getElementById('menorIntroduce');

    // 戻るボタン
    document.getElementById('returnBtn').onClick = function(){
      document.form.submit();
    }

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

