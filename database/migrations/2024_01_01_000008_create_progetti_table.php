<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('progetti', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clienti');
            $table->string('titolo');
            $table->text('descrizione')->nullable();
            $table->decimal('valore_totale', 10, 2)->default(0);
            $table->enum('stato', [
                'bozza',
                'offerta_inviata',
                'accettato',
                'in_corso',
                'completato',
                'annullato'
            ])->default('bozza');
            $table->date('data_offerta')->nullable();
            $table->date('data_accettazione')->nullable();
            $table->string('allegato_path')->nullable(); // path PDF offerta
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progetti');
    }
};
