<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('status', function (Blueprint $table) {
            $table->id();
            $table->string('status')->unique();
            $table->timestamps();
        });

        // Добавить базовые значения статусов:
        DB::table('status')->insert([
            ['status' => 'новая'],
            ['status' => 'в работе'],
            ['status' => 'завершена'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('status');
    }
};
