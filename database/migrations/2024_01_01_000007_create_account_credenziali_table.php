<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('account_credenziali', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clienti')->cascadeOnDelete();
            $table->string('tipo'); // es. "cPanel", "FTP", "WordPress admin", "DNS"
            $table->string('url')->nullable();
            $table->string('username')->nullable();
            $table->text('password_enc')->nullable(); // AES-256 via Laravel Crypt
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('account_credenziali');
    }
};
