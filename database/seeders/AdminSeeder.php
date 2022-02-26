<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Petugas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Petugas::create([
            'username' => 'admin',
            'email' => 'admin@spp.com',
            'password' => Hash::make('password'),
            'nama_petugas' => 'Admin Pangestuk',
            'level' => 'admin'
        ]);

        User::create([
            'name' => 'Admin Pangestuk',
            'email' => 'admin@spp.com',
            'password' => Hash::make('password'),
            'level' => 'admin'
        ]);
    }
}
