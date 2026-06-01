<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE scadenze MODIFY COLUMN stato ENUM('attiva','rinnovata','cancellata','disdetta') NOT NULL DEFAULT 'attiva'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE scadenze MODIFY COLUMN stato ENUM('attiva','rinnovata','disdetta') NOT NULL DEFAULT 'attiva'");
    }
};
