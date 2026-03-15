<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\Post;
use App\Models\User;
use Bilions\FakerImages\FakerImageProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageable = $this->faker->randomElement([
            Post::inRandomOrder()->first(),
            Message::inRandomOrder()->first(),
            User::inRandomOrder()->first()
        ]);

        if(!$imageable){
            $imageable = Post::factory()->create();
        }

        fake()->addProvider(new FakerImageProvider(fake()));
        $image = fake()->image(sys_get_temp_dir(), 640, 480);
        return [
            'name' => Storage::putFileAs('images/', new File($image), basename($image)),
            'imageable_id' => $imageable->id,
            'imageable_type' => get_class($imageable),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
