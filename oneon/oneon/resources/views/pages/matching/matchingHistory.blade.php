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
<!-- カードの間隔 -->
<!-- ログインID -->
  @for ($i=0; $i < count($matchingHistoryList); $i++)
    <div class="content-container">
      <!-- 日時表示 -->
      <div class="matching-date" style="font-family: Meiryo; font-size: 15px; font-weight: bold;">{{ $matchingHistoryList[$i]['updated_at'] }} {{ $DayOfWeek[$i]}}</div>
      <div class="card-background-white">
        <p class="matching-detail-title">1oN成立</p>
        <p class="matching-detail-Message">メンターとマッチングしました。当日になったら1on1を開始しましょう!当日の流れは<a class="matching-detail-link" href="#">こちら</a></p>
        <!-- メンティー情報 -->
        <div class="user-group">
          <div class="mentee-reception-image-group">
            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 36 36"><path d="M0,0H36V36H0Z" fill="none"/><path d="M12.842,17.1a1.936,1.936,0,1,0,1.936,1.936A1.937,1.937,0,0,0,12.842,17.1Zm9.293,0a1.936,1.936,0,1,0,1.936,1.936A1.937,1.937,0,0,0,22.134,17.1ZM17.488,2A15.488,15.488,0,1,0,32.976,17.488,15.494,15.494,0,0,0,17.488,2Zm0,27.878A12.407,12.407,0,0,1,5.1,17.488a12.557,12.557,0,0,1,.077-1.332,15.584,15.584,0,0,0,8.069-8.317A15.448,15.448,0,0,0,25.883,14.39a15.117,15.117,0,0,0,3.485-.4A12.371,12.371,0,0,1,17.488,29.878Z" transform="translate(0.512 0.512)" fill="#ddd"/></svg>
          </div>
          <div class="mentee-reception-info-group">
            <p class="matching-reception-name">{{ $mentee[$i][0]['last_name'] }} {{ $mentee[$i][0]['first_name'] }}</p>
            <div class="reception-current-department-container">
              @foreach ($menteeDepCurrent[$i] as $menteeCurrentDep)
                <p class="reception-current-department">{{ $menteeCurrentDep }}</p>
              @endforeach
            </div>
            <div class="mentor-search-tag-group">
              @foreach ($menteeJobCurrentTagNames[$i] as $jobCurrent)
                  <p class="mentor-search-tag">{{ $jobCurrent }}</p>
              @endforeach
              @foreach ($menteeTagCode[$i] as $skillTag)
                <p class="mentor-search-tag">{{ $skillTag }}</p>
              @endforeach
            </div>
          </div>
          <div class="card-message-white matching-reception-message">
            <p class="mentyIntroduce">{{ $matchingHistoryList[$i]['mentee_message'] }}</p>
          </div>
        </div>
        <!-- メンター情報 -->
        <div class="user-group">
          <div class="mentee-reception-image-group">
            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 36 36"><path d="M0,0H36V36H0Z" fill="none"/><path d="M12.842,17.1a1.936,1.936,0,1,0,1.936,1.936A1.937,1.937,0,0,0,12.842,17.1Zm9.293,0a1.936,1.936,0,1,0,1.936,1.936A1.937,1.937,0,0,0,22.134,17.1ZM17.488,2A15.488,15.488,0,1,0,32.976,17.488,15.494,15.494,0,0,0,17.488,2Zm0,27.878A12.407,12.407,0,0,1,5.1,17.488a12.557,12.557,0,0,1,.077-1.332,15.584,15.584,0,0,0,8.069-8.317A15.448,15.448,0,0,0,25.883,14.39a15.117,15.117,0,0,0,3.485-.4A12.371,12.371,0,0,1,17.488,29.878Z" transform="translate(0.512 0.512)" fill="#ddd"/></svg>
          </div>
          <div class="mentee-reception-info-group">
            <p class="matching-reception-name">{{ $mentor[$i][0]['last_name'] }} {{ $mentor[$i][0]['first_name'] }}</p>
            <div class="reception-current-department-container">
              @foreach ($mentorDepCurrent[$i] as $userDepartmentTagName)
                <p class="reception-current-department">{{ $userDepartmentTagName }}</p>
              @endforeach
            </div>
            <div class="mentor-search-tag-group">
              @foreach ($mentorJobCurrentTagNames[$i] as $jobCurrent)
                <p class="mentor-search-tag">{{ $jobCurrent }}</p>
              @endforeach
              @foreach ($mentorTagCode[$i] as $skillTag)
                <p class="mentor-search-tag">{{ $skillTag }}</p>
              @endforeach
            </div>
          </div>
          <div class="card-message-white matching-reception-message">
            <p class="mentorIntroduce">{{ $matchingHistoryList[$i]['mentor_message'] }}</p>
          </div>
        </div>
        <a href="/home" class="btn-sub-S btn-hover">戻る</a>
      </div>
    </div>
  @endfor
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script>
  //メッセージの色加工
    const loginUserId = '1000000001';
    let elementMenteeInfo = document.getElementsByClassName('mentyIntroduce');
    let elementMentorInfo = document.getElementsByClassName('mentorIntroduce');
    let matchingHistoryList = @json($matchingHistoryList);
    for (let i = 0; i < matchingHistoryList.length; i++) {
      //ワンオンid取得
      let mentee_oneon_id = matchingHistoryList[i]['mentee_oneon_id'];
      let mentor_oneon_id = matchingHistoryList[i]['mentor_oneon_id'];
      //ログインユーザと同値のワンオンidがある方のカラーを変更
      if(loginUserId == mentee_oneon_id){
        elementMenteeInfo[i].parentNode.className = 'card-message-fanction';
        elementMenteeInfo[i].style.color = "#FFFFFF";
      }else if(loginUserId == mentor_oneon_id){
        elementMentorInfo[i].style.color = "#FFFFFF";
        elementMentorInfo[i].parentNode.className = 'card-message-fanction';
      }
    }
  </script>
@endsection

