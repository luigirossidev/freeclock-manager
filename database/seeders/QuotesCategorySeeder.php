<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuotesCategory;

class QuotesCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Motivazionale', 'locale' => 'it'],
            ['name' => 'Motivational', 'locale' => 'en'],
        ];

        foreach ($categories as $category) {
            QuotesCategory::firstOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
