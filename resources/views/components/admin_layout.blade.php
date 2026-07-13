<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Laravel -admin-</title>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<body>
    <div class="slot_wrapper_admin">

    {{ $slot }}

    </div>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>