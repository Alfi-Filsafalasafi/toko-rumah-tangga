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
        // Kategori 1 - Peralatan Dapur
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

        Product::create([
            'category_id' => $dapur->id,
            'name' => 'Panci Presto 5 Liter',
            'slug' => Str::slug('Panci Presto 5 Liter'),
            'description' => 'Panci presto stainless steel 5 liter dengan katup pengaman. Hemat waktu dan gas memasak.',
            'price' => 320000,
            'stock' => 10,
            'image' => 'panci-presto.jpg',
        ]);

        Product::create([
            'category_id' => $dapur->id,
            'name' => 'Spatula Kayu Set 3 Pcs',
            'slug' => Str::slug('Spatula Kayu Set 3 Pcs'),
            'description' => 'Spatula kayu jati alami, aman untuk wajan teflon dan anti jamur. Set isi 3 ukuran berbeda.',
            'price' => 45000,
            'stock' => 40,
            'image' => 'spatula-kayu.jpg',
        ]);

        Product::create([
            'category_id' => $dapur->id,
            'name' => 'Talenan Kayu Tebal 30x20cm',
            'slug' => Str::slug('Talenan Kayu Tebal 30x20cm'),
            'description' => 'Talenan kayu solid tebal 3cm, tidak mudah retak dan ramah lingkungan untuk dapur.',
            'price' => 75000,
            'stock' => 25,
            'image' => 'talenan.jpg',
        ]);

        // Kategori 2 - Kebersihan & Wadah
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

        Product::create([
            'category_id' => $kebersihan->id,
            'name' => 'Sapu Lantai Bulu Halus',
            'slug' => Str::slug('Sapu Lantai Bulu Halus'),
            'description' => 'Sapu lantai dengan bulu halus dan padat, efektif membersihkan debu halus di ubin dan keramik.',
            'price' => 38000,
            'stock' => 50,
            'image' => 'sapu.jpg',
        ]);

        Product::create([
            'category_id' => $kebersihan->id,
            'name' => 'Ember Plastik 20L dengan Tutup',
            'slug' => Str::slug('Ember Plastik 20L dengan Tutup'),
            'description' => 'Ember plastik tebal kapasitas 20 liter dilengkapi tutup rapat, cocok untuk mencuci dan penyimpanan.',
            'price' => 42000,
            'stock' => 35,
            'image' => 'ember.jpg',
        ]);

        // Kategori 3 - Elektronik Rumah
        $elektronik = Category::create([
            'name' => 'Elektronik Rumah',
            'slug' => 'elektronik-rumah',
        ]);

        Product::create([
            'category_id' => $elektronik->id,
            'name' => 'Kipas Angin Meja 12 Inch',
            'slug' => Str::slug('Kipas Angin Meja 12 Inch'),
            'description' => 'Kipas meja hemat energi 3 kecepatan, senyap dan cocok untuk kamar atau ruang kerja.',
            'price' => 185000,
            'stock' => 18,
            'image' => 'kipas-meja.jpg',
        ]);

        Product::create([
            'category_id' => $elektronik->id,
            'name' => 'Stop Kontak 4 Lubang dengan USB',
            'slug' => Str::slug('Stop Kontak 4 Lubang dengan USB'),
            'description' => 'Stop kontak 4 lubang dilengkapi 2 port USB, kabel 1.8m, aman dengan proteksi arus lebih.',
            'price' => 95000,
            'stock' => 22,
            'image' => 'stop-kontak.jpg',
        ]);

        // Kategori 4 - Kamar & Tidur
        $kamar = Category::create([
            'name' => 'Kamar & Tidur',
            'slug' => 'kamar-tidur',
        ]);

        Product::create([
            'category_id' => $kamar->id,
            'name' => 'Bantal Tidur Premium Microfiber',
            'slug' => Str::slug('Bantal Tidur Premium Microfiber'),
            'description' => 'Bantal tidur isi microfiber lembut dan hypoallergenic, nyaman untuk leher dan punggung.',
            'price' => 55000,
            'stock' => 45,
            'image' => 'bantal.jpg',
        ]);

        Product::create([
            'category_id' => $kamar->id,
            'name' => 'Rak Dinding Minimalis 60cm',
            'slug' => Str::slug('Rak Dinding Minimalis 60cm'),
            'description' => 'Rak dinding kayu MDF finishing minimalis 60cm, kuat menopang hingga 15kg. Mudah dipasang.',
            'price' => 110000,
            'stock' => 20,
            'image' => 'rak-dinding.jpg',
        ]);

        Product::create([
            'category_id' => $kamar->id,
            'name' => 'Cermin Hias Bulat Diameter 50cm',
            'slug' => Str::slug('Cermin Hias Bulat Diameter 50cm'),
            'description' => 'Cermin hias bentuk bulat dengan frame rotan natural, estetik untuk dekorasi kamar atau ruang tamu.',
            'price' => 145000,
            'stock' => 12,
            'image' => 'cermin-bulat.jpg',
        ]);
    }
}
