# Laravel Blade Template

## Introduction

Blade is Laravel's built-in templating engine. It allows developers to write dynamic views using a clean and expressive syntax while still being compiled into plain PHP behind the scenes.

Blade helps developers:

* Create reusable layouts
* Display dynamic data
* Use control structures (if, foreach, etc.)
* Organize views efficiently
* Reduce repetitive HTML code

Blade files use the `.blade.php` extension and are typically stored inside the `resources/views` directory.

---

## Why Use Blade?

Without Blade, developers would need to write PHP directly inside HTML:

```php
<?php if($user): ?>
    <h1>Hello <?= $user ?></h1>
<?php endif; ?>
```

Using Blade:

```blade
@if($user)
    <h1>Hello {{ $user }}</h1>
@endif
```

Blade syntax is cleaner, easier to read, and easier to maintain.

---

## Creating a Blade View

Create a file inside:

```text
resources/views/home.blade.php
```

Example:

```blade
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>
    <h1>Hello Laravel Blade</h1>
</body>
</html>
```

Return the view from a route:

```php
Route::get('/', function () {
    return view('home');
});
```

---

## Displaying Data

Pass data from a route or controller:

```php
Route::get('/', function () {
    return view('home', [
        'name' => 'Made'
    ]);
});
```

Display the data:

```blade
<h1>Hello {{ $name }}</h1>
```

Output:

```text
Hello Made
```

---

## Escaping Output

Blade automatically escapes HTML to prevent XSS attacks.

```blade
{{ $content }}
```

To render raw HTML:

```blade
{!! $content !!}
```

Use raw output carefully and only with trusted data.

---

## Conditional Statements

### If Statement

```blade
@if($isAdmin)
    <p>Administrator</p>
@endif
```

### If Else

```blade
@if($age >= 18)
    <p>Adult</p>
@else
    <p>Minor</p>
@endif
```

### Multiple Conditions

```blade
@if($score >= 90)
    <p>A</p>
@elseif($score >= 80)
    <p>B</p>
@else
    <p>C</p>
@endif
```

---

## Loops

### Foreach

```blade
@foreach($users as $user)
    <p>{{ $user }}</p>
@endforeach
```

### For Loop

```blade
@for($i = 1; $i <= 5; $i++)
    <p>{{ $i }}</p>
@endfor
```

### While Loop

```blade
@while($count > 0)
    <p>{{ $count }}</p>
@endwhile
```

---

## Including Views

Create a reusable component:

```text
resources/views/header.blade.php
```

```blade
<header>
    <h1>My Website</h1>
</header>
```

Include it:

```blade
@include('header')
```

---

## Blade Layouts

One of Blade's most powerful features is layout inheritance.

### Master Layout

```text
resources/views/layouts/app.blade.php
```

```blade
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
</head>
<body>

<nav>
    Navigation Bar
</nav>

<main>
    @yield('content')
</main>

</body>
</html>
```

---

### Child View

```text
resources/views/home.blade.php
```

```blade
@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <h1>Welcome Home</h1>
@endsection
```

This approach prevents duplicate HTML across multiple pages.

---

## Blade Components

Components allow reusable UI elements.

Generate a component:

```bash
php artisan make:component Alert
```

Usage:

```blade
<x-alert />
```

Components improve maintainability and code organization.

---

## CSRF Protection

Laravel provides a Blade directive for CSRF protection.

```blade
<form method="POST">
    @csrf
</form>
```

Generated HTML:

```html
<input type="hidden" name="_token" value="...">
```

This protects applications against Cross-Site Request Forgery (CSRF) attacks.

---

## Useful Blade Directives

| Directive | Description              |
| --------- | ------------------------ |
| @if       | Conditional statement    |
| @elseif   | Additional condition     |
| @else     | Alternative condition    |
| @foreach  | Loop through collections |
| @for      | Standard loop            |
| @while    | While loop               |
| @include  | Include another view     |
| @extends  | Extend a layout          |
| @section  | Define section content   |
| @yield    | Display section content  |
| @csrf     | Generate CSRF token      |
| @php      | Execute PHP code         |
| @isset    | Check variable existence |
| @empty    | Check empty variable     |

---

## Best Practices

* Keep business logic out of Blade views.
* Use controllers to prepare data.
* Use layouts to avoid duplicated HTML.
* Use components for reusable UI elements.
* Use escaped output (`{{ }}`) whenever possible.
* Keep views focused on presentation.

---

## Summary

Blade is Laravel's templating engine that simplifies view development through:

* Clean syntax
* Dynamic data rendering
* Control structures
* Layout inheritance
* Components
* Built-in security features

By using Blade effectively, developers can build maintainable, reusable, and secure user interfaces in Laravel applications.
