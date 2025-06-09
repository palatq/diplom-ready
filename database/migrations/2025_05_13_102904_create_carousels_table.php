<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarouselsTable extends Migration
{
    public function up()
    {
        Schema::create('carousels', function (Blueprint $table) {
            $table->id();
            $table->string('image_path');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true); // Добавляем новый столбец
            $table->string('title')->nullable();        // Опциональные поля
            $table->text('description')->nullable();    // Опциональные поля
            $table->string('link')->nullable();         // Опциональные поля
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('carousels');
    }
}