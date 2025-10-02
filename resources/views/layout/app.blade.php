<!DOCTYPE html>
<html lang={{ str_replace('_', '-',app()->getLocale()) }}>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
</head>

<body class="text-black overflow-x-hidden font-[Geist]">
    @yield('content')
</body>

</html>