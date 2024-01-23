<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_ins', function (Blueprint $table) {
            $table->id();
            $table->integer('payment_id');
            $table->double('amount')->default(0);
            $table->double('old_amount')->default(0);
            $table->double('new_amount')->default(0);
            $table->integer('user_id');
            $table->string('name')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('credential')->nullable();
            $table->integer('approve')->nullable();
            $table->date('date');
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
        Schema::dropIfExists('cash_ins');
    }
}
