<?php

namespace Database\Factories;

use App\Models\TextContent;
use Illuminate\Database\Eloquent\Factories\Factory;

class TextContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TextContent::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => $this->faker->paragraph(5), 
            'updated_by' => null,  
        ];
    }
}
