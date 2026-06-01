<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('step_progetto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('progetto_id')->constrained('progetti')->cascadeOnDelete();
            $table->foreignId('rata_id')->nullable()->constrained('rate_pagamento')->nullOnDelete();
            $table->string('titolo');
            $table->text('descrizione')->nullable();
            $table->unsignedTinyInteger('ordine')->default(0);
            $table->enum('stato', ['da_fare', 'in_corso', 'completato'])->default('da_fare');
            $table->date('data_prevista')->nullable();
            $table->date('data_completamento')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('step_progetto');
    }
};
