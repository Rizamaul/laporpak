<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() {
    \App\Models\Category::create(['name' => 'IT & Jaringan']);
    \App\Models\Category::create(['name' => 'Kebersihan']);
    \App\Models\Category::create(['name' => 'Sarana Prasarana']);
}
}
