<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Boards;
use App\Threads;

class ThreadsController extends Controller
{
    public function get(Request $request){
        if ($request->has("board_slug") && $request->filled("board_slug")){
            $board = Boards::where("slug", $request->board_slug)->first();
            $threads = Threads::where("board_id", $board->id)->get();
            return [
                "status" => "ok",
                "data" => $threads
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Invalid request, board_slug is required",
                "data" => []
            ];
        }
    }
}
