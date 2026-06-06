<?php

use Illuminate\Support\Facades\Route;

require __DIR__.'/blade-template.php';

Route::get('/', function () {
    return view('welcome');
});
