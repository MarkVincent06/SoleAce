<?php

namespace Database\Seeders;

use App\Models\SubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subCategories = [
            [
                'name' => 'Sneakers',
                'category' => 'men',
                'status' => 1,
            ],
            [
                'name' => 'Formal',
                'category' => 'men',
                'status' => 1,
            ],
            [
                'name' => 'Boots',
                'category' => 'men',
                'status' => 1,
            ],
            [
                'name' => 'Sandals',
                'category' => 'women',
                'status' => 1,
            ],
            [
                'name' => 'Heels',
                'category' => 'women',
                'status' => 1,
            ],
            [
                'name' => 'Flats',
                'category' => 'women',
                'status' => 1,
            ],
            [
                'name' => 'Sneakers',
                'category' => 'kid',
                'status' => 1,
            ],
            [
                'name' => 'Boots',
                'category' => 'kid',
                'status' => 1,
            ],
            [
                'name' => 'Sandals',
                'category' => 'kid',
                'status' => 1,
            ],
        ];

        DB::table('sub_categories')->insert($subCategories);
    }
}
