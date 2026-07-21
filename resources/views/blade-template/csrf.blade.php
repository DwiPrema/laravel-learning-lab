<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSRF</title>
</head>
<body>
    <form action="" method="post">
        @csrf
        <input type="text" name="name">
        <input type="submit" name="send">
    </form>
</body>
</html>