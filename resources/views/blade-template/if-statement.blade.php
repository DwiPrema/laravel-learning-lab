<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>If Statement</title>
</head>
<body>
    <p>
        @if(count($hobbies) == 1)
            I have one hobby!
        @elseif(count($hobbies) > 1)
            I have multiple hobbies!
        @else
            I don't have any hobbies!
        @endif
    </p> 
</body>
</html>