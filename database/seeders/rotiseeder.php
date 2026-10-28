<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\roti;
use Carbon\Carbon;

class RotiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rotiData = [
            [
                'name' => 'Roti Tawar Klasik',
                'price' => 15000,
                'stock' => 50,
                'image' => 'roti-tawar-klasik.jpg',
                'category' => 'Roti Tawar',
                'tanggal_produksi' => Carbon::now()->subDays(1),
            ],
            [
                'name' => 'Roti Tawar Gandum',
                'price' => 18000,
                'stock' => 40,
                'image' => 'roti-tawar-gandum.jpg',
                'category' => 'Roti Tawar',
                'tanggal_produksi' => Carbon::now(),
            ],
            [
                'name' => 'Roti Cokelat Lumer',
                'price' => 8000,
                'stock' => 30,
                'image' => 'roti-cokelat.jpg',
                'category' => 'Roti Manis',
                'tanggal_produksi' => Carbon::now(),
            ],
            [
                'name' => 'Roti Keju Spesial',
                'price' => 9000,
                'stock' => 35,
                'image' => 'roti-keju.jpg',
                'category' => 'Roti Manis',
                'tanggal_produksi' => Carbon::now()->subDays(1),
            ],
            [
                'name' => 'Roti Pisang Cokelat',
                'price' => 10000,
                'stock' => 25,
                'image' => 'roti-pisang-cokelat.jpg',
                'category' => 'Roti Manis',
                'tanggal_produksi' => Carbon::now(),
            ],
            [
                'name' => 'Roti Abon Sapi',
                'price' => 12000,
                'stock' => 20,
                'image' => 'roti-abon.jpg',
                'category' => 'Roti Gurih',
                'tanggal_produksi' => Carbon::now(),
            ],
            [
                'name' => 'Roti Sosis Keju',
                'price' => 11000,
                'stock' => 25,
                'image' => 'roti-sosis.jpg',
                'category' => 'Roti Gurih',
                'tanggal_produksi' => Carbon::now()->subDays(1),
            ],
            [
                'name' => 'Roti Sobek Butter',
                'price' => 22000,
                'stock' => 15,
                'image' => 'roti-sobek.jpg',
                'category' => 'Roti Manis',
                'tanggal_produksi' => Carbon::now(),
            ],
            [
                'name' => 'Roti Sisir Manis',
                'price' => 14000,
                'stock' => 30,
                'image' => 'roti-sisir.jpg',
                'category' => 'Roti Manis',
                'tanggal_produksi' => Carbon::now()->subDays(2),
            ],
            [
                'name' => 'Donat Cokelat Meses',
                'price' => 6000,
                'stock' => 60,
                'image' => 'donat-cokelat.jpg',
                'category' => 'Donat',
                'tanggal_produksi' => Carbon::now(),
            ],
            [
                'name' => 'Donat Gula Halus',
                'price' => 5000,
                'stock' => 50,
                'image' => 'donat-gula.jpg',
                'category' => 'Donat',
                'tanggal_produksi' => Carbon::now(),
            ],
            [
                'name' => 'Croissant Butter',
                'price' => 18000,
                'stock' => 20,
                'image' => 'croissant-butter.jpg',
                'category' => 'Pastry',
                'tanggal_produksi' => Carbon::now(),
            ],
            [
                'name' => 'Croissant Cokelat',
                'price' => 20000,
                'stock' => 18,
                'image' => 'croissant-cokelat.jpg',
                'category' => 'Pastry',
                'tanggal_produksi' => Carbon::now()->subDays(1),
            ],
            [
                'name' => 'Cinnamon Roll',
                'price' => 16000,
                'stock' => 22,
                'image' => 'cinnamon-roll.jpg',
                'category' => 'Pastry',
                'tanggal_produksi' => Carbon::now(),
            ],
            [
                'name' => 'Danish Strawberry',
                'price' => 17000,
                'stock' => 15,
                'image' => 'danish-strawberry.jpg',
                'category' => 'Pastry',
                'tanggal_produksi' => Carbon::now(),
            ],
            [
                'name' => 'Baguette French',
                'price' => 25000,
                'stock' => 10,
                'image' => 'baguette.jpg',
                'category' => 'Roti Tawar',
                'tanggal_produksi' => Carbon::now()->subDays(1),
            ],
            [
                'name' => 'Garlic Bread Toast',
                'price' => 13000,
                'stock' => 30,
                'image' => 'garlic-bread.jpg',
                'category' => 'Roti Gurih',
                'tanggal_produksi' => Carbon::now(),
            ],
            [
                'name' => 'Muffin Cokelat Choco Chip',
                'price' => 10000,
                'stock' => 40,
                'image' => 'muffin-cokelat.jpg',
                'category' => 'Pastry',
                'tanggal_produksi' => Carbon::now(),
            ],
            [
                'name' => 'Roti Kismis Kayumanis',
                'price' => 12000,
                'stock' => 20,
                'image' => 'roti-kismis.jpg',
                'category' => 'Roti Manis',
                'tanggal_produksi' => Carbon::now()->subDays(2),
            ],
            [
                'name' => 'Roti Daging Sapi Cincang',
                'price' => 15000,
                'stock' => 25,
                'image' => 'roti-daging.jpg',
                'category' => 'Roti Gurih',
                'tanggal_produksi' => Carbon::now(),
            ],
        ];

        foreach ($rotiData as $data) {
            roti::create($data);
        }
    }
}