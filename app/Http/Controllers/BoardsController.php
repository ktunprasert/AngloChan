<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Boards;
use App\Posts;

class BoardsController extends Controller
{
    public function get(Request $request){
        $boards = Boards::all();
        return [
            "status" => "ok",
            "data" => $boards
        ];
    }
    
    public function list(Request $request){
        if ($request->has("board_slug") && $request->filled("board_slug")){
            $board = Boards::where("slug", $request->board_slug)->first();
            $threads = Posts::where("board_id", $board->id)->where("is_thread", true)->get();
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
