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
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Kantor Pusat Admin Gudang',
        ]);

        // Akun Pembeli / User Biasa
        User::create([
            'name' => 'Lia Saripah',
            'email' => 'lia@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'phone' => '089876543210',
            'address' => 'Jl. Kebon Jeruk No. 12, Jakarta Barat',
        ]);

        User::create([
            'name' => 'Siti Rahayu',
            'email' => 'siti@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'phone' => '082345678901',
            'address' => 'Jl. Raya Bogor No. 45, Bogor Utara',
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'phone' => '085678901234',
            'address' => 'Jl. Sudirman No. 8, Surabaya',
        ]);

        User::create([
            'name' => 'Rina Marlina',
            'email' => 'rina@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'phone' => '087890123456',
            'address' => 'Jl. Diponegoro No. 22, Bandung',
        ]);
    }
}
