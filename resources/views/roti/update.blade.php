@extends('layout.template')

@section('content')
    <div class="container">
        <h4>Ubah Produk</h4>

        <form method="POST" action="{{ route('coba.update', $roti->id) }}">
            @csrf
            @method('PUT')

            <div> Nama <input type="text" name="name" value="{{ $roti->name }}" required></div>
            <div> Kategori <input type="text" name="category" value="{{ $roti->category }}" required></div>
            <div> Harga <input type="number" name="price" value="{{ $roti->price }}" required></div>
            <div> Stok <input type="number" name="stock" value="{{ $roti->stock }}" required></div>
            <div> Gambar <input type="file" name="image" accept="image/*" required></div>
            <div> Tanggal Produksi <input type="date" id="tanggal_produksi" name="tanggal_produksi" value="{{ $roti->tanggal_produksi }}" required></div>
            
            <div style="margin-top: 10px;">
                <button type="submit">Simpan</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    flatpickr("#tanggal_produksi", {
        dateFormat: "Y-m-d", 
        altInput: true,      
        altFormat: "d F Y",  
    });
</script>
@endpush