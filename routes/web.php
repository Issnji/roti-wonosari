<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})-> name('home');

Route::get('/produk', [PostController::class, 'produk'])-> name('produk');
