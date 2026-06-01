<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DominiSeeder extends Seeder
{
    public function run(): void
    {
        // Mappa ragione_sociale -> id cliente (risolto a runtime)
        $clienteId = function(string $nome): int {
            return DB::table('clienti')->where('ragione_sociale', $nome)->value('id') ?? 0;
        };

        $csv = base_path('../domini_attivi.csv'); // legge il CSV dalla cartella di progetto
        if (!file_exists($csv)) {
            $this->command->warn("File domini_attivi.csv non trovato, skip.");
            return;
        }

        $handle = fopen($csv, 'r');
        fgetcsv($handle); // salta header
        while (($row = fgetcsv($handle)) !== false) {
            [$id, $dominio, $cliente, $solo_dns, $data_reg, $data_man] = $row;
            $cid = $clienteId($cliente);
            if (!$cid) continue;

            DB::table('domini')->insertOrIgnore([
                'cliente_id'               => $cid,
                'dominio'                  => $dominio,
                'solo_dns'                 => (bool)(int)$solo_dns,
                'data_registrazione'       => $data_reg ?: null,
                'data_inizio_mantenimento' => $data_man ?: null,
                'created_at'               => now(),
                'updated_at'               => now(),
            ]);
        }
        fclose($handle);
    }
}
