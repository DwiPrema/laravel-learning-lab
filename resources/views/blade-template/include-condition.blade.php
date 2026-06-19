<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Include Condition</title>
</head>
<body>
    @includeWhen($user['owner'], "blade-template.header-admin")
    <p>Selamat Datang {{$user['name']}}</p>
</body>
</html>