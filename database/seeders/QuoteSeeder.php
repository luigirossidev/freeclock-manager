<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quote;
use App\Models\QuotesCategory;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = QuotesCategory::where("name", "Motivazionale")->first();
        
        if (!$category) {
            $this->command->error("Categoria Motivazionale non trovata. Esegui prima QuotesCategorySeeder.");
            return;
        }

        $quotesJson = file_get_contents(__DIR__ . '/data/quotes.json');
        $quotes = json_decode($quotesJson, true);

        foreach ($quotes as $quoteText) {
            Quote::firstOrCreate(
                ["quote" => $quoteText],
                [
                    "quote" => $quoteText,
                    "category_id" => $category->id,
                ]
            );
        }

        $this->command->info("Citazioni inserite con successo!");
    }
}
