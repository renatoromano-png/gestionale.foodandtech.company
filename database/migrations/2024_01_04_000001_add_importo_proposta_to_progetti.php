<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('progetti', function (Blueprint $table) {
            $table->decimal('importo_proposta', 10, 2)->nullable()->after('valore_totale');
        });
    }

    public function down(): void
    {
        Schema::table('progetti', function (Blueprint $table) {
            $table->dropColumn('importo_proposta');
        });
    }
};
