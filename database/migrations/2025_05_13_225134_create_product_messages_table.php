<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_messages', function (Blueprint $table) {
            $table->id();
            
            // Связь с товаром
            $table->foreignId('product_id')
                  ->constrained()
                  ->cascadeOnDelete();
            
            // Отправитель (пользователь)
            $table->foreignId('sender_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            
            // Получатель (продавец)
            $table->foreignId('receiver_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            
            // Текст сообщения
            $table->text('message');
            
            // Флаг прочтения (по умолчанию false)
            $table->boolean('is_read')->default(false);
            
            // Ссылка на родительское сообщение (для цепочки ответов)
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('product_messages')
                  ->nullOnDelete();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_messages');
    }
};
