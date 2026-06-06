<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/hello', function () {
    return view('blade-template.hello', ["name" => "Dwi Premayasa"]);
});

Route::get('/html-encoding', function (Request $request) {
    return view('blade-template.html-encoding', ["name" => $request->input("name")]);
});
