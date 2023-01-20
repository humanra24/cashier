<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Hurasan',
            'email' => 'admin@hurasan.com',
            'password' => Hash::make('@Hurasan24'),
            'level' => 0
        ]);

        $user = User::create([
            'name' => 'pandawa',
            'email' => 'admin@pandawa.com',
            'password' => Hash::make('@Pandawa5')
        ]);

        Store::create([
            'name'  => 'Toko Pandawa',
            'telegram'  => '0852916469684',
            'address'   => 'Dusun Sudimara rt 03/06 Bantarmangu, Cimanggu, Cilacap',
            'user_id'   => $user->id
        ]);
    }
}
