@extends('layout.template')

@section('title', 'Hasil Pencarian Roti')

@push('styles')
    <link rel="stylesheet" href="/css/coba.css">
@endpush

@section('content')

@if($data->count() > 0)
    <div class="alert alert-success">
        Ditemukan <strong>{{ $data->total() }}</strong> data dengan kata: <strong>{{ $cari }}</strong>
    </div>

    <div class="content-wrapper">
        <div class="action-header">
            <h3>Hasil Pencarian Produk</h3>
            <a href="{{ url('/coba') }}" class="btn-create" style="background-color: #6b7280;">
                &larr; Kembali ke Semua Produk
            </a>
        </div>

        <div class="filter-container">
            <form action="{{ route('coba.search') }}" method="GET" class="filter-form">
                <div class="search-box">
                    <input type="text" name="kata" placeholder="Cari nama atau kategori roti..." value="{{ $cari }}">
                    <button type="submit">Cari</button>
                </div>
                <div class="reset-box">
                    <a href="{{ url('/coba') }}">Reset</a>
                </div>
            </form>
        </div>

        <div class="product-grid">
            @foreach($data as $roti)
                <div class="card">
                    <div class="card-body">
                        <span class="badge">{{ $roti->category }}</span>
                        <h3 class="card-title">
                            <a href="{{ route('coba.show', $roti->id) }}" class="title-link">
                                {{ $roti->name }}
                            </a>
                        </h3>
                        @if(!empty($roti->tanggal_kadaluarsa))
                            <div class="expired-date">
                                Kadaluarsa: {{ $roti->tanggal_kadaluarsa->format('d M Y') }}
                            </div>
                        @endif
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
            @endforeach
        </div>

        <!-- Penyesuaian Pagination & Jumlah Data seperti di gambar -->
        <div style="margin-top: 25px;">
            <div>{{ $data->withQueryString()->links() }}</div>
            <div style="margin-top: 10px;"><strong>Jumlah Roti: {{ $data->total() }}</strong></div>
        </div>
    </div>

@else
    <div class="alert alert-warning">
        <h4>Data {{ $cari }} tidak ditemukan</h4>
        <a href="{{ url('/coba') }}" class="btn btn-warning">Kembali</a>
    </div>
@endif

@endsection