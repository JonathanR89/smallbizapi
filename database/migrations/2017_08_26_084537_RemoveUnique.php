<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('airtable_consultants', function (Blueprint $table) {
            $table->dropUnique('airtable_consultants_airtable_id_unique');
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
            $table->dropUnique('airtable_consultants_airtable_id_unique');
        });
    }
}
