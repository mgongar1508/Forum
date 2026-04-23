<?php

namespace Database\Seeders;

use App\Models\Subforum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubforumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subforums = [
            [
                'name' => 'RPG Games',
                'description' => 'Discussion about role-playing games, story-driven adventures, and character progression.',
                'post_count' => 0,
            ],
            [
                'name' => 'FPS Games',
                'description' => 'Talk about first-person shooters, strategies, and competitive gameplay.',
                'post_count' => 0,
            ],
            [
                'name' => 'Strategy Games',
                'description' => 'All about real-time and turn-based strategy games, tactics, and tips.',
                'post_count' => 0,
            ],
        ];

        foreach($subforums as $s){
            $s['slug'] = Str::slug($s['name']);
            Subforum::create($s);
        }
    }
}
