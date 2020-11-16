<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("board_id");
            $table->unsignedBigInteger("thread_id")->nullable();
            $table->text("name")->nullable();
            $table->text("title")->nullable();
            $table->text("option")->nullable();
            $table->longText("content");
            $table->boolean("has_file")->default(true);
            $table->boolean("is_thread")->default(false);
            $table->integer("replies")->default(1);
            $table->integer("files")->default(1);
            $table->boolean("is_sticky")->default(false);
            $table->dateTime("latest_reply")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('posts');
    }
}
