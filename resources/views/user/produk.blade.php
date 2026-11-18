@extends('layout.user')

@section('title', 'Katalog Roti Wonosari')

@push('styles')
    <link rel="stylesheet" href="/css/coba.css">
@endpush

@section('content')
<div class="content-wrapper">

    <div class="action-header">
        <h3>Katalog Produk Roti</h3>
    </div>

    <!-- FILTER & PENCARIAN -->
    <div class="filter-container">
        <form action="{{ route('user.produk.search') }}" method="GET" class="filter-form">

            <div class="search-box">
                <input type="text" name="kata" placeholder="Cari nama roti..." value="{{ request('kata') }}">
                <button type="submit">Cari</button>
            </div>

            <div class="category-box">
                <select name="category" onchange="this.form.submit()">
                    <option value="Semua Kategori" {{ request('category') == 'Semua Kategori' ? 'selected' : '' }}>Semua Kategori</option>
                    <option value="Pastry" {{ request('category') == 'Pastry' ? 'selected' : '' }}>Pastry</option>
                    <option value="Gandum" {{ request('category') == 'Gandum' ? 'selected' : '' }}>Gandum</option>
                    <option value="Cookies" {{ request('category') == 'Cookies' ? 'selected' : '' }}>Cookies</option>
                    <option value="Donat" {{ request('category') == 'Donat' ? 'selected' : '' }}>Donat</option>
                    <option value="Kue" {{ request('category') == 'Kue' ? 'selected' : '' }}>Kue</option>
                </select>
            </div>

            <div class="reset-box">
                <a href="{{ url('/user/produk') }}">Reset</a>
            </div>

        </form>
    </div>

    <!-- 5 ROTI TERBARU -->
    <div class="latest-section">
        <h4>5 Roti Terbaru</h4>
        <div class="latest-grid">
            @foreach($rotiTerbaru as $terbaru)
                <div class="card-latest">
                    <span class="badge">{{ $terbaru->category }}</span>
                    <h6 class="card-title">{{ $terbaru->name }}</h6>
                    <small class="price">Rp {{ number_format($terbaru->price, 0, ',', '.') }}</small>
                </div>
            @endforeach
        </div>
    </div>

    <!-- DAFTAR SEMUA PRODUK -->
    <h4>Semua Produk</h4>
    <div class="product-grid">
        @forelse($rotis as $roti)
            <div class="card">
                <!-- THUMBNAIL GAMBAR -->
                <div class="card-thumbnail">
                    <a href="{{ route('user.produk.show', $roti->id) }}">
                        @if($roti->images && $roti->images->isNotEmpty())
                            @php
                                $imageItem = $roti->images->where('is_thumbnail', true)->first() ?? $roti->images->first();
                                $imagePath = $imageItem->thumbnail_path ?? $imageItem->image_path;
                            @endphp
                            <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $roti->name }}" class="img-thumbnail">
                        @else
                            <div class="no-image-thumbnail">
                                <span>Tidak Ada Gambar</span>
                            </div>
                        @endif
                    </a>
                </div>

                <div class="card-body">
                    <span class="badge">{{ $roti->category }}</span>
                    <h3 class="card-title">
                        <a href="{{ route('user.produk.show', $roti->id) }}" class="title-link">
                            {{ $roti->name }}
                        </a>
                    </h3>
                </div>

                <div class="card-footer">
                    <span class="price">Rp {{ number_format($roti->price, 0, ',', '.') }}</span>
                    
                    <div class="card-actions">
                        <a href="{{ route('user.produk.show', $roti->id) }}" class="btn-detail">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="no-data">
                Roti yang kamu cari tidak ditemukan.
            </div>
        @endforelse
    </div>

</div>
@endsection