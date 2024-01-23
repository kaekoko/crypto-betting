<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->integer('min_amount')->default(0);
            $table->integer('max_amount')->default(0);
            $table->double('overall_amount')->default(0);
            $table->integer('odd')->default(0);
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('version_code')->nullable();
            $table->string('version_name')->nullable();
            $table->integer('force_update')->default(0);
            $table->string('title_crypto')->nullable();
            $table->longText('description_crypto')->nullable();
            $table->string('version_code_crypto')->nullable();
            $table->string('version_name_crypto')->nullable();
            $table->integer('force_update_crypto')->default(0);
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
        Schema::dropIfExists('settings');
    }
}
