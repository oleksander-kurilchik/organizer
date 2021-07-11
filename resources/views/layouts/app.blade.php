<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script>
        window.Laravel = {!! json_encode([ 'csrfToken' => csrf_token(), ]) !!};

        window.routes = {
            events: {
                index: "{{route("events.index")}}",
                create: "{{route("events.store")}}"
            },
            auth: {
                login:@json(route('login')),
                logout:@json(route('logout')),
                registration:@json(route('registration')),
            }
        }
    </script>
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
        window.OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
                appId: "{{config('onesignal.app_id')}}",
            });
        });
    </script>
</head>
<body>
<div id="app">

</div>

<script src="{{ asset('js/app.js') }}" defer></script>

</body>
</html>
