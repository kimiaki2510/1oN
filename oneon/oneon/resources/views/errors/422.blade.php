<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>エラー</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('scripts')
    @yield('script')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
    <link href="{{ asset(mix('css/style.css')) }}" rel="stylesheet">
    <link href="{{ asset(mix('css/errors.css')) }}" rel="stylesheet">
    @stack('styles')
    @yield('style')
</head>
<body>
  <div class="content-container">
    <div class="header-error">
      <svg class="status-error-logo" xmlns="http://www.w3.org/2000/svg" width="80.999" height="33" viewBox="0 0 80.999 33"><path d="M705.018,4516.878c0-7.625,4.86-12.663,12.8-12.663,6.857,0,11.8,4.737,11.8,11.628,0,7.667-4.9,12.577-12.758,12.577C709.966,4528.42,705.018,4523.726,705.018,4516.878Zm7.333.085c0,3.1,1.866,5.427,4.731,5.427,3.254,0,5.207-2.455,5.207-5.943,0-3.187-1.953-5.514-4.817-5.514C714.131,4510.934,712.351,4513.475,712.351,4516.964Zm47.339,11.2a2.2,2.2,0,0,1-2.126-.99c-1.563-1.811-2.995-3.4-4.773-5.385l-9.635-10.724c-.217-.258-.39-.344-.521-.344-.217,0-.347.214-.347.688v8.139c0,2.283.13,7.237.13,7.538,0,.9-.26,1.077-1.258,1.077h-4.818c-1,0-1.258-.174-1.258-1.077,0-.3.13-5.255.13-7.538v-14.514c0-2.283-.13-7.234-.13-7.537,0-.9.26-1.076,1.258-1.076h2.864a2.192,2.192,0,0,1,2.126.99c1.606,1.938,3.124,3.66,4.687,5.427l9.026,10.207a.937.937,0,0,0,.564.388c.174,0,.3-.215.3-.689v-7.71c0-2.283-.131-7.234-.131-7.537,0-.9.26-1.076,1.259-1.076h4.817c1,0,1.258.171,1.258,1.076,0,.3-.13,5.254-.13,7.537v14.514c0,2.283.13,7.237.13,7.538,0,.9-.26,1.077-1.258,1.077Zm-66.981,0c-1,0-1.258-.174-1.258-1.077,0-.3.13-5.255.13-7.538v-13.781c0-.775-.13-1.076-.521-1.076a1.972,1.972,0,0,0-.694.172c-1.475.516-2.777,1.033-3.948,1.55a1.957,1.957,0,0,1-.825.258c-.39,0-.564-.3-.781-.947l-1.518-4.264a2.288,2.288,0,0,1-.174-.819c0-.387.26-.56,1-.775a77.918,77.918,0,0,0,8.2-2.928,5.8,5.8,0,0,1,2.559-.517h2.864c1,0,1.259.171,1.259,1.076,0,.3-.131,5.254-.131,7.537v14.514c0,2.283.131,7.237.131,7.538,0,.9-.261,1.077-1.259,1.077Z" transform="translate(-682.619 -4495.92)" stroke="rgba(0,0,0,0)" stroke-miterlimit="10" stroke-width="1"/></svg>
    </div>
    <div class="">
      <h1 class="status-error-title">恐れ入りますがやり直してください</h1>
      <p class="status-code">422エラー</p>
    </div>
    <div class="status-btn-group">
      <a class="btn-sub-S status-btn-hover" href="/home">ホームへ</a>
    </div>
    <div class="image-error-group">
      <div class="image-error n-margin" style="margin-bottom: -300px;"></div>
    </div>
  </div>
</body>
</html>