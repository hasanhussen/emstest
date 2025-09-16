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
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
        $table->string('title');
        $table->string('email');
        $table->string('facebook');
        $table->string('instagram');
        $table->string('twitter');
        $table->string('whatsApp');
        $table->string('telegram');
        $table->text('overview');
        $table->string('phone');
        $table->string('image');
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
        Schema::dropIfExists('abouts');
    }
};
