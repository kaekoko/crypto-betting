<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_outs', function (Blueprint $table) {
            $table->id();
            $table->integer('payment_id');
            $table->double('amount')->default(0);
            $table->double('old_amount')->default(0);
            $table->double('new_amount')->default(0);
            $table->integer('user_id');
            $table->string('name')->nullable();
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
        Schema::dropIfExists('cash_outs');
    }
}
