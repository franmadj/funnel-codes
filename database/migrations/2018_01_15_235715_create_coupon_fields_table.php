<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponFieldsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('coupon_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coupon_bank_id')->unsigned();
            $table->foreign('coupon_bank_id')->references('id')->on('coupon_banks')->onDelete('cascade');
            $table->string('name', 255);
            $table->text('description')->nullable();
            
            $table->boolean('required')->default(0);
            $table->text('field_type');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('coupon_fields');
    }

}
