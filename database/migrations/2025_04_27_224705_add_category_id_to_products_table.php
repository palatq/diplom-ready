<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Проверяем, существует ли уже столбец
            if (!Schema::hasColumn('products', 'category_id')) {
                $table->unsignedBigInteger('category_id')->nullable()->after('id');
                
                // Добавляем внешний ключ с явным указанием таблицы
                $table->foreign('category_id')
                      ->references('id')
                      ->on('categories')
                      ->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Правильное удаление внешнего ключа и столбца
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};