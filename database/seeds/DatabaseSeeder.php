<?php

use Illuminate\Database\Seeder;
use App\Boards;
use App\Threads;
use App\Posts;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $boards = [
            ["slug" => "a", "name" => "Anime"],
            ["slug" => "g", "name" => "Technology"],
            ["slug" => "fit", "name" => "Fitness & Health"],
        ];

        foreach($boards as $b){
            $new_board = new Boards();
            $new_board->slug = $b['slug'];
            $new_board->name = $b['name'];
            $new_board->save();
        }
    }
}
