@php
  $title = '1oN | パスワード再発行';
@endphp
@section('title', $title)

@extends('layouts.app')
@push('styles')
<link href="{{ asset(mix('css/password.css')) }}" rel="stylesheet">
  <link href="{{ asset(mix('css/matchingRequest.css')) }}" rel="stylesheet">
  <link href="{{ asset(mix('css/home.css')) }}" rel="stylesheet">
@endpush

@section('body')
<div class="content-container">
    <div class="card-background-white">
      <div>
        <h3 class="password-group-title">パスワード再発行</h3>
      </div>
      <div class="">
        <form method="post" action="">
          <div class="password-group">
            <div class="password-input-group">
              <div class="password-title-group">
                <p class="password-title">メールアドレス</p>
              </div>
              <div>
                <input class="form-input" type="mail">
              </div>
            </div>

          <button type="submit" class="btn-primary-L btn-primary-L-mg-bottom">メール送信</button>
        </form>
      </div>
    </div>
  </div>

@endsection