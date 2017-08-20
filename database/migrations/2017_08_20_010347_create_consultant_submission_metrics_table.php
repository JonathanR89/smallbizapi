<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultantSubmissionMetricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultant_submission_metrics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('submission_id');
            $table->string('model')->nullable();
            $table->integer('question_id');
          
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
        Schema::dropIfExists('consultant_submission_metrics');
    }
}
