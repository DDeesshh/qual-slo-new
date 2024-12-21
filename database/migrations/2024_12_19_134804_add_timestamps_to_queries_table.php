<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToQueriesTable extends Migration
{
    public function up()
    {
        Schema::table('queries', function (Blueprint $table) {
            $table->timestamps(); // Добавляет created_at и updated_at
        });
    }

    public function down()
    {
        Schema::table('queries', function (Blueprint $table) {
            $table->dropTimestamps(); // Удаляет created_at и updated_at
        });
    }
}

