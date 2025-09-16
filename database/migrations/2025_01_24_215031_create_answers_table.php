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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id'); // ربط الإجابة بالسؤال
            $table->text('answer_text'); // نص الإجابة
            $table->boolean('is_correct')->default(false); // تحديد إذا كانت الإجابة صحيحة أم لا
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade'); // مفتاح خارجي
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
};
