<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\roti;
use App\Models\roti_image;
use carbon\Carbon;
use intervention\Image\ImageManager;
use intervention\Image\Gd\Driver;
use illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    // Menampilkan semua produk
    public function produk()
    {
        $products = DB::table('products')->get();

        return view('produk', compact('products'));
    }
    public function roti()
    {
        $rotis = roti::all();

        return view('produk', compact('rotis'));
    }

    public function coba(Request $request)
    {
        $query = Roti::query();

        // Fitur Pencarian Nama
        // if ($request->filled('search')) {
        //     $query->where('name', 'like', '%' . $request->search . '%');
        // }

        // Fitur Filter Kategori / Pengganti Penulis
        if ($request->filled('category') && $request->category != 'Semua Kategori') {
            $query->where('category', $request->category);
        }

        // Ambil data utama setelah filter/pencarian
        $rotis = $query->get();

        // Mengambil 5 data berdasarkan ID terbesar (terbaru)
        $rotiTerbaru = Roti::orderBy('id', 'desc')->take(5)->get();


        $totalRoti      = Roti::count();
        $totalHarga     = Roti::sum('price');
        $hargaTertinggi = Roti::max('price');
        $hargaTerendah  = Roti::min('price');


        // Send all variables to View
        return view('coba', compact(
            'rotis', 
            'rotiTerbaru', 
            'totalRoti', 
            'totalHarga', 
            'hargaTertinggi', 
            'hargaTerendah'
        ));
    }

    // Menampilkan form tambah produk
    public function create()
    {
        return view('roti.create');
    }

    // Menyimpan produk
    public function store(Request $request)
    { 
        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'category'           => 'required|string|max:100',
            'price'              => 'required|numeric|min:0',
            'stock'              => 'required|integer|min:0',
            'image'              => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', 
        ]);

        $roti = new Roti();
        $roti->name = $validated['name'];
        $roti->category = $validated['category'];
        $roti->price = $validated['price'];
        $roti->stock = $validated['stock']; 
        $roti->tanggal_produksi = now();
        $roti->tanggal_kadaluarsa = $roti->tanggal_produksi->copy()->addDays(3);
        $roti->save();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Manipulasi gambar dengan Intervention Image
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file);
            $image->resize(width: 800, height: 800); // Sesuaikan kebutuhan ukuran

            // Simpan file fisik ke direktori storage/app/public/roti/
            $destinationPath = storage_path('app/public/roti/' . $filename);
            $image->save($destinationPath);

            // Simpan data gambar ke tabel gambar_roti
            GambarRoti::create([
                'roti_id'     => $roti->id, // Mengambil ID roti yang baru disimpan
                'path_gambar' => 'roti/' . $filename,
            ]);
        }

        return redirect('/coba')->with('success', 'Roti berhasil ditambahkan.');
    }

    // Menampilkan detail produk
    public function show($id)
{
    $roti = Roti::find($id);
    return view('roti.show', compact('roti')); 
}

    // Menampilkan form edit
    public function edit($id)
    {
        $roti = Roti::find($id);
        return view('roti.update', compact('roti'));
    }

    // Memperbarui produk
    public function update(Request $request, $id)
    {
        $roti = Roti::find($id);
        $roti->name = request('name');
        $roti->category = request('category');
        $roti->price = request('price');
        $roti->stock = request('stock');
        $roti->tanggal_produksi = request('tanggal_produksi');
        $roti->tanggal_kadaluarsa = $roti->tanggal_produksi->copy()->addDays(3);
        $roti->save();

        if ($request->hasFile('image')) {
            // 1. Cari record gambar lama di database
            $gambarLama = GambarRoti::where('roti_id', $roti->id)->first();

            // 2. Hapus file fisik gambar lama dari storage jika ada
            if ($gambarLama && Storage::exists('public/' . $gambarLama->path_gambar)) {
                Storage::delete('public/' . $gambarLama->path_gambar);
            }

            // 3. Proses upload & resize gambar baru
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $manager = new ImageManager(new Driver());
            $image = $manager->read($file);
            $image->resize(width: 800, height: 800);
            $image->save(storage_path('app/public/roti/' . $filename));

            // 4. Perbarui data di database (buat baru jika belum ada, update jika sudah ada)
            GambarRoti::updateOrCreate(
                ['roti_id' => $roti->id],
                ['path_gambar' => 'roti/' . $filename]
            );
        }

        return redirect('/coba')->with('success', 'roti berhasil diperbarui.');
    }

    // Menghapus produk
    public function destroy($id)
    {
        $roti = Roti::find($id);
        $roti->delete();

        return redirect('/coba')->with('success', 'roti berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $batas = 5;
        $cari = $request->kata;
        $data = Roti::where('name', 'like', '%' . $cari . '%')->orwhere('category', 'like', '%' . $cari . '%')->paginate($batas);
        $jumlah = $data->count();
        $no = $batas * ($data->currentPage() - 1);

        return view('roti.search', compact('jumlah', 'data', 'no', 'cari'));
    }
}