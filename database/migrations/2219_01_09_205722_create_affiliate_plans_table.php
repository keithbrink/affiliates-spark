<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffiliatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->integer('months_of_commission')->default(0);
            $table->integer('commission_percentage')->default(0);
            $table->decimal('commission_amount')->default(0);
            $table->decimal('months_of_discount')->default(0);
            $table->decimal('discount_percentage')->default(0);
            $table->decimal('discount_amount')->default(0);
            $table->integer('level_2_months_of_commission')->default(0);
            $table->integer('level_2_commission_percentage')->default(0);
            $table->decimal('level_2_commission_amount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('affiliate_plans');
    }
}
