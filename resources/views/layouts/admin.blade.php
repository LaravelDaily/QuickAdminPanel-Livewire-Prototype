<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="theme-color" content="#000000"/>
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}"/>
    <link
            rel="apple-touch-icon"
            sizes="76x76"
            href="{{ asset('apple-icon.png') }}"
    />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
    <title>{{ trans('panel.site_title') }}</title>
    @livewireStyles
</head>
<body class="text-gray-800 antialiased">

<noscript>You need to enable JavaScript to run this app.</noscript>

<div id="app">

    @include('partials.menu')

    <div class="relative md:ml-64 bg-gray-100 pb-12 min-h-screen">
        <div class="relative bg-pink-600 md:pt-32 pb-32 pt-12"></div>

        <div class="relative px-4 md:px-10 mx-auto w-full min-h-full -m-48">
            @yield('content')
        </div>
    </div>

</div>

<form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>

<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
@livewireScripts
</body>
</html>
