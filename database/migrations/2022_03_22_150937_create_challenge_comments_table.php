<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallengeCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenge_comments', function (Blueprint $table) {
            $table->id();
            $table->integer('challenge_id');
            $table->integer('user_id');
            $table->string('time')->nullable();
            $table->string('comment_media')->nullable();
            $table->string('comment_message')->nullable();
            $table->string('likes')->nullable();
            $table->string('dislikes')->nullable();
            $table->string('islikeselected')->nullable();
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
        Schema::dropIfExists('challenge_comments');
    }
}
