<?php

namespace Database\Seeders;

use App\Models\Type;
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

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '12345678',
        ]);

        foreach (['Цветочный магазин', 'Обувной магазин', 'Закусочная', 'Кинотеатр для двоих'] as $title) {
            Type::factory()->create([
                'title' => $title,
            ]);
        }
    }
}
