@php
  $title = '1oN | ホーム';
@endphp
@section('title', $title)

@extends('layouts.app')
@push('styles')
  <link href="{{ asset(mix('css/home.css')) }}" rel="stylesheet">
@endpush

@section('body')
  <div class="content-container">
    <div class="home-container">
      <div class="profile-container">
        <div class="profile-image">
        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 36 36"><path d="M0,0H36V36H0Z" fill="none"/><path d="M12.842,17.1a1.936,1.936,0,1,0,1.936,1.936A1.937,1.937,0,0,0,12.842,17.1Zm9.293,0a1.936,1.936,0,1,0,1.936,1.936A1.937,1.937,0,0,0,22.134,17.1ZM17.488,2A15.488,15.488,0,1,0,32.976,17.488,15.494,15.494,0,0,0,17.488,2Zm0,27.878A12.407,12.407,0,0,1,5.1,17.488a12.557,12.557,0,0,1,.077-1.332,15.584,15.584,0,0,0,8.069-8.317A15.448,15.448,0,0,0,25.883,14.39a15.117,15.117,0,0,0,3.485-.4A12.371,12.371,0,0,1,17.488,29.878Z" transform="translate(0.512 0.512)" fill="#ddd"/></svg>
        </div>
        <p class="profile-name">{{ $fullName }}</p>

        <div class="department-container">
          @foreach ($userDepartmentTagNames as $departmentTagName)
            <p class="profile-departmentTag">{{ $departmentTagName }}</p>
          @endforeach
        </div>
        <div class="skilltag-container">
          @foreach ($userJobCurrentTagNames as $jobCurrentTagName)
            <span class="profile-skillTag">{{ $jobCurrentTagName }}</span>
            <br style="clear:both;"/>
          @endforeach
  
          @foreach ($userSkillTagNames as $skillTagName)
            <span class="profile-skillTag">{{ $skillTagName }}</span>
            <br style="clear:both;"/>
          @endforeach
        </div>
        <div class="profile-count-container">
          <p class="profile-count">メンティー回数<span class="profile-num">{{ $menteeTimes }}</span>回</p>
          <p class="profile-count">メンター回数<span class="profile-num">{{ $mentorTimes }}</span>回</p>
        </div>
        <div class="userInfo-change-link-container">
          <a href="/employee/update" class="profile-link"><svg class="profile-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><rect width="16" height="16" fill="none"/><path d="M12.415,8c0-.138-.006-.27-.018-.408l1.095-.846a.611.611,0,0,0,.153-.78l-1.1-1.938a.575.575,0,0,0-.736-.252l-1.266.546a4.446,4.446,0,0,0-.689-.408L9.683,2.528A.594.594,0,0,0,9.1,2h-2.2a.6.6,0,0,0-.589.528L6.146,3.914a4.446,4.446,0,0,0-.689.408L4.192,3.776a.575.575,0,0,0-.736.252l-1.1,1.944a.613.613,0,0,0,.153.78L3.6,7.6c-.012.132-.018.264-.018.4s.006.27.018.408l-1.095.846a.611.611,0,0,0-.153.78l1.1,1.938a.575.575,0,0,0,.736.252l1.266-.546a4.446,4.446,0,0,0,.689.408l.171,1.386A.594.594,0,0,0,6.9,14h2.2a.594.594,0,0,0,.583-.528l.171-1.386a4.446,4.446,0,0,0,.689-.408l1.266.546a.575.575,0,0,0,.736-.252l1.1-1.938a.613.613,0,0,0-.153-.78l-1.095-.846A3.161,3.161,0,0,0,12.415,8ZM8.024,10.1A2.1,2.1,0,1,1,10.084,8,2.083,2.083,0,0,1,8.024,10.1Z" transform="translate(0)" fill="#fbb03b"/></svg>会員情報変更</a>
        </div>
        <div class="userInfo-change-link-container">
          <a href="/matching/history" class="profile-link"><svg class="profile-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path d="M0,0H16V16H0Z" fill="none"/><path d="M7.994,2A6,6,0,1,0,14,8,6,6,0,0,0,7.994,2ZM8,12.8A4.8,4.8,0,1,1,12.8,8,4.8,4.8,0,0,1,8,12.8ZM7.868,5H7.832a.43.43,0,0,0-.432.432V8.264a.594.594,0,0,0,.294.516l2.49,1.494a.429.429,0,1,0,.438-.738L8.3,8.156V5.432A.43.43,0,0,0,7.868,5Z" fill="#fbb03b"/></svg>過去の1oN</a>
        </div>
      </div>
      <div class="main-container">
        <div class="card-background-fanction card-mg-30">
          <h1 class="fs-24 mentor-search-concept" style="color:white;">今のあなたに合うメンターが待っています</h1>
          <div class="btn-mg">
            <a href="/matching/request" class="btn-sub-L mentor-btn">メンターを探す</a>
          </div>
          <img class="image-hand" src="images/illustration/illust_hands2x.png" alt="">
        </div>

        <div class="mentorRequest-container">
          @foreach ($mentorRequests as $mentorRequest)
            <div class="mentorRequest-group card-background-white-match card-mg-30">
              <p class="home-card-title">1oN依頼が来ました</p>
              <div class="menteeUser-container">
                <div class="menteeUser-group">
                  <div class="menteeRequest-image">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 36 36"><path d="M0,0H36V36H0Z" fill="none"/><path d="M12.842,17.1a1.936,1.936,0,1,0,1.936,1.936A1.937,1.937,0,0,0,12.842,17.1Zm9.293,0a1.936,1.936,0,1,0,1.936,1.936A1.937,1.937,0,0,0,22.134,17.1ZM17.488,2A15.488,15.488,0,1,0,32.976,17.488,15.494,15.494,0,0,0,17.488,2Zm0,27.878A12.407,12.407,0,0,1,5.1,17.488a12.557,12.557,0,0,1,.077-1.332,15.584,15.584,0,0,0,8.069-8.317A15.448,15.448,0,0,0,25.883,14.39a15.117,15.117,0,0,0,3.485-.4A12.371,12.371,0,0,1,17.488,29.878Z" transform="translate(0.512 0.512)" fill="#ddd"/></svg>
                  </div>
                  <p class="profile-name">{{ $mentorRequest['full_name'] }}</p>
                </div>
                <div class="menteeUser-message-group">
                  <p class="home-card-mentee-message">{{ $mentorRequest['mentee_message'] }}…</p>
                </div>
              </div>
              <div class="card-btn">
                <form method="post" action="{{ route('matching.reception', ['matchingHistoryId' => $mentorRequest['matching_history_id'], 'menteeOneonId' => $mentorRequest['mentor_oneon_id']]) }}">
                @csrf
                  <button type="submit" class="btn-primary-S card-btn">詳細を見る</button>
                </form>
              </div>
            </div>
          @endforeach
        </div>

        <div class="completion-container">
          @foreach ($completions as $completion)
            <div class="completion-group card-background-white-match card-mg-30">
              <p class="home-card-title">1oN成立</p>
              <p class="home-card-message">マッチングしました。当日までの流れは<a href>こちら</a></p>
              <div class="cardUser-group">
                <div class="menteeRequest-image">
                  <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 36 36"><path d="M0,0H36V36H0Z" fill="none"/><path d="M12.842,17.1a1.936,1.936,0,1,0,1.936,1.936A1.937,1.937,0,0,0,12.842,17.1Zm9.293,0a1.936,1.936,0,1,0,1.936,1.936A1.937,1.937,0,0,0,22.134,17.1ZM17.488,2A15.488,15.488,0,1,0,32.976,17.488,15.494,15.494,0,0,0,17.488,2Zm0,27.878A12.407,12.407,0,0,1,5.1,17.488a12.557,12.557,0,0,1,.077-1.332,15.584,15.584,0,0,0,8.069-8.317A15.448,15.448,0,0,0,25.883,14.39a15.117,15.117,0,0,0,3.485-.4A12.371,12.371,0,0,1,17.488,29.878Z" transform="translate(0.512 0.512)" fill="#ddd"/></svg>
                </div>
                <p class="profile-name">{{ $completion['full_name'] }}</p>
              </div>
              <div class="card-btn">
                <!-- <form method="get" action="{{ route('matching.detail.init', ['matchingHistoryId' => $completion['matching_history_id'], 'menteeOneonId' => $completion['mentor_oneon_id']]) }}"> -->
                <form method="get" action="/matchingDetails">
                  @csrf
                  <input type="hidden" name="matchingHistoryId" value="{{ $completion['matching_history_id'] }}">
                  <input type="hidden" name="menteeOneonId" value="{{ $completion['mentor_oneon_id'] }}">
                  <button type="submit" class="btn-primary-S card-btn">詳細を見る</button>
                </form>
              </div>
            </div>
          @endforeach
        </div>

        @if (!empty($menteeRequests))
        <div class="menteeRequest-container">
          <div class="menteeRequest-group card-background-white-Request card-mg-30">
            <p class="home-card-title">マッチング申請中...</p>
            <p class="home-card-message">申請しています。マッチングまで今しばらくお待ちください。</p>
            @foreach ($menteeRequests as $menteeRequest)
              <div class="cardUser-group">
                <div class="menteeRequest-image">
                  <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 36 36"><path d="M0,0H36V36H0Z" fill="none"/><path d="M12.842,17.1a1.936,1.936,0,1,0,1.936,1.936A1.937,1.937,0,0,0,12.842,17.1Zm9.293,0a1.936,1.936,0,1,0,1.936,1.936A1.937,1.937,0,0,0,22.134,17.1ZM17.488,2A15.488,15.488,0,1,0,32.976,17.488,15.494,15.494,0,0,0,17.488,2Zm0,27.878A12.407,12.407,0,0,1,5.1,17.488a12.557,12.557,0,0,1,.077-1.332,15.584,15.584,0,0,0,8.069-8.317A15.448,15.448,0,0,0,25.883,14.39a15.117,15.117,0,0,0,3.485-.4A12.371,12.371,0,0,1,17.488,29.878Z" transform="translate(0.512 0.512)" fill="#ddd"/></svg>
                </div>
                <p class="profile-name">{{ $menteeRequest['full_name'] }}</p>
              </div>
            @endforeach
          </div>
        </div>
        @endif

        <div class="mentorRequest-container">
          @foreach ($notMatchings as $notMatching)
            <div class="mentorRequest-group card-background-not-match card-mg-30">
              <p class="home-card-title">マッチング未成立</p>
              <p class="home-card-notMatch-message">※こちらのメッセージは24時間で自動的に非表示となります</p>
              <div class="menteeUser-container">
                <div class="menteeUser-group">
                  <div class="menteeRequest-image">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 36 36"><path d="M0,0H36V36H0Z" fill="none"/><path d="M12.842,17.1a1.936,1.936,0,1,0,1.936,1.936A1.937,1.937,0,0,0,12.842,17.1Zm9.293,0a1.936,1.936,0,1,0,1.936,1.936A1.937,1.937,0,0,0,22.134,17.1ZM17.488,2A15.488,15.488,0,1,0,32.976,17.488,15.494,15.494,0,0,0,17.488,2Zm0,27.878A12.407,12.407,0,0,1,5.1,17.488a12.557,12.557,0,0,1,.077-1.332,15.584,15.584,0,0,0,8.069-8.317A15.448,15.448,0,0,0,25.883,14.39a15.117,15.117,0,0,0,3.485-.4A12.371,12.371,0,0,1,17.488,29.878Z" transform="translate(0.512 0.512)" fill="#ddd"/></svg>
                  </div>
                  <p class="profile-name">{{ $notMatching['full_name'] }}</p>
                </div>
                <div class="menteeUser-message-group">
                  <p class="home-card-mentee-message">{{ $notMatching['mentee_message'] }}</p>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div class="mentorRequest-container">
          @foreach ($autoNotMatchings as $autoNotMatching)
            <div class="mentorRequest-group card-background-not-match card-mg-30">
              <p class="home-card-title">マッチング未成立</p>
              <p class="home-card-notMatch-message">※3営業日以内にリアクションがなかったため、未成立となりました。<br>※こちらのメッセージは24時間で自動的に非表示となります</p>
              <div class="menteeUser-container">
                <div class="menteeUser-group">
                  <div class="menteeRequest-image">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 36 36"><path d="M0,0H36V36H0Z" fill="none"/><path d="M12.842,17.1a1.936,1.936,0,1,0,1.936,1.936A1.937,1.937,0,0,0,12.842,17.1Zm9.293,0a1.936,1.936,0,1,0,1.936,1.936A1.937,1.937,0,0,0,22.134,17.1ZM17.488,2A15.488,15.488,0,1,0,32.976,17.488,15.494,15.494,0,0,0,17.488,2Zm0,27.878A12.407,12.407,0,0,1,5.1,17.488a12.557,12.557,0,0,1,.077-1.332,15.584,15.584,0,0,0,8.069-8.317A15.448,15.448,0,0,0,25.883,14.39a15.117,15.117,0,0,0,3.485-.4A12.371,12.371,0,0,1,17.488,29.878Z" transform="translate(0.512 0.512)" fill="#ddd"/></svg>
                  </div>
                  <p class="profile-name">{{ $autoNotMatching['full_name'] }}</p>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div class="article-container">
          @foreach ($articlesInfo as $article)
            <div class="article-background-card">
              <div class="article-image-group">
              <img class="article-image" width="20" src="images/illustration/thumbnail_knowhow1@2x.png" alt="">
              </div>
              <div class="article-content">
                <p class="article-title">{{ $article['article_title'] }}</p>
                <p class="article-message">{{ $article['article_message'] }}</p>
                <a href="{{ $article['article_url'] }}" class="article-link">詳細はこちら</a>
              </div>
            </div>
          @endforeach
        </div>

        <a href="https://rondtkayk111.notion.site/1oN-e0594989b1aa499693f2f385b4b4cae2" class="btn-sub-S btn-hover">過去の記事をもっと見る</a>

      </div>
    </div>
  </div>
@endsection
