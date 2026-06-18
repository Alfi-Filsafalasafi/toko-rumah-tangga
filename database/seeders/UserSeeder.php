<?php
// database/seeders/UserSeeder.php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Admin Toko
        User::create([
            'name' => 'Admin Rumah Tangga',
            'email' => 'admin@toko.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Kantor Pusat Admin Gudang',
        ]);

        // Akun Pembeli / User Biasa
        User::create([
            'name' => 'Dimas Pembeli',
            'email' => 'dimas@pembeli.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'phone' => '089876543210',
            'address' => 'Jl. Kebon Jeruk No. 12, Jakarta Barat',
        ]);
    }
}
