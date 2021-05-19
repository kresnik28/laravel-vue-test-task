<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
</head>
<body>

<div id="app">
    @yield('content')
</div>
<script src="{{mix('js/app.js')}}"></script>
</body>
</html>
