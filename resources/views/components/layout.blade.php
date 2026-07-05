<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Laravel kadai</title>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    {{ $slot }}
    
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>