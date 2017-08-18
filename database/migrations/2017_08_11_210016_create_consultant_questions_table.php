<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultantQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultant_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('question');
            $table->integer('category_id')->unsigned();
            $table->string('type')->nullable();

            $table->timestamps();
            
            $table->foreign('category_id')
            ->references('id')->on('consultant_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultant_questions');
    }
}
