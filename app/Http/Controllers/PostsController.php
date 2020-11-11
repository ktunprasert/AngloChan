<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posts;
use App\Boards;
use App\Uploads;

class PostsController extends Controller {
    public function store(Request $request) {
        $this->validate($request, [
            "board" => "required",
            "title" => "required",
            "content" => "required"
        ]);
        $board = Boards::where("slug", $request->board)->first();
        $post = new Posts();
        $post->board_id = $board->id;
        $post->title = $request->title;
        $post->name = $request->name ?? null;
        $post->thread_id = $board->thread_id ?? null;
        $post->option = $request->option ?? null;
        $post->content = $request->content;
        $post->has_file = true;
        $post->is_thread = $request->is_thread === 'true' ? true : false;
        $post->save();

        if ($request->has("file")) {
            $upload    = new Uploads();
            $file      = $request->file;
            $fn        = $file->getClientOriginalName();
            $mime      = $file->getMimeType();
            $file_path = implode(".", explode(".", $fn, -1)) . ".{$file->hashName()}";
            if ($file->move("uploads", $file_path)) {
                $upload->file_name   = $fn;
                $upload->file_path   = $file_path;
                $upload->post_id    = $post->id;
                $upload->mime_type   = $mime;
                $upload->save();
            }
        }
        $post->upload = $upload;
        return $post;
    }
}
