<!DOCTYPE html>
<html lang="{{App::getLocale()}}" dir="{{(App::isLocale('ar') ? 'rtl' : 'ltr')}}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{$adminSettings->app_name}}</title>
    <meta name="description" content="{{ @$metaData['description'] ?? '' }}">
    <meta name="keywords" content="{{ @$metaData['keywords'] ?? '' }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Place favicon.ico in the root directory -->
    <link href="{{asset('/uploads/admins/favicons/thumbnails/250/'.$adminSettings->favicon)}}" type="img/x-icon" rel="shortcut icon">
    <!-- All css files are included here. -->
    <link rel="stylesheet" href="{{ asset('/assets/frontend/css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('styles')
</head>

<body>
    <div id="app">
        @include('includes.headers.header')
        <main class="">
            @yield('content')
        </main>
        @include('includes.footers.footer')

    </div>
</body>
@stack('scripts')
</html>
