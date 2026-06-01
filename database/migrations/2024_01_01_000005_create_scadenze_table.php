<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Scadenze = date di rinnovo di un articolo (una per periodo)
        Schema::create('scadenze', function (Blueprint $table) {
            $table->id();
            $table->foreignId('articolo_id')->constrained('articoli')->cascadeOnDelete();
            $table->date('data_scadenza');
            $table->enum('stato', ['attiva', 'rinnovata', 'disdetta'])->default('attiva');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index('data_scadenza'); // per query scadenzario
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scadenze');
    }
};
