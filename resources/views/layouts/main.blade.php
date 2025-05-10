<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tracking System</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body class="{{ session('dark_mode') ? 'dark-mode' : '' }}">
    @include('partials.navbar')
    <main>
        @yield('content')
    </main>
    <script src="{{ asset('js/darkmode.js') }}"></script>
</body>
</html>
