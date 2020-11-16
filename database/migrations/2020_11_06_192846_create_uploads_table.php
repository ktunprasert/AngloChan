<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use App\Uploads;

class CreateUploadsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("post_id");
            $table->text("file_name");
            $table->text("file_path");
            $table->text("mime_type");
            $table->text("file_size")->nullable();
            $table->text("file_resolution")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        $uploads = Uploads::all();
        foreach ($uploads as $u) {
            File::delete("public/uploads/{$u->file_path}");
            try {
                File::delete("public/uploads/{$u->file_path}");
            } catch (Exception $e) {
                continue;
            }
        }
        Schema::dropIfExists('uploads');
    }
}
