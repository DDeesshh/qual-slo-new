<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('queries', function (Blueprint $table) {
            $table->id('query_id');
            $table->bigInteger('user_id');
            $table->bigInteger('category_id');
            $table->string('title');
            $table->string('status');
            $table->text('description');
            $table->string('photo_before');
            $table->string('photo_after')->nullable();
            $table->integer('role')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queries');
    }
};
