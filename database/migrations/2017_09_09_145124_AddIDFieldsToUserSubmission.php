<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIDFieldsToUserSubmission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_submissions', function (Blueprint $table) {
            //
            $table->integer('price_range_id')->nullable();
            $table->integer('industry_id')->nullable();
            $table->integer('user_size_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_submissions', function (Blueprint $table) {
            //
            $table->dropColumn('price_range_id');
            $table->dropColumn('industry_id');
            $table->dropColumn('user_size_id');
        });
    }
}
