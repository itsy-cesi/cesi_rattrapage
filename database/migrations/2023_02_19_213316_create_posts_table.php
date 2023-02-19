<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table)
        {
            $table->id();
            $table->string('message');
            $table->integer('author_id')->nullable();
            $table->string('media_1')->nullable();
            $table->string('media_2')->nullable();
            $table->string('media_3')->nullable();
            $table->string('media_4')->nullable();
            $table->dateTime('post_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
