<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conferences', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم الفعالية
            $table->enum('type', ['ورشة عمل', 'مؤتمر', 'ندوة']); // النوع
            $table->dateTime('event_date'); // التاريخ 
            $table->text('speakers'); // أسماء المتحدثين
            $table->unsignedInteger('participants'); // عدد المشاركين
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
        Schema::dropIfExists('conferences');
    }
}
