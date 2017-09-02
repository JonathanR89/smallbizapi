<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Addvaluestopackagestable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->string('visit_website_url')->nullable();
            $table->text('price')->nullable();
            $table->integer('price_id')->nullable();
            $table->string('country')->nullable();
            $table->string('state_province')->nullable();
            $table->string('town')->nullable();
            $table->string('pricing_pm')->nullable();
            $table->text('industry_suitable_for')->nullable();
            $table->string('speciality')->nullable();
            $table->text('target_market')->nullable();
            $table->text('vendor_email')->nullable();
            $table->text('test_email')->nullable();
            $table->string('email_interested')->nullable();
            $table->string('vertical')->nullable();
            $table->string('has_trial_period')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('visit_website_url');
            $table->dropColumn('price');
            $table->dropColumn('price_id');
            $table->dropColumn('country');
            $table->dropColumn('town');
            $table->dropColumn('pricing_pm');
            $table->dropColumn('industry_suitable_for');
            $table->dropColumn('speciality');
            $table->dropColumn('target_market');
            $table->dropColumn('vendor_email');
            $table->dropColumn('test_email');
            $table->dropColumn('email_interested');
            $table->dropColumn('vertical');
            $table->dropColumn('has_trial_period');
        });
    }
}
