@extends('layout.template')

@section('title', 'Detail - ' . $roti->name)

@push('styles')
    <link rel="stylesheet" href="/css/coba.css">
@endpush

@section('content')
<div class="content-wrapper">
    <div class="card-detail">
        <div class="card-detail-image">
            @if($roti->images->isNotEmpty())
                <img src="{{ asset('storage/' . $roti->images->first()->path_gambar) }}" alt="{{ $roti->name }}">
            @else
                <div class="no-image">Tidak ada gambar</div>
            @endif
        </div>

        <div class="card-detail-info">
            <span class="badge">{{ $roti->category }}</span>
            <h2>{{ $roti->name }}</h2>
            <p class="price-detail">Rp {{ number_format($roti->price, 0, ',', '.') }}</p>
            
            <div class="stock-info">
                <strong>Stok Tersedia:</strong> {{ $roti->stock }} pcs
            </div>
        </div>
    </div>

</div>
@endsection