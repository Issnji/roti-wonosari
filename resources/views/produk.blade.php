@extends('layout.template')

@section('title', 'Produk Roti Wonosari')

@push('styles')
    <link rel="stylesheet" href="/css/menu.css">
@endpush

@section('content')
<div class="product-grid">
    @foreach($products as $product)
        <div class="card">
            <div>
                <div class="card-body">
                    <h3 class="card-title">{{ $product->name }}</h3>
                </div>
            </div>
            <div class="card-footer">
                <span class="price">Rp {{ $product->price }}</span>
                <button class="btn-add">+ Tambah</button>
            </div>
        </div>
    @endforeach
</div>
@endsection