<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Boards;
use App\Threads;

class ThreadsController extends Controller
{  
    public function store(Request $request){
        $this->validate($request, [
            "board" => "required",
            "title" => "required",
            "content" => "required"
        ]);
        $board = Boards::where("slug", $request->board)->first();
        $thread = new Threads();
        $thread->board_id = $board->id;
        $thread->title = $request->title;
        $thread->content = $request->content;
        $thread->has_file = true;
        $thread->save();
        return $thread;
    }
}
