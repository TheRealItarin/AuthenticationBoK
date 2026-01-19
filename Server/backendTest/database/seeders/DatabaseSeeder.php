<?php

namespace Database\Seeders;

use App\Models\TextContent;
use App\Models\User;
use Dom\Text;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'username' => 'TheWriter',
            'password' => 'password123',
            'role' => 'writer',
        ]);
        User::factory()->create([
            'username' => 'TheReader',
            'password' => 'password123',
            'role' => 'reader',
        ]);

        TextContent::factory()->create([
            'text' => 'This is some initial text content.',
            'updated_by' => 1, 
        ]);
    }
}
