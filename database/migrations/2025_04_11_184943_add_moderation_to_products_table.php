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
            // Добавляем проверку существования столбца
            if (!Schema::hasColumn('products', 'moderation_status')) {
                $table->tinyInteger('moderation_status')
                    ->default(0)
                    ->comment('0-на модерации, 1-одобрено, 2-отклонено');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Добавляем безопасное удаление
            if (Schema::hasColumn('products', 'moderation_status')) {
                $table->dropColumn('moderation_status');
            }
        });
    }
};
