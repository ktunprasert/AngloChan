<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posts;
use App\Boards;

class PostsController extends Controller
{
    public function store(Request $request){
        $this->validate($request, [
            "board" => "required",
            "title" => "required",
            "content" => "required"
        ]);
        $board = Boards::where("slug", $request->board)->first();
        $post = new Posts();
        $post->name = $request->name ?? null;
        $post->board_id = $board->id;
        $post->title = $request->title;
        $post->option = $request->option ?? null;
        $post->content = $request->content;
        $post->has_file = true;
        $post->is_thread = $request->is_thread === 'true' ? true : false;
        $post->save();
        return $post;

    }
}
