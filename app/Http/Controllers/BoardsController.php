<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Boards;
use App\Posts;

class BoardsController extends Controller {
    public function get(Request $request) {
        $boards = Boards::all();
        return [
            "status" => "ok",
            "data" => $boards
        ];
    }

    public function list(Request $request) {
        if ($request->has("board_slug") && $request->filled("board_slug")) {
            $board = Boards::where("slug", $request->board_slug)->first();
            if (!$board) {
                return [
                    "status" => "error",
                    "message" => "Board not found",
                    "data" => []
                ];
            }
            $threads = Posts::with(["upload"])->where("board_id", $board->id)->where("is_thread", true)->orderBy("updated_at", "desc")->get();
            if (!$threads->count()) {
                return [
                    "status" => "empty",
                    "message" => "No threads found",
                    "data" => []
                ];
            }
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
