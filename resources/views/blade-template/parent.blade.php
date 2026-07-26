<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
</head>
<body>
    @section('header')
        <h1>Default Header</h1>
    @show
    @section('content')
        <p>Default Content</p>
    @show
</body>
</html>