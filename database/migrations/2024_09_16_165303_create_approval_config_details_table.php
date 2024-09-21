<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_config_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('approval_config_id')->nullable();
            $table->tinyInteger('sequence_number');
            $table->string('module')->nullable();
            $table->unsignedBigInteger('module_id')->nullable();
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
        Schema::dropIfExists('approval_config_details');
    }
};
