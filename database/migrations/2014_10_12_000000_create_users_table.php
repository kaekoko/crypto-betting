<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('msisdn');
            $table->string('password');
            $table->string('total_win')->default(0);
            $table->integer('status')->default(0);
            $table->double('amount')->default(0);
            $table->integer('is_suspend')->default(0);
            $table->string('role');
            $table->string('img')->nulalble();
            $table->string('device_token')->nulalble();
            $table->string('referal_code')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
