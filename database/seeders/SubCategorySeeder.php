<?php

namespace Database\Seeders;

use App\Models\SubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubCategory::create([
            'name' => 'Casual',
            'category' => 'men',
            'status' => 1,
        ]);
    }
}
