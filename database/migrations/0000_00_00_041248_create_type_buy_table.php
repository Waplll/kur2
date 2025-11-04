<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('type_buy', function (Blueprint $table) {
            $table->id();
            $table->string('type_buy'); // Было type — стало type_buy для совместимости!
            $table->timestamps();
        });

        // Добавь значения "продажа" и "аренда"
        DB::table('type_buy')->insert([
            ['type_buy' => 'продажа'],
            ['type_buy' => 'аренда'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('type_buy');
    }
};
