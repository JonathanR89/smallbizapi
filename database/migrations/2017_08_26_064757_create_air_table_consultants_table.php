<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirTableConsultantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airtable_consultants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('airtable_id')->unique();
            $table->string('record_name')->nullable();
            $table->string('company')->nullable();
            $table->text('short_description')->nullable();
            $table->string('email')->nullable();
            $table->text('logo')->nullable();
            $table->string('country')->nullable();
            $table->string('state_province')->nullable();
            $table->string('town')->nullable();
            $table->string('pricing_pm')->nullable();
            $table->text('industry_suitable_for')->nullable();
            $table->string('speciality')->nullable();
            $table->text('target_market')->nullable();
            $table->string('url')->nullable();
            $table->string('test_email')->nullable();
            $table->text('description')->nullable();
            $table->string('email_interested')->nullable();
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
        Schema::dropIfExists('air_table_consultants');
    }
}
