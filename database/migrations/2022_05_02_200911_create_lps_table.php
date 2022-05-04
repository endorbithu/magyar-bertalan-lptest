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
        Schema::create('lps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('published_on');
            $table->unsignedBigInteger('label_id')->nullable();
            $table->foreign('label_id', 'fk_lp_label')->on('labels')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('lps');
    }
};
