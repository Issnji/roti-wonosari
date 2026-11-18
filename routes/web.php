<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MenuImageController;

// Auth::routes([
//     'register' => false,
//     'reset' => false,
// ]);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware('auth')->name('dashboard');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware(['auth', 'admin'])->name('home');

// Route::get('/', function () {
//     return view('auth.register');
// });

// // 1. Group Route khusus ADMIN (Hanya bisa dibuka jika role = admin)
// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/home', [HomeController::class, 'index'])->name('home');
//     Route::get('/coba', [PostController::class, 'users'])->name('admin.users');
//     Route::get('/coba/search', [PostController::class, 'search'])->middleware('auth')->name('coba.search');
//     Route::get('/produk', [PostController::class, 'roti'])->middleware('auth')->name('produk');
//     Route::get('/coba', [PostController::class, 'coba'])->middleware('auth')->name('coba');
    
//     Route::get('/coba/create', [PostController::class, 'create'])->middleware('auth')->name('coba.create');
//     Route::post('/coba', [PostController::class, 'store'])->middleware('auth')->name('coba.store');
    
//     Route::delete('/coba/{id}', [PostController::class, 'destroy'])->middleware('auth')->name('coba.destroy');
    
//     Route::put('/coba/{id}', [PostController::class, 'update'])->middleware('auth')->name('coba.update');
//     Route::get('/coba/{id}/edit', [PostController::class, 'edit'])->middleware('auth')->name('coba.edit');
// });

// Route::get('/home', function () {
//     return view('home');
// })->middleware('auth')->name('home');

// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
//     Route::get('/coba', [PostController::class, 'coba'])->name('coba');
//     Route::get('/produk', [PostController::class, 'roti'])->name('produk');
//     Route::get('/coba/search', [PostController::class, 'search'])->name('coba.search');
// });


// Route::get('/coba/{id}', [PostController::class, 'show'])->middleware('auth')->name('coba.show');

// Route::resource('roti', PostController::class);
// Route::post('/coba/{roti}/images', [MenuImageController::class, 'store'])->name('menus.images.store');
// Route::delete('/menu-images/{menuImage}', [MenuImageController::class, 'destroy'])->name('menu-images.destroy');


Route::get('/', function () {
    return view('auth.register');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/user/produk', [PostController::class, 'pelanggan'])->name('produk');
    Route::get('/user/produk', [PostController::class, 'user'])->name('user.produk');
    Route::get('/user/produk/search', [PostController::class, 'search'])->name('user.produk.search');
    Route::get('/user/produk/{id}', [PostController::class, 'show'])->name('user.produk.show');
});


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/coba', [PostController::class, 'coba'])->name('coba');
    Route::get('/coba/search', [PostController::class, 'search'])->name('coba.search');
    Route::get('/coba/create', [PostController::class, 'create'])->name('coba.create');
    Route::post('/coba', [PostController::class, 'store'])->name('coba.store');
    Route::get('/coba/{id}', [PostController::class, 'show'])->name('coba.show');
    Route::get('/coba/{id}/edit', [PostController::class, 'edit'])->name('coba.edit');
    Route::put('/coba/{id}', [PostController::class, 'update'])->name('coba.update');
    Route::delete('/coba/{id}', [PostController::class, 'destroy'])->name('coba.destroy');

    Route::post('/coba/{roti}/images', [MenuImageController::class, 'store'])->name('menus.images.store');
    Route::delete('/menu-images/{menuImage}', [MenuImageController::class, 'destroy'])->name('menu-images.destroy');
});