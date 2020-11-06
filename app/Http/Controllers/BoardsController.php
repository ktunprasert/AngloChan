<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Boards;

class BoardsController extends Controller
{
    public function get(Request $request){
        $boards = Boards::all();
        return [
            "status" => "ok",
            "data" => $boards
        ]
    }
}
