<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta http-equiv="refresh" content="0; url={{ url('/dashboard') }}">

    <title>Redirecting...</title>
</head>
<body>
    <p>
        Redirecting to <a href="{{ url('/dashboard') }}">Dashboard</a>...
    </p>
</body>
</html>