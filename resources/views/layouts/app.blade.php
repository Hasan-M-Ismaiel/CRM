<html lang="en">
    <head>
        <base href="./">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
        <meta name="author" content="Łukasz Holeczek">
        <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
        <title>{{ config('app.name') }}</title>
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/favicon/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/favicon/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/favicon/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/favicon/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/favicon/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/favicon/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/favicon/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/favicon/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/favicon/android-icon-192x192.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/favicon/apple-icon-76x76.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('assets/favicon/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('assets/favicon/ms-icon-144x144.png') }}">
        <meta name="theme-color" content="#ffffff">

        
        <!-- Option 1: CoreUI for Bootstrap CSS -->
        <!-- <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.3.2/dist/css/coreui.min.css" rel="stylesheet" integrity="sha384-H8oVKJOQVGGCdfFNM+9gLKN0xagtq9oiNLirmijheEuqD3kItTbTvoOGgxVKqNiB" crossorigin="anonymous"> -->
        <!-- Option 1: CoreUI for Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.3.2/dist/js/coreui.bundle.min.js" integrity="sha384-yaqfDd6oGMfSWamMxEH/evLG9NWG7Q5GHtcIfz8Zg1mVyx2JJ/IRPrA28UOLwAhi" crossorigin="anonymous"></script>

        <!--alpine js library for the flash message-->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

        <!--ajax-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        
        <!--bootstrap icons-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <!-- Vendors styles-->
        <link rel="stylesheet" href='{{ asset("css/vendors/simplebar.css") }}'>
        <link rel="stylesheet" href='{{ asset("vendors/simplebar/css/simplebar.css") }}'>
        <link href='{{ asset("css/style.css") }}' rel="stylesheet">
        <title>Hello, world!</title>
        @vite(['resources/js/app.js', 'resources/css/app.css'])

    </head>
    <body style>
        @include('partials.menu')
        <div class="wrapper d-flex flex-column min-vh-100 bg-light">
            @include('partials.header')
            <div class="body flex-grow-1 px-3">
                <div class="container-lg">
                    @yield('content')
                </div>
            </div>
            
            <x-toast-notification />

            <footer class="footer">
                <div><a href="https://coreui.io">CoreUI </a><a href="https://coreui.io">Bootstrap Admin Template</a> © 2023 creativeLabs.</div>
                <div class="ms-auto">Powered by&nbsp;<a href="https://coreui.io/docs/">CoreUI UI Components</a></div>
            </footer>
        </div>
        
         <x-flash />
         
         <script>
            window.userID = {{ auth()->id() }};
            window.NumberOfNotifications = {!! auth()->user()->unreadNotifications->count() !!};
        </script>
    </body>
</html>