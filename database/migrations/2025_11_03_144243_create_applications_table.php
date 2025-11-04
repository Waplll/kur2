<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('address');
            $table->unsignedInteger('count_rooms');
            $table->unsignedBigInteger('price');
            $table->string('path_image')->nullable();
            $table->foreignId('type_buy_id')->constrained('type_buy')->onDelete('cascade');
            $table->foreignId('status_id')->constrained('status')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
