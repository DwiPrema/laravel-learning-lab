<?php

use Illuminate\Support\Facades\Route;

Route::get('/hello', function (){
    return view('blade-template.hello', ["name" => "Dwi Premayasa"]);
});