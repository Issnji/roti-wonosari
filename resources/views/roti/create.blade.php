@extends('layout.template') 
@section('content')
    <div class="container">
        <h4>Tambah Produk</h4>
        <form method="POST" action="{{ route('coba.store') }}">
            @csrf
            <div> Nama <input type="text" name="name" required></div>
            <div> Kategori <input type="text" name="category" required></div>
            <div> Harga <input type="number" name="price" required></div>
            <div> Stok <input type="number" name="stock" required></div>
            <div> gambar <input type="text" name="image" required></div>
            <div> <button type="submit">Simpan</button></div>
    </div>
@endsection
@if (count($errors) > 0)
    <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
    </ul>
@endif