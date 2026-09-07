<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // User Admin
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'nama_depan' => 'Admin',
                'nama_belakang' => 'SIPENTA',
                'username' => 'admin',
                'instansi' => 'Dinas Kesehatan',
                'email' => 'admin@sipenta.com',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
            ]
        );

        // User Kepala Dinas Kesehatan
        User::updateOrCreate(
            ['username' => 'kadis'],
            [
                'nama_depan' => 'Kepala Dinas',
                'nama_belakang' => 'Kesehatan',
                'username' => 'kadis',
                'instansi' => 'Dinas Kesehatan',
                'email' => 'kadis@sipenta.com',
                'role' => 'kadis',
                'password' => Hash::make('kadis123'),
            ]
        );
    }
}