<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Action'=> '#FF5733',
            'Adventure' => '#33C1FF',
            'RPG'=> '#9D33FF',
            'FPS'=> '#FF33A6',
            'Strategy'=> '#33FF57',
            'Multiplayer'=> '#FFC733',
            'Indie'=> '#33FFF0',
            'Open World'=> '#FF3333',
            'Simulation'=> '#337BFF',
            'Esports'=> '#B833FF'
        ];

        foreach ($tags as $k=>$v) {
            Tag::create([
                'name' => $k,
                'color'=> $v
            ]);
        }
    }
}
