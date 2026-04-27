<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quote;
use App\Models\QuotesCategory;

class QuoteEnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = QuotesCategory::where('name', 'Motivational')->where('locale', 'en')->first();

        if (!$category) {
            $this->command->error("Category 'Motivational' (en) not found. Run QuotesCategorySeeder first.");
            return;
        }

        $quotesJson = file_get_contents(__DIR__ . '/data/quotes_en.json');
        $quotes = json_decode($quotesJson, true);

        foreach ($quotes as $quoteText) {
            Quote::firstOrCreate(
                ['quote' => $quoteText],
                [
                    'quote' => $quoteText,
                    'category_id' => $category->id,
                ]
            );
        }

        $this->command->info("1618 English quotes seeded successfully!");
    }
}
