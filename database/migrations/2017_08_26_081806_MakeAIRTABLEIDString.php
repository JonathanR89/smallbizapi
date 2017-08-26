<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeAIRTABLEIDString extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('airtable_consultants', function (Blueprint $table) {
            $table->string('airtable_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('airtable_consultants', function (Blueprint $table) {
            $table->dropColumn('airtable_id');
        });
    }
}
