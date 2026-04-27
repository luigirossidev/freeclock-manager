<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RiddlesCategory;

class RiddlesCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Facili', 'locale' => 'it'],
            ['name' => 'Easy', 'locale' => 'en'],
        ];

        foreach ($categories as $category) {
            RiddlesCategory::firstOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
