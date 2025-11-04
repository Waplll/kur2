<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('second_name')->nullable(); // необязательно, но оставлю (если используется)
            $table->string('surname')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();

            // ВАЖНО: для авторизации Laravel, нужен ОДНО столбец password
            $table->string('password');

            // Остальные связи делай nullable, если нужны (но стандартная auth ими не пользуется!)
            $table->foreignId('role_id')->nullable()->constrained('role')->onDelete('cascade');
            $table->foreignId('avatar_id')->nullable()->constrained('avatar')->onDelete('cascade');
            $table->foreignId('reviews_id')->nullable()->constrained('reviews')->onDelete('cascade');

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
