<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('commentable_id');
            $table->string('commentable_type');
            $table->text('body');
            $table->unsignedBigInteger('reply_id')->nullable();
            $table->foreign('reply_id')->references('id')->on('comments')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });

        // Schema::table('comments', function (Blueprint $table) {
        //     $table->foreign('reply_id')->references('id')->on('comments')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
