<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(10),
            "admin_id" => random_int(1, 10),
            'content' => $this->faker->paragraphs(3, true), // Generates 3 paragraphs of dummy text
            'status' => 1,
        ];
    }
}
