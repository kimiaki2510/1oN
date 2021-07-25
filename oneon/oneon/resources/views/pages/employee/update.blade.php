@php
  $title = '1oN | 会員登録';
@endphp
@section('title', $title)

@extends('layouts.app')
@push('styles')
  <link href="{{ asset(mix('css/employee.css')) }}" rel="stylesheet">
@endpush

@section('body')
  <div class="password-container">
    <div class="password-change-link-container">
      <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M0,0H20V20H0Z" fill="none"/><path d="M9,2a7,7,0,1,0,7,7A7,7,0,0,0,9,2Zm.7,11.9H8.3V12.5H9.7Zm1.449-5.425-.63.644A2.383,2.383,0,0,0,9.7,11.1H8.3v-.35a2.818,2.818,0,0,1,.819-1.981l.868-.882A1.369,1.369,0,0,0,10.4,6.9a1.4,1.4,0,1,0-2.8,0H6.2a2.8,2.8,0,1,1,5.6,0A2.227,2.227,0,0,1,11.149,8.475Z" transform="translate(1 1)" fill="rgba(0,0,0,0.38)"/></svg>
      パスワード変更をご希望の方は<a href="#" class="password-change-link">こちら</a>
    </div>
  </div>
  <div class="">
    <div class="card-center">
    <div class="card-background-white">
        
      <form method="POST" action="/employee/update/execute">
        @csrf
        <div class="regist-content-item current-info">
          <h3 class="select-comment">現在のあなたについて教えてください</h3>
          
          <div class="department-container">
            <h4 class="select-title">部署名 <span class="required">※必須（複数選択可）</span></h4>
            <div class="department-group">
              @foreach ($departments as $department)
                <div class="accordion accordion-group" id="accordion" role="tablist" aria-multiselectable="true">
                  <div class="card">
                    <div class="" role="tab" id="headingOne">
                      <h5 class="mb-0 accordion-left">
                        <a class="d-block accordion-title" data-toggle="collapse" href="#{{ $department[0]['department_group_code'] }}0" role="button" aria-expanded="true" aria-controls="collapseOne">
                          {{ $department[0]["department_group_name"] }} 
                        </a>
                      </h5>
                    </div>
                    <div id="{{ $department[0]['department_group_code'] }}0" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                      <div class="">
                        @for ($i=1; $i < count($department); $i++)
                          <div class="accordion-larvel">
                            <input id="{{ $department[$i]['department_code'] }}" name="currentDepartmentTags[]" value="{{ $department[$i]['department_code'] }}" class="{{ in_array($department[$i]['department_code'], $userInfoDepartmentCurrentCode) ? 'accordion-check checked' : 'accordion-check' }}" type="checkbox" >
                            <label for="{{ $department[$i]['department_code'] }}">{{ $department[$i]["department_code_name"] }}</label>
                          </div>
                        @endfor
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <div class="job-group">
            <h4 class="select-title">現在の職種 <span class="required">※必須</span></h4>
            <div class="jobtags">
                <input id="C1086000" name="currentJob[]" value="1086000" class="{{ in_array(1086000, $userInfoJobCurrentCode) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox">
                <label for="C1086000" class="tag-laravel-checkbox">営業</label>

                <input id="C1086001" name="currentJob[]" value="1086001" class="{{ in_array(1086001, $userInfoJobCurrentCode) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox">
                <label for="C1086001" class="tag-laravel-checkbox">企画</label>

                <input id="C1086002" name="currentJob[]" value="1086002" class="{{ in_array(1086002, $userInfoJobCurrentCode) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox">
                <label for="C1086002" class="tag-laravel-checkbox">事務・管理</label>

                <input id="C1086003" name="currentJob[]" value="1086003" class="{{ in_array(1086003, $userInfoJobCurrentCode) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox">
                <label for="C1086003" class="tag-laravel-checkbox">技術職</label>

                <input id="C1086004" name="currentJob[]" value="1086004" class="{{ in_array(1086004, $userInfoJobCurrentCode) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox">
                <label for="C1086004" class="tag-laravel-checkbox">専門職</label>

                <input id="C1086005" name="currentJob[]" value="1086005" class="{{ in_array(1086005, $userInfoJobCurrentCode) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox">
                <label for="C1086005" class="tag-laravel-checkbox">研究職</label>

                <input id="C1086006" name="currentJob[]" value="1086006" class="{{ in_array(1086006, $userInfoJobCurrentCode) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox">
                <label for="C1086006" class="tag-laravel-checkbox">クリエイティブ</label>

                <input id="C1086007" name="currentJob[]" value="1086007" class="{{ in_array(1086007, $userInfoJobCurrentCode) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox">
                <label for="C1086007" class="tag-laravel-checkbox">人事</label>

                <input id="C1086008" name="currentJob[]" value="1086008" class="{{ in_array(1086008, $userInfoJobCurrentCode) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox">
                <label for="C1086008" class="tag-laravel-checkbox">総務</label>

                <input id="C1086009" name="currentJob[]" value="1086009" class="{{ in_array(1086009, $userInfoJobCurrentCode) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox">
                <label for="C1086009" class="tag-laravel-checkbox">経理</label>

                <input id="C1086010" name="currentJob[]" value="1086010" class="{{ in_array(1086010, $userInfoJobCurrentCode) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox">
                <label for="C1086010" class="tag-laravel-checkbox">経営</label>

                <input id="C1086011" name="currentJob[]" value="1086011" class="{{ in_array(1086011, $userInfoJobCurrentCode) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox">
                <label for="C1086011" class="tag-laravel-checkbox">サービス</label>
            </div>
          </div>
        </div>

        <div class="regist-content-item past-info">
          <h3 class="select-comment">これまでのあなたについて教えてください</h3>
          <div class="department-group">

          <div class="department-container">
            <h4 class="select-title">経験部署名 <span class="arbitrarily">※任意（複数選択可）</span></h4>
            <div class="department-group">
              @foreach ($departments as $department)
                <div class="accordion accordion-group" id="accordion" role="tablist" aria-multiselectable="true">
                  <div class="card">
                    <div class="" role="tab" id="headingOne">
                      <h5 class="mb-0 accordion-left">
                        <a class="d-block accordion-title" data-toggle="collapse" href="#{{ $department[0]['department_group_code'] }}1" role="button" aria-expanded="true" aria-controls="collapseOne">
                          {{ $department[0]["department_group_name"] }} 
                        </a>
                      </h5>
                    </div>
                    <div id="{{ $department[0]['department_group_code'] }}1" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                      <div class="">
                        @for ($i=1; $i < count($department); $i++)
                          <div class="accordion-larvel">
                            <input id="{{ $department[$i]['department_code'] }}" name="pastDepartmentTags[]" value="{{ $department[$i]['department_code'] }}" class="{{ in_array($department[$i]['department_code'], $userInfoDepartmentPastCode) ? 'accordion-check checked' : 'accordion-check' }}" type="checkbox" >
                            <label for="{{ $department[$i]['department_code'] }}">{{ $department[$i]["department_code_name"] }}</label>
                          </div>
                        @endfor
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>


          </div>
          <div class="job-group">
            <h4 class="select-title">経験したことのある職種 <span class="arbitrarily">※任意</span></h4>
            <div class="jobtags">
                <input id="P1086000" name="pastJob[]" value="1086000" class="{{ in_array(1086000, $userInfoJobPastCode) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox">
                <label for="P1086000" class="tag-laravel-checkbox">営業</label>

                <input id="P1086001" name="pastJob[]" value="1086001" class="{{ in_array(1086001, $userInfoJobPastCode) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox">
                <label for="P1086001" class="tag-laravel-checkbox">企画</label>

                <input id="P1086002" name="pastJob[]" value="1086002" class="{{ in_array(1086002, $userInfoJobPastCode) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox">
                <label for="P1086002" class="tag-laravel-checkbox">事務・管理</label>

                <input id="P1086003" name="pastJob[]" value="1086003" class="{{ in_array(1086003, $userInfoJobPastCode) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox">
                <label for="P1086003" class="tag-laravel-checkbox">技術職</label>

                <input id="P1086004" name="pastJob[]" value="1086004" class="{{ in_array(1086004, $userInfoJobPastCode) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox">
                <label for="P1086004" class="tag-laravel-checkbox">専門職</label>

                <input id="P1086005" name="pastJob[]" value="1086005" class="{{ in_array(1086005, $userInfoJobPastCode) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox">
                <label for="P1086005" class="tag-laravel-checkbox">研究職</label>

                <input id="P1086006" name="pastJob[]" value="1086006" class="{{ in_array(1086006, $userInfoJobPastCode) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox">
                <label for="P1086006" class="tag-laravel-checkbox">クリエイティブ</label>

                <input id="P1086007" name="pastJob[]" value="1086007" class="{{ in_array(1086007, $userInfoJobPastCode) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox">
                <label for="P1086007" class="tag-laravel-checkbox">人事</label>

                <input id="P1086008" name="pastJob[]" value="1086008" class="{{ in_array(1086008, $userInfoJobPastCode) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox">
                <label for="P1086008" class="tag-laravel-checkbox">総務</label>

                <input id="P1086009" name="pastJob[]" value="1086009" class="{{ in_array(1086009, $userInfoJobPastCode) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox">
                <label for="P1086009" class="tag-laravel-checkbox">経理</label>

                <input id="P1086010" name="pastJob[]" value="1086010" class="{{ in_array(1086010, $userInfoJobPastCode) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox">
                <label for="P1086010" class="tag-laravel-checkbox">経営</label>

                <input id="P1086011" name="pastJob[]" value="1086011" class="{{ in_array(1086011, $userInfoJobPastCode) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox">
                <label for="P1086011" class="tag-laravel-checkbox">サービス</label>
            </div>
          </div>
        </div>

        <div class="regist-content-item skilltag-info">
          <h3 class="select-comment">あなたに当てはまるタグを選びましょう <span class="required">※必須（1つ以上選択）</span></h3>
            <div class="skilltag-group">
              <h4 class="select-title">性別<span class="arbitrarily">※任意</span></h4>
              <div class="skilltags">
                  <input id="men" name="sex" value="1087000" class="{{ in_array(1087000, $userInfoSex) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox" >
                  <label for="men" class="tag-laravel-checkbox">男性</label>

                  <input id="women" name="sex" value="1087001" class="{{ in_array(1087001, $userInfoSex) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox" >
                  <label for="women" class="tag-laravel-checkbox">女性</label>

                  <input id="else" name="sex" value="1087002" class="{{ in_array(1087002, $userInfoSex) ? 'tag-input-checkbox checked' : 'tag-input-checkbox' }}" type="checkbox" >
                  <label for="else" class="tag-laravel-checkbox">その他</label>
              </div>  
            </div>

            @foreach ($skills as $skill)
            <div class="skilltag-group">
              <h4 class="select-title">{{ $skill[0]["tag_group_name"] }} <span class="arbitrarily">※任意</span></h4>
              <div class="skilltags">
                @for ($i=1; $i < count($skill); $i++)
                  <input id="{{ $skill[$i]['tag_code'] }}" name="skillTags[]" value="{{ $skill[$i]['tag_code'] }}" class="{{ in_array($skill[$i]['tag_code'], $userInfoTagCode) ? 'tag-input-checkbox checked' : 'tag-input-checkbox ' }}" type="checkbox" >
                  <label for="{{ $skill[$i]['tag_code'] }}" class="tag-laravel-checkbox">{{ $skill[$i]["tag_code_name"] }}</label>
                @endfor
              </div>  
            </div>
            @endforeach
        </div>

        <button type="submit" class="btn-primary-L">変更</button>
        </form>
      </div>
    </div>
  </div>

　<script>
    var elements = document.getElementsByClassName('checked');
    for (let step = 0; step < elements.length; step++) {
      elements[step].setAttribute('checked', 'checked');
    }
</script>

@endsection