<!DOCTYPE html>
<html lang="ja">
    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link rel="stylesheet" href="{{ mix('css/app.css') }}" />
    </head>
    <body>
        @include('components.header')
        <div class="app"></div>
        <h1>Tom</h1>
        @include('components.footer')
    </body>
    <script src="{{ mix('/js/index.js') }}"></script>

    @push('scripts')
        <script type="text/javascript" src="{{ mix('/js/index.js') }}" defer></script>
    @endpush
</html>



