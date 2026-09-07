<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'user:create-admin';
    protected $description = 'Membuat akun admin';

    public function handle()
    {
        User::updateOrCreate(
            ['username' => 'adminbaru'],
            [
                'nama_depan' => 'Admin',
                'nama_belakang' => 'Utama',
                'instansi' => 'Dinas Kesehatan',
                'email' => 'adminbaru@gmail.com',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
            ]
        );

        $this->info('Admin berhasil dibuat.');
    }
}