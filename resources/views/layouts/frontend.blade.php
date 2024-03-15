<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Primary Meta Tags -->
    <title>{{__("Atomwaffenverbot jetzt! | SEI DABEI!")}}</title>
    <meta name="title" content="{{__("Atomwaffenverbot jetzt! | SEI DABEI!")}}" />
    <meta name="description" content="{{__("Mit der Atomwaffenverbotsinitiative fordern wir den Bundesrat auf, dem Atomwaffenverbotsvertrag beizutreten und die humanitäre Verantwortung der Schweiz wahrnehmen. Sei dabei!")}}" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{url("")}}" />
    <meta property="og:title" content="{{__("Atomwaffenverbot jetzt! | SEI DABEI!")}}" />
    <meta property="og:description" content="{{__("Mit der Atomwaffenverbotsinitiative fordern wir den Bundesrat auf, dem Atomwaffenverbotsvertrag beizutreten und die humanitäre Verantwortung der Schweiz wahrnehmen. Sei dabei!")}}" />
    <meta property="og:image" content="https://metatags.io/images/meta-tags.png" />

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="{{url("")}}" />
    <meta property="twitter:title" content="{{__("Atomwaffenverbot jetzt! | SEI DABEI!")}}" />
    <meta property="twitter:description" content="{{__("Mit der Atomwaffenverbotsinitiative fordern wir den Bundesrat auf, dem Atomwaffenverbotsvertrag beizutreten und die humanitäre Verantwortung der Schweiz wahrnehmen. Sei dabei!")}}" />
    <meta property="twitter:image" content="https://metatags.io/images/meta-tags.png" />

    <!-- Meta Tags Generated with https://metatags.io -->

    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/images/favicon/site.webmanifest">
    <link rel="mask-icon" href="/images/favicon/safari-pinned-tab.svg" color="#d6ff00">
    <link rel="shortcut icon" href="/images/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="/images/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    
    @vite("resources/css/app.scss")
</head>
<body>
    <main>
        {{ $slot }}
    </main>
    @vite("resources/js/app.js")
</body>
