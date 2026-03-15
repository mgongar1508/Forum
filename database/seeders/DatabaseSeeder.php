<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Image;
use App\Models\Message;
use App\Models\Post;
use App\Models\Subforum;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesSeeder::class);
        $users = User::factory(15)->create();
        $this->call(SubforumSeeder::class);
        $this->call(TagSeeder::class);

        $subforums = Subforum::all();
        $tags = Tag::all();

        $users->each(function ($user) use ($users) {
            $user->assignRole('user');
            if (rand(1, 100) <= 20) {
                $user->assignRole('moderator');
            }
            $toFollow = $users->where('id', '!=', $user->id)->random(rand(2, 6));

            $toFollow->each(function ($followed) use ($user) {
                DB::table('follows')->insert([
                    'following_user_id' => $user->id,
                    'followed_user_id' => $followed->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
        });

        $admin = User::factory()->create([
            'email' => 'admin@example.com',
        ]);

        $admin->assignRole('admin');

        foreach ($subforums as $subforum) {
            Post::factory(10)->create([
                'subforum_id' => $subforum->id,
                'user_id' => $users->random()->id,
            ])->each(function ($post) use ($tags) {

                $post->tags()->attach(
                    $tags->random(rand(1, 3))->pluck('id')->toArray()
                );

                Comment::factory(rand(1, 5))->create([
                    'commentable_id' => $post->id,
                    'commentable_type' => Post::class,
                ]);

                Image::factory(rand(1, 3))->create([
                    'imageable_id' => $post->id,
                    'imageable_type' => Post::class,
                ]);
            });
        }

        foreach ($users as $user) {
            Comment::factory(rand(0, 3))->create([
                'commentable_id' => $user->id,
                'commentable_type' => User::class,
            ]);
        }

        $users->each(function ($user) use ($subforums) {
            $subscriptions = $subforums->random(rand(1, 3));

            $subscriptions->each(function ($subforum) use ($user) {
                DB::table('subforum_user')->insert([
                    'subforum_id' => $subforum->id,
                    'user_id' => $user->id,
                    'notify_new_posts' => (bool) rand(0, 1),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
        });

        $users->each(function ($user) use ($users) {

            // 2-5 randoms to speak
            $partners = $users->where('id', '!=', $user->id)->random(rand(2, 5));

            $partners->each(function ($partner) use ($user) {

                // messages per conversation
                Message::factory(rand(1, 8))->make()->each(function ($message) use ($user, $partner) {

                    // rng sender
                    $sender = rand(0, 1) ? $user : $partner;
                    $receiver = $sender->id === $user->id ? $partner : $user;

                    $message->sender_id = $sender->id;
                    $message->receiver_id = $receiver->id;
                    $message->save();

                    // images per message, not all
                    Image::factory()->create([
                        'imageable_id' => $message->id,
                        'imageable_type' => Message::class,
                    ]);
                });
            });
        });

        $allPosts = Post::all();

        $users->each(function ($user) use ($allPosts) {
            $likedPosts = $allPosts->random(rand(5, 15));

            $likedPosts->each(function ($post) use ($user) {
                DB::table('post_likes')->insert([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                    'type' => rand(0, 1) ? 'Like' : 'Dislike',
                    'created_at' => now(),
                ]);
            });
        });
    }
}
