<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table)
        {
            $table->id();
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('picture')->nullable();
            $table->string('banner')->nullable();
            $table->string('password');
            $table->string('dob');
            $table->string('gender');
            $table->timestamp('last_connection')->nullable();
            $table->timestamp('creation_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}