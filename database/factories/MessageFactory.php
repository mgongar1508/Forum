<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sender = User::inRandomOrder()->first();
        $receiver = User::inRandomOrder()->where('id', '!=', $sender->id)->first();

        return [
            'content' => $this->faker->sentence(10),
            'sender_id' => $sender->id ?? 1,
            'receiver_id' => $receiver->id ?? 2,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
