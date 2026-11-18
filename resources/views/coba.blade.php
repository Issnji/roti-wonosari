@extends('layout.template')

@section('title', 'Produk Roti Wonosari')

@push('styles')
    <link rel="stylesheet" href="/css/coba.css">
@endpush

@section('content')
<div class="content-wrapper">

    @if(session('success'))
        <div class="alert-success" style="padding: 12px; background-color: #d1e7dd; color: #0f5132; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="action-header">
        <h3>Kelola Produk Roti</h3>
        <!-- Tombol Tambah -->
        <a href="{{ url('/coba/create') }}" class="btn-create">
            + Tambah Roti Baru
        </a>
    </div>

    <!-- HANYA GUNAKAN 1 TAG FORM -->
    <div class="filter-container">
        <form action="{{ route('coba.search') }}" method="GET" class="filter-form">

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
                <a href="{{ url('/coba') }}">Reset</a>
            </div>

        </form>
    </div>

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

    <h4>Semua Produk</h4>
    <div class="product-grid">
        @forelse($rotis as $roti)
            <div class="card">
                <!-- WRAPPER THUMBNAIL GAMBAR -->
                <div class="card-thumbnail">
                    <a href="{{ route('coba.show', $roti->id) }}">
                        @if($roti->images && $roti->images->isNotEmpty())
                            @php
                                // Ambil gambar yang ditandai thumbnail atau gambar pertama
                                $imageItem = $roti->images->where('is_thumbnail', true)->first() ?? $roti->images->first();
                                $imagePath = $imageItem->thumbnail_path ?? $imageItem->image_path;
                            @endphp
                            <img src="{{ asset('storage/' . $roti->images->first()->thumbnail_path) }}" alt="{{ $roti->name }}" class="img-thumbnail">
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
                        <a href="{{ route('coba.show', $roti->id) }}" class="title-link">
                            {{ $roti->name }}
                        </a>
                    </h3>
                    <div class="expired-date">
                        Kadaluarsa: {{ \Carbon\Carbon::parse($roti->tanggal_kadaluarsa)->format('d M Y') }}
                    </div>
                </div>

                <div class="card-footer">
                    <span class="price">Rp {{ number_format($roti->price, 0, ',', '.') }}</span>
                    
                    <div class="card-actions">
                        <a href="{{ route('coba.edit', $roti->id) }}" class="btn-edit">Ubah</a>
                        <form action="{{ route('coba.destroy', $roti->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')" 
                            type="submit" class="btn-delete">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="no-data">
                Roti yang kamu cari tidak ditemukan.
            </div>
        @endforelse
    </div>

    <div class="stats-container">
        <h4>Statistik Roti</h4>
        <div class="stats-grid">
            <div class="stats-item">
                <small>Total Roti</small>
                <span>{{ $totalRoti }}</span>
            </div>
            <div class="stats-item">
                <small>Total Harga</small>
                <span>Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
            </div>
            <div class="stats-item">
                <small>Harga Tertinggi</small>
                <span>Rp {{ number_format($hargaTertinggi, 0, ',', '.') }}</span>
            </div>
            <div class="stats-item">
                <small>Harga Terendah</small>
                <span>Rp {{ number_format($hargaTerendah, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

</div>
@endsection