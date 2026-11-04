<?php

namespace App\Http\Controllers;

use App\Models\roti;
use App\Models\MenuImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;

class MenuImageController extends Controller 
{
    public function store(Request $request, roti $roti) 
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048' // Maksimal 2MB per file
        ]);

        $manager = new ImageManager(new Driver());

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                // 1. Generate nama file berbasis timestamp agar mudah dilacak
                $timestamp = now()->format('Ymd_His');
                $random = substr(bin2hex(random_bytes(4)), 0, 8);
                $filename = "{$timestamp}_{$random}.jpg";

                // 2. Proses gambar asli (Gunakan decode() BUKAN read() untuk v4)
                $originalImage = $manager->decode($file)
                    ->scaleDown(width: 1000)
                    ->encode(new JpegEncoder(quality: 85));
                
                $originalPath = 'menu_images/' . $filename;
                Storage::disk('public')->put($originalPath, (string) $originalImage);

                // 3. Proses thumbnail (Simpan di folder menu_images_thumbnail)
                $thumbnailImage = $manager->decode($file)
                    ->scaleDown(width: 300)
                    ->encode(new JpegEncoder(quality: 70));
                
                $thumbnailPath = 'menu_images_thumbnail/' . $filename;
                Storage::disk('public')->put($thumbnailPath, (string) $thumbnailImage);

                // 4. Simpan path ke database
                $roti->images()->create([
                    'image_path' => $originalPath,
                    'thumbnail_path' => $thumbnailPath,
                ]);
            }
        }

        return back()->with('success', 'Gambar berhasil diupload.');
    }

    public function destroy(MenuImage $menuImage) 
    {
        // Hapus file asli dan thumbnail dari storage
        Storage::disk('public')->delete($menuImage->image_path);
        Storage::disk('public')->delete($menuImage->thumbnail_path);
        
        // Hapus record dari database
        $menuImage->delete();
        
        return back()->with('success', 'Gambar berhasil dihapus.');
    }
}