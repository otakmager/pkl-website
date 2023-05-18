<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TMasuk;
use App\Models\TKeluar;
use App\Models\Label;
use App\Models\Dana;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::create([
        //     'name' => 'Dimas Wahyu Ardiyanto',
        //     'username' => 'dimas',
        //     'email' => 'dimazwahyuardiyanto@gmail.com',
        //     'password' => bcrypt('password'),
        //     'level' => 'pimpinan',
        //     'status' => 1,
        // ]);
        // User::create([
        //     'name' => 'Aril Arzaqi',
        //     'username' => 'arzaqi',
        //     'email' => 'arilarzaqi@gmail.com',
        //     'password' => bcrypt('password'),
        //     'level' => 'user',
        //     'status' => 1,
        // ]);
        // Label::create([
        //     'name' => 'Reparasi',
        //     'slug' => 'reparasi',
        //     'jenis' => 0,
        // ]);
        // Label::create([
        //     'name' => 'Jualan',
        //     'slug' => 'jualan',
        //     'jenis' => 0,
        // ]);
        // Label::create([
        //     'name' => 'Kas',
        //     'slug' => 'kas',
        //     'jenis' => 0,
        // ]);
        // Label::create([
        //     'name' => 'Uang Tips',
        //     'slug' => 'uang-tips',
        //     'jenis' => 0,
        // ]);
        // Label::create([
        //     'name' => 'Gaji',
        //     'slug' => 'gaji',
        //     'jenis' => 1,
        // ]);
        // Label::create([
        //     'name' => 'Beli Alat dan Bahan',
        //     'slug' => 'beli-alat-bahan',
        //     'jenis' => 1,
        // ]);
        // Label::create([
        //     'name' => 'Donasi',
        //     'slug' => 'donasi',
        //     'jenis' => 1,
        // ]);
        // Label::create([
        //     'name' => 'Sewa',
        //     'slug' => 'sewa',
        //     'jenis' => 1,
        // ]);
        // Label::create([
        //     'name' => 'Pajak',
        //     'slug' => 'pajak',
        //     'jenis' => 1,
        // ]);
        // User::factory(3)->create();
        // TMasuk::factory(150)->create();
        // TKeluar::factory(150)->create();
        User::create([
            'name' => 'CV Berkah Makmur',
            'username' => 'berkahmakmurofficial',
            'email' => 'cvberkahmakmur@gmail.com',
            'password' => bcrypt('password'),
            'level' => 'pimpinan',
            'status' => 1,
        ]);
        Dana::factory(1)->create();
    }
}
