<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posts;
use App\Boards;
use Image;
use App\Uploads;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller {
    public function store(Request $request) {
        $this->validate($request, [
            "board" => "required",
            // "title" => "required",
            "file.*" => "mimes:jpeg,jpg,gif,png,webm|max:8192",
            "content" => "required"
        ]);
        $board = Boards::where("slug", $request->board)->first();
        $post = new Posts();
        $post->board_id = $board->id;
        $post->title = $request->title;
        $post->name = $request->name ?? null;
        $post->thread_id = $request->thread_id ?? null;
        $post->has_file = $request->has_file === 'true' ? true : false;
        $post->option = $request->option ?? null;
        $post->content = $request->content;
        $post->is_thread = $request->is_thread === 'true' ? true : false;
        $post->save();

        if ($post->thread_id) {
            $thread = Posts::find($request->thread_id);
            $thread->replies += 1;
            if ($request->has("file") && $request->file->getSize()) {
                $thread->files += 1;
            }
            $thread->save();
        }

        if ($request->has("file") && $request->file->getSize()) {
            $upload    = new Uploads();
            $file      = $request->file;
            $fn        = $file->getClientOriginalName();
            $mime      = $file->getMimeType();
            $file_path = implode(".", explode(".", $fn, -1)) . ".{$file->hashName()}";

            // Make the thumbnail
            if ($mime == "video/webm") {
                $tmp = $_FILES['file']['tmp_name'];
                $thumbnail = implode(".", explode(".", $file_path, -1)) . ".jpg";
                if (config("app.env") === "local") {
                    putenv('PATH="C:\Program Files\ImageMagick-7.0.8-Q16\"');
                } else {
                    putenv('PATH=/usr/local/bin');
                }
                $out = shell_exec("ffmpeg -y -i {$tmp} -vframes 1 -filter:v scale='-1:300' \"thumbnails/" . $thumbnail . "\" 2>&1");
                $post->out = $out;
            } else {
                Image::make($request->file)->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save("thumbnails/" . $file_path);
            }

            if ($file->move("uploads", $file_path)) {
                $upload->file_name   = $fn;
                $upload->file_path   = $file_path;
                $upload->post_id    = $post->id;
                $upload->mime_type   = $mime;
                $upload->save();
            }
            $post->upload = $upload;
        } else {
            $post->upload = null;
        }
        return $post;
    }

    public function grab_thread(Request $request) {
        if (!$request->has("id")) {
            return ["status" => "error", "message" => "Required parameter 'id' is missing", "data" => []];
        }
        $threads = Posts::with(["upload"])->where("id", $request->id)->orWhere("thread_id", $request->id)->orderBy("id", "asc")->get();
        return ["status" => "ok", "data" => $threads];
    }
}
