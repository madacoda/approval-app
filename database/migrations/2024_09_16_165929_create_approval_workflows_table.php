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
        Schema::create('approval_workflows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('approval_config_detail_id')->nullable();
            $table->string('module')->nullable();
            $table->unsignedBigInteger('module_id')->nullable();
            $table->text('comment')->nullable();
            $table->tinyInteger('sequence_number');
            $table->string('approver_module')->nullable();
            $table->unsignedBigInteger('approver_module_id')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('approval_workflows');
    }
};
