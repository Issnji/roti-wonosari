<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    // Menampilkan semua produk
    public function produk()
    {
        $products = DB::table('products')->get();

        return view('produk', compact('products'));
    }

    // Menampilkan form tambah produk
    public function create()
    {
    
    }

    // Menyimpan produk
    public function store()
    {
    
    }

    // Menampilkan detail produk
    public function show()
    {
    
    }

    // Menampilkan form edit
    public function edit()
    {
    
    }

    // Memperbarui produk
    public function update()
    {
    }

    // Menghapus produk
    public function destroy()
    {
        
    }
}