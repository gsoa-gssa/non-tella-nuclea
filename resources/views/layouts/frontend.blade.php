<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    @vite("resources/css/app.scss")
</head>
<body>
    <main>
        {{ $slot }}
    </main>
    @vite("resources/js/app.js")
</body>
