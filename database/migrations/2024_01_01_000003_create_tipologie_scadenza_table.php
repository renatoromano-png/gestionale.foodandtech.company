<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tipologie_scadenza', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('descrizione')->nullable();
            $table->string('colore', 7)->default('#6c757d'); // hex color per UI
            $table->decimal('prezzo_default', 10, 2)->nullable();
            $table->enum('periodicita', ['mensile', 'trimestrale', 'semestrale', 'annuale', 'biennale', 'una_tantum'])->default('annuale');
            $table->boolean('attivo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipologie_scadenza');
    }
};
