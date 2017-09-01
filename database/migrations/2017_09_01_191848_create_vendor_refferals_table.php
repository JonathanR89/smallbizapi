<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorRefferalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_refferals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('submission_id');
            $table->integer('user_id');
            $table->string('package_name');
            $table->integer('package_id')->nullable();
            $table->integer('airtable_vendor_id')->nullable();
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
        Schema::dropIfExists('vendor_refferals');
    }
}
