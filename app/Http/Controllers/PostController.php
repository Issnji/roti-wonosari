<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\roti;
use App\Models\RotiImage;
use carbon\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;

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
            $filename = time() . '_' . uniqid() . '.jpg';
            $manager = new ImageManager(new Driver());

            // 1. Proses Gambar Utama (Width: 800px, Quality: 85%)
            $encodedOriginal = $manager->read($request->file('image'))
                ->scaleDown(width: 800)
                ->toJpeg(85);
            $imagePath = 'roti/' . $filename;
            Storage::disk('public')->put($imagePath, (string) $encodedOriginal);

            // 2. Proses Gambar Thumbnail (Width: 300px, Quality: 75%)
            $encodedThumbnail = $manager->read($request->file('image'))
                ->scaleDown(width: 300)
                ->toJpeg(75);
            $thumbnailPath = 'roti_thumbnail/' . $filename;
            Storage::disk('public')->put($thumbnailPath, (string) $encodedThumbnail);

            // 3. Simpan kedua path ke Database
            $roti->images()->create([
                'image_path'     => $imagePath,
                'thumbnail_path' => $thumbnailPath,
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
            $gambarLama = RotiImage::where('roti_id', $roti->id)->first();

            // Hapus file asli DAN thumbnail lama dari storage jika ada
            if ($gambarLama) {
                if ($gambarLama->image_path) {
                    Storage::disk('public')->delete($gambarLama->image_path);
                }
                if ($gambarLama->thumbnail_path) {
                    Storage::disk('public')->delete($gambarLama->thumbnail_path);
                }
            }

            $filename = time() . '_' . uniqid() . '.jpg';
            $manager = new ImageManager(new Driver());

            // 1. Proses Gambar Utama
            $encodedOriginal = $manager->read($request->file('image'))
                ->scaleDown(width: 800)
                ->toJpeg(85);
            $imagePath = 'roti/' . $filename;
            Storage::disk('public')->put($imagePath, (string) $encodedOriginal);

            // 2. Proses Gambar Thumbnail
            $encodedThumbnail = $manager->read($request->file('image'))
                ->scaleDown(width: 300)
                ->toJpeg(75);
            $thumbnailPath = 'roti_thumbnail/' . $filename;
            Storage::disk('public')->put($thumbnailPath, (string) $encodedThumbnail);

            // 3. Update Database
            RotiImage::updateOrCreate(
                ['roti_id' => $roti->id],
                [
                    'image_path'     => $imagePath,
                    'thumbnail_path' => $thumbnailPath,
                ]
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
    
    public function pelanggan()
    {
        $rotis = roti::all();

        return view('user.produk', compact('rotis'));
    }

    public function user(Request $request)
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
        return view('user.produk', compact(
            'rotis', 
            'rotiTerbaru', 
            'totalRoti', 
            'totalHarga', 
            'hargaTertinggi', 
            'hargaTerendah'
        ));
    }
}