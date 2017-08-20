<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNameToSubmissionMetric extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultant_submission_metrics', function (Blueprint $table) {
            $table->string('question_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consultant_submission_metrics', function (Blueprint $table) {
            $table->dropColumn('question_name');
        });
    }
}
