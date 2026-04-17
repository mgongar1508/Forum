<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $commentable = $this->faker->randomElement([
            Post::inRandomOrder()->first(),
            User::inRandomOrder()->first(),
        ]);

        // If both are null (early seeding), create a fallback post
        if (! $commentable) {
            $commentable = Post::factory()->create();
        }

        return [
            'body' => $this->faker->sentence(),
            'image' => $this->faker->boolean(30) ? $this->faker->imageUrl(640, 480, 'cats') : null,
            'commentable_id' => $commentable->id,
            'commentable_type' => get_class($commentable),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
