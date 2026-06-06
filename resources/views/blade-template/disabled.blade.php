<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disabled Blade</title>
</head>

<body>
    <h1>Hello @{{$name}}</h1>

    @verbatim
    <h1>
        Hello {{$name}}
        Hello {{$name}}
        Hello {{$name}}
        Hello {{$name}}
    </h1>
    @endverbatim
</body>

</html>