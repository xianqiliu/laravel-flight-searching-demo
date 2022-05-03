<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Laravel</title>
    <style>
        @import url(https://unpkg.com/bootstrap@3.3.5/dist/css/bootstrap.min.css);
    </style>
</head>

<body>
<div id="app" class="container" style="text-align: left">
    @yield ('content')
</div>
<script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
