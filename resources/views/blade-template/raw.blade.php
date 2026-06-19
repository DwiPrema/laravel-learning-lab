<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raw PHP</title>
</head>
<body>
    @php
    
        class Person{
            public string $name;
            public string $address;
        }

        $person = new Person();
        $person->name = "Dwi";
        $person->address = "Texas";

    @endphp

    <p>{{$person->name}}</p>
    <p>{{$person->address}}</p>
</body>
</html>