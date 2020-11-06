<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boards extends Model {
    public function threads(){
        return $this->hasMany(Threads::class, "board_id");
    }
}
