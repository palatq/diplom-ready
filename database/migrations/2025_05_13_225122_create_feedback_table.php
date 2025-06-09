<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->string('name');       // Имя пользователя
            $table->string('email');      // Email для связи
            $table->text('message');      // Текст сообщения
            $table->timestamps();        // created_at и updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedback');
    }
};
