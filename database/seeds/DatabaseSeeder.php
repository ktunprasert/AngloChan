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
        DB::table("boards")->insert([
            ["id"=> 1,"slug" => "a", "name" => "Anime"],
            ["id"=> 2,"slug" => "g", "name" => "Technology"],
            ["id"=> 3,"slug" => "fit", "name" => "Fitness & Health"],
        ]);
        
        $boards = Boards::all();
        DB::table("threads")->insert([
            ["board_id" => 1, "title" => "Ozzies banned Anime", "content" => "AUSSIES POSTERS BTFO", "has_file" => false],
            ["board_id" => 2, "title" => "Based Terry predicting the future", "content" => "How can one man be so based?", "has_file" => false],
        ]);
    }
}
