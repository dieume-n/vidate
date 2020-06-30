<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('channel_id')->constrained()->onDelete('cascade');
            $table->string('uid')->unique()->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('processed')->default(false);
            $table->string('video_filename')->nullable();
            $table->string('video_url')->nullable();
            $table->string('video_public_id')->nullable();
            $table->enum('visibility', ['public', 'unlisted', 'private']);
            $table->boolean('allow_votes')->default(false);
            $table->boolean('allow_comments')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
