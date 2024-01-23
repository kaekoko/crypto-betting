<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBetSlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bet_slips', function (Blueprint $table) {
            $table->id();
            $table->string('section')->nullable();
            $table->string('number')->nullable();
            $table->double('amount')->default(0);
            $table->integer('user_id');
            $table->integer('bet_id');
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('bet_slips');
    }
}
