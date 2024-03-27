<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/sass/app.scss'])
</head>
<body>
<div id="app" class="container">
    <menu-component></menu-component>
    <router-view></router-view>
</div>
</body>
@vite('resources/js/app.js')
</html>
