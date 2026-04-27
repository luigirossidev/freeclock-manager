<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Riddle;
use App\Models\RiddlesCategory;

class RiddleEnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = RiddlesCategory::where('name', 'Easy')->where('locale', 'en')->first();

        if (!$category) {
            $this->command->error("Category 'Easy' (en) not found. Run RiddlesCategorySeeder first.");
            return;
        }

        $riddlesJson = file_get_contents(__DIR__ . '/data/riddles_en.json');
        $riddles = json_decode($riddlesJson, true);

        foreach ($riddles as $riddleData) {
            Riddle::firstOrCreate(
                [
                    'riddle' => $riddleData['riddle'],
                    'answer' => $riddleData['answer'],
                ],
                [
                    'riddle' => $riddleData['riddle'],
                    'answer' => $riddleData['answer'],
                    'category_id' => $category->id,
                ]
            );
        }

        $this->command->info("386 English riddles seeded successfully!");
    }
}
