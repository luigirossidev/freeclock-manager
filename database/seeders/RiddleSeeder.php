<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Riddle;
use App\Models\RiddlesCategory;

class RiddleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = RiddlesCategory::where("name", "Facili")->first();
        
        if (!$category) {
            $this->command->error("Categoria Facili non trovata. Esegui prima RiddlesCategorySeeder.");
            return;
        }

        $riddlesJson = file_get_contents(__DIR__ . '/data/riddles.json');
        $riddles = json_decode($riddlesJson, true);

        foreach ($riddles as $riddleData) {
            Riddle::firstOrCreate(
                [
                    "riddle" => $riddleData["riddle"],
                    "answer" => $riddleData["answer"],
                ],
                [
                    "riddle" => $riddleData["riddle"],
                    "answer" => $riddleData["answer"],
                    "category_id" => $category->id,
                ]
            );
        }

        $this->command->info("Indovinelli inseriti con successo!");
    }
}
