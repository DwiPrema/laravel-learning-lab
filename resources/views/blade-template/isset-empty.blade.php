<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>isset empty</title>
</head>
<body>
    <p>
        @isset($name)
         Hello, my name {{$name}}
        @endisset
    </p>

    <p>
        @empty($hobbies)
            I don't have any hobbies
        @endempty
    </p>
</body>
</html>