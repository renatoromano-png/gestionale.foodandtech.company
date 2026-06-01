<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('clienti', function (Blueprint $table) {
            $table->string('pec', 120)->nullable()->after('email');
            $table->string('codice_sdi', 7)->nullable()->after('pec');
        });
    }

    public function down(): void
    {
        Schema::table('clienti', function (Blueprint $table) {
            $table->dropColumn(['pec', 'codice_sdi']);
        });
    }
};
