<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ secure_asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    {{-- Font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">

    <!-- Styles -->
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">

    <script>
        window.vidate = {!!
            json_encode([
                'url' => config('app.url'),
                'user' => [
                    'id' => Auth::check() ? Auth::user()-> id : null,
                    'authenticated' => Auth::check() ? true : false
                ]
            ]);
        !!}
    </script>

</head>

<body>
    <div id="app">
        @include('layouts.partials._navigation')

        <main class="py-4">
            @yield('content')
        </main>
    </div>

</body>

</html>