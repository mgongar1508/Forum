<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::all();
        return [
            'title' => $this->faker->sentence(6, true),
            'body' => $this->faker->paragraphs(3, true),
            'status' => $this->faker->randomElement(['draft','published']),
            'is_locked' => $this->faker->boolean(10), // 10% chance
            'is_pinned' => $this->faker->boolean(5), // 5% chance
            'user_id' => $users->random()->id,
            'subforum_id' => 1, // manually assign or link a factory
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
