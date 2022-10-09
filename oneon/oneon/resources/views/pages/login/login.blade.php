@php
  $title = '1oN | ログイン';
@endphp
@section('title', $title)

@extends('layouts.app')
@push('styles')
  <link href="{{ asset(mix('css/login.css')) }}" rel="stylesheet">
  <link href="{{ asset(mix('css/matchingRequest.css')) }}" rel="stylesheet">
  <link href="{{ asset(mix('css/home.css')) }}" rel="stylesheet">
@endpush

@section('body')
  <div class="content-container">
    <div class="card-background-white">
      <div>
        <h3 class="login-group-title">ログイン</h3>
      </div>
      <div class="">
        <form method="post" action="/login/execute">
          @csrf

          <div class="login-group">
            <div class="login-input-group">
              <div class="login-title-group">
                <p class="form-item">1ON ID</p>
              </div>
              <div>
                <input class="form-input" type="text" name="oneonid">
              </div>
            </div>
            <div class="login-input-group">
              <div class="login-title-group">
                <p class="form-item">パスワード</p>
              </div>
              <div>
                <input class="form-input" type="password" name="password">
              </div>
            </div>
          </div>

          <button type="submit" id="login" class="btn-primary-L btn-primary-L-mg-bottom">ログイン</button>
        </form>
        <div id="forget-password">パスワードをお忘れの方はこちら</div>
      </div>
    </div>
  </div>

@endsection