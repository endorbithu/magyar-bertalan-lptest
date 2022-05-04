<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('composer_lp', function (Blueprint $table) {
            $table->unsignedBigInteger('lp_id')->nullable();
            $table->foreign('lp_id', 'fk_composer_lp_lp')->on('lps')->references('id')->cascadeOnUpdate()->cascadeOnDelete();;

            $table->unsignedBigInteger('composer_id')->nullable();
            $table->foreign('composer_id', 'fk_composer_lp_composer')->on('composers')->references('id')->cascadeOnUpdate()->cascadeOnDelete();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('composer_lp');
    }
};
