<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Articoli = istanza di un servizio per un cliente specifico
        // IL PREZZO VIVE QUI, non sulla tipologia né sulla scadenza
        Schema::create('articoli', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clienti')->cascadeOnDelete();
            $table->foreignId('tipologia_id')->constrained('tipologie_scadenza');
            $table->string('descrizione')->nullable(); // es. "Hosting Piano Pro - dominio xyz.it"
            $table->decimal('prezzo', 10, 2); // prezzo cliente-specifico
            $table->boolean('attivo')->default(true);
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articoli');
    }
};
