<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model {
    public function upload() {
        return $this->hasOne(Uploads::class, "post_id");
    }
    public function getContentAttribute($content) {
        return nl2br($content);
    }
}
