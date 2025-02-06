<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ping</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
<div id="app">
    @yield('content')
</div>
</body>
</html>
