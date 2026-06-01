<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('domini', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clienti')->cascadeOnDelete();
            $table->string('dominio');
            $table->boolean('solo_dns')->default(false);
            $table->date('data_registrazione')->nullable();
            $table->date('data_inizio_mantenimento')->nullable();
            $table->string('registrar')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique('dominio');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('domini');
    }
};
