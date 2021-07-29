@php
  $title = '1oN | パスワード変更';
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
        <h3 class="password-group-title">パスワード設定</h3>
      </div>
      <div class="">
        <form method="post" action="">
          <div class="password-group">
            <div class="password-input-group">
              <div class="password-title-group">
                <p class="password-title">新しいパスワード<span class="password-required">※半角英数8文字以上</span></p>
              </div>
              <div>
                <input class="form-input" type="password">
              </div>
            </div>
            <div class="password-input-group">
              <div>
                <p class="password-title">新しいパスワード（確認用）</p>
              </div>
              <div>
                <input class="form-input" type="password">
              </div>
            </div>
          </div>

          <button type="submit" class="btn-primary-L btn-primary-L-mg-bottom">変更</button>
        </form>
      </div>
    </div>
  </div>

@endsection