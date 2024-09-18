<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/mahasiswa', function () {
    return view('dashboard_mahasiswa');
});

Route::get('/', function () {
    return view('login_page');
});
