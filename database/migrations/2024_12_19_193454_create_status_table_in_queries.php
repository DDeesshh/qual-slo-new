<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// миграция по изменению настроек поля status (по дефолту значение 'новая')

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('queries', function (Blueprint $table) {
            $table->string('status')->default('Новая')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('queries', function (Blueprint $table) {
            $table->string('status')->nullable()->change(); //Возвращаем к nullable, если это нужно
        });
    }
};
