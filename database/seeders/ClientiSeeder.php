<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientiSeeder extends Seeder
{
    public function run(): void
    {
        // Clienti unici estratti dal sistema esistente
        $clienti = [
            'A Day S.r.l.',
            'Absolute Ceramica Positano S.a.s.',
            'Al Mare S.r.l.s.',
            'Algoritmica LAB S.c.r.l.',
            'AQ Italy S.r.l.',
            'Beta Cavi S.r.l.',
            'Cantine Marisa Cuomo S.r.l.',
            'Castrovilli S.r.l.',
            'Centro Diagnostico Mandarino di Lucia Zampoli S.a.s.',
            'CoFren S.r.l.',
            'Consac IES - Infrastrutture energia servizi S.p.A',
            'Covit S.r.l.',
            'D\'Onofrio Domenico',
            'Dama S.r.l.',
            'Di Emme Elettronica S.a.s. di Adriano Aniello Mastrogiovanni',
            'Digitecno S.n.c.',
            'Elettroferroviaria S.r.l.',
            'Federpellami S.p.a.',
            'Ferraioli & C. S.r.l. (Officine Ferraioli)',
            'Fico d\'India Holidays S.a.s.',
            'Gamma Tributi S.r.l.',
            'Gruppo Agenti FATA Assicurazioni',
            'Hotel Belvedere S.r.l.',
            'Hotel Pensione Vittoria',
            'Il Centro S.r.l.',
            'Intelligent Information Technology S.r.l.',
            'Komiv S.r.l.',
            'L.F.G.M. Inox S.r.l.',
            'La Casa delle Stelle di Carmine Di Bianco',
            'La Marina de "Il Leone di Caprera" S.r.l.',
            'Locanda degli Agrumi di Milo Salvatore',
            'M. G. Car S.r.l.',
            'Marino Amerigo S.r.l.',
            'Multinet S.c.a.r.l.',
            'Officine Zephiro di Gabriele Cavaliere',
            'Osculati S.r.l.',
            'Prolab Studio Associato di Progettazione',
            'RCA Consulting S.r.l.',
            'Renato Romano',
            'Renato Santese',
            'Rinaldo S.r.l.',
            'Sacar Forni S.r.l.',
            'Sainvest S.r.l.',
            'Service Infoweb di Enzo Cavallaro',
            'Smet S.r.l.',
            'Trono Consulting S.r.l.',
            'Unique Experience di Nicola Asprella',
            'Vittorio Caponigro',
            // Clienti aggiuntivi emersi dalla migrazione scadenze
            'Ferdinando Damiano',
            'Marisa Cuomo Azienda Agricola S.r.l.',
            'Metalstyle S.r.l.',
            'Pica Ciamarra Associati - PCA int S.r.l.',
        ];

        foreach ($clienti as $ragione) {
            DB::table('clienti')->insertOrIgnore([
                'ragione_sociale' => $ragione,
                'attivo'          => true,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }
}
