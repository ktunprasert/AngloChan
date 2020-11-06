<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Anglo Chan</title>

    <!-- Fonts -->
    
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;400;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@400;600&display=swap" rel="stylesheet">

    {{-- Embed stylesheet --}}
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <!-- Embedd the Script -->
    <script defer src="{{ asset('js/app.js') }}"></script>

</head>

<body>
    <div id="svelteApp"></div>
</body>

</html>