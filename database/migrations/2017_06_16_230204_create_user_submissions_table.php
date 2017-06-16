<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_submissions', function (Blueprint $table) {
              $table->increments('id');
              $table->string('email')->nullable();
              $table->string('name')->nullable();
              $table->string('price')->nullable();
              $table->string('industry')->nullable();
              $table->string('comments')->nullable();
              $table->string('fname')->nullable();
              $table->string('total_users')->nullable();

              $table->rememberToken();
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
        Schema::dropIfExists('user_submissions');
    }
}
