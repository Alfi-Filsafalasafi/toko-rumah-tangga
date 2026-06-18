<?php

// database/seeders/ProductSeeder.php
namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Kategori 1
        $dapur = Category::create([
            'name' => 'Peralatan Dapur',
            'slug' => 'peralatan-dapur',
        ]);

        Product::create([
            'category_id' => $dapur->id,
            'name' => 'Wajan Teflon Anti Lengket 24cm',
            'slug' => Str::slug('Wajan Teflon Anti Lengket 24cm'),
            'description' => 'Wajan masak anti lengket dengan material aluminium premium. Cocok untuk menumis harian.',
            'price' => 125000,
            'stock' => 15,
            'image' => 'wajan.jpg',
        ]);

        Product::create([
            'category_id' => $dapur->id,
            'name' => 'Set Pisau Dapur Stainless Steel',
            'slug' => Str::slug('Set Pisau Dapur Stainless Steel'),
            'description' => 'Satu set pisau dapur isi 5 pcs tajam dilengkapi dengan gunting masak dan talenan.',
            'price' => 85000,
            'stock' => 20,
            'image' => 'pisau.jpg',
        ]);

        // Kategori 2
        $kebersihan = Category::create([
            'name' => 'Kebersihan & Wadah',
            'slug' => 'kebersihan-wadah',
        ]);

        Product::create([
            'category_id' => $kebersihan->id,
            'name' => 'Kotak Kontainer Serbaguna 30L',
            'slug' => Str::slug('Kotak Kontainer Serbaguna 30L'),
            'description' => 'Kotak penyimpanan transparan dengan roda, kuat untuk menyimpan pakaian atau mainan anak.',
            'price' => 65000,
            'stock' => 30,
            'image' => 'kontainer.jpg',
        ]);
    }
}
