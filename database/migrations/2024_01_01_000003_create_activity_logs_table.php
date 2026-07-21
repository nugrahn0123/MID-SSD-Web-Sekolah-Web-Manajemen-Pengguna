<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->string('action', 100)->comment('Kode aksi: login, logout, create_user, dll.');
            $table->text('description')->nullable()->comment('Detail aktivitas');
            $table->string('ip_address', 45)->nullable()->comment('IPv4/IPv6');
            // Hanya created_at, tidak ada updated_at karena log tidak diubah
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
