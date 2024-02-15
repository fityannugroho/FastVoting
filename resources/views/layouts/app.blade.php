<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0d6efd">
    <meta name="dicoding:email" content="fityandhiya@gmail.com">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ Vite::image('logo.png') }}">
    <link rel="apple-touch-icon" href="{{ Vite::image('logo.png') }}">

    <!-- Scripts -->
    @vite(['resources/js/app.js'])

    <!-- Import Trix Editor, Usage: `<trix-editor input="x"></trix-editor>` -->
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.10/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.10/dist/trix.umd.min.js" defer></script>

</head>
<body class="d-flex flex-column min-vh-100">
    <div id="app">
        @include('components.navbar')
        @include('components.alert')

        <main>
            @yield('content')
        </main>
    </div>
    <footer class="w-100 mt-auto d-flex flex-wrap justify-content-between align-items-center py-2 my-1 border-top">
        <div class="d-flex align-items-center text-center mx-auto">
            <span class="text-muted">&copy; 2022 {{ config('app.name') }}</span>
        </div>
    </footer>
</body>
</html>
