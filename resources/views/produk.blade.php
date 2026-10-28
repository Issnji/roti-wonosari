@extends('layout.template')

@section('title', 'Produk Roti Wonosari')

@push('styles')
    <link rel="stylesheet" href="/css/menu.css">
@endpush

@section('content')
<div class="product-grid">
    @foreach($rotis as $roti)
        <div class="card">
            <div>
                <div class="card-body">
                    <span class="badge bg-secondary mb-2">{{ $roti->category }}</span>
                    
                    <h3 class="card-title">{{ $roti->name }}</h3>
                </div>
            </div>
                <div class="card-footer">
                    <span class="price">Rp {{ number_format($roti->price, 0, ',', '.') }}</span>
                    <button class="btn-add">+ Tambah</button>
                </div>
            </div>
    @endforeach
</div>
@endsection