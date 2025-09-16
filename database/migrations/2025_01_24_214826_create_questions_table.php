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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_id'); // ربط السؤال بالاختبار
            $table->text('question_text'); // نص السؤال
            $table->timestamps();

            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade'); // مفتاح خارجي
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
};
