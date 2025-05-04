<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/doc', function () {
    return redirect('/api-doc/collection.json');
});
