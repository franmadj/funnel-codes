<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_banks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('funnel_id')->unsigned();
            $table->foreign('funnel_id')->references('id')->on('funnels')->onDelete('cascade');
            
            $table->string('name',255);
            $table->integer('no_of_coupons')->default(0);
            $table->integer('no_of_redeemed')->unsigned()->default(0);
            $table->enum('type', ['general', 'single']);
            
            $table->text('description')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon_banks');
    }
}
