<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        if (User::count() === 0) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
            ]);
        }

        // Seed delle categorie e dei dati
        $this->call([
            QuotesCategorySeeder::class,
            RiddlesCategorySeeder::class,
            QuoteSeeder::class,
            RiddleSeeder::class,
            QuoteEnSeeder::class,
            RiddleEnSeeder::class,
        ]);
    }
}
