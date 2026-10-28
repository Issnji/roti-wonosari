<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('home');
});

Route::get('/home', function () {
    return view('home');
})-> name('home');

Route::get('/coba/search', [PostController::class, 'search'])-> name('coba.search');
Route::get('/produk', [PostController::class, 'roti'])-> name('produk');
Route::get('/coba', [PostController::class, 'coba'])-> name('coba');

Route::get('/coba/create', [PostController::class, 'create'])-> name('coba.create');
Route::post('/coba', [PostController::class, 'store'])-> name('coba.store');

Route::delete('/coba/{id}', [PostController::class, 'destroy'])-> name('coba.destroy');

Route::put('/coba/{id}', [PostController::class, 'update'])-> name('coba.update');
Route::get('/coba/{id}/edit', [PostController::class, 'edit'])-> name('coba.edit');

Route::get('/coba/{id}', [PostController::class, 'show'])-> name('coba.show');
