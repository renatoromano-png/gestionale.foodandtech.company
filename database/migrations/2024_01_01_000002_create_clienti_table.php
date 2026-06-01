<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clienti', function (Blueprint $table) {
            $table->id();
            $table->string('codice', 20)->nullable()->unique();
            $table->string('ragione_sociale');
            $table->string('indirizzo')->nullable();
            $table->string('cap', 10)->nullable();
            $table->string('citta')->nullable();
            $table->string('provincia', 5)->nullable();
            $table->string('email')->nullable();
            $table->string('telefono')->nullable();
            $table->boolean('attivo')->default(true);
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clienti');
    }
};
