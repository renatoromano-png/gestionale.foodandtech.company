<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rate_pagamento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('progetto_id')->constrained('progetti')->cascadeOnDelete();
            $table->unsignedTinyInteger('numero_rata'); // 1, 2, 3...
            $table->decimal('percentuale', 5, 2); // es. 30.00, 30.00, 40.00
            $table->decimal('importo', 10, 2);    // calcolato: valore_totale * percentuale / 100
            $table->date('data_prevista')->nullable();
            $table->date('data_incasso')->nullable();
            $table->enum('stato', ['attesa', 'incassata', 'in_ritardo'])->default('attesa');
            $table->string('descrizione')->nullable(); // es. "Acconto", "SAL 1", "Saldo"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rate_pagamento');
    }
};
