<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('domini', function (Blueprint $table) {
            $table->date('data_scadenza')->nullable()->after('data_inizio_mantenimento');
            $table->decimal('prezzo', 10, 2)->nullable()->after('data_scadenza');
        });
    }

    public function down(): void
    {
        Schema::table('domini', function (Blueprint $table) {
            $table->dropColumn(['data_scadenza', 'prezzo']);
        });
    }
};
