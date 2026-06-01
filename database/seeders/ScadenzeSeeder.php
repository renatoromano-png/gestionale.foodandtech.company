<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScadenzeSeeder extends Seeder
{
    public function run(): void
    {
        $clienteId = fn(string $n) => DB::table('clienti')->where('ragione_sociale', $n)->value('id') ?? 0;
        $tipologiaId = fn(string $n) => DB::table('tipologie_scadenza')->where('nome', $n)->value('id') ?? null;

        // [cliente, tipologia, descrizione, data_scadenza, periodicita]
        $items = [
            ['Service Infoweb di Enzo Cavallaro', 'PEC', 'antonellaromano@peclegal.it', '2026-05-23', 'annuale'],
            ['Service Infoweb di Enzo Cavallaro', 'PEC', 'bea@peclegal.it', '2026-11-23', 'annuale'],
            ['Il Centro S.r.l.', 'PEC', 'centro@irispec.it', '2026-11-18', 'annuale'],
            ['Il Centro S.r.l.', 'PEC', 'centrosnc@irispec.it', '2026-11-18', 'annuale'],
            ['Beta Cavi S.r.l.', 'PEC dominio', 'cert.betacavi.com', '2027-03-15', 'annuale'],
            ['Digitecno S.n.c.', 'PEC dominio', 'cert.comune.fanoadriano.te.it', '2027-03-19', 'annuale'],
            ['Consac IES - Infrastrutture energia servizi S.p.A', 'PEC dominio', 'cert.consacinfrastrutture.it', '2026-07-15', 'annuale'],
            ['D\'Onofrio Domenico', 'PEC dominio', 'cert.studiocantoniluca.it', '2026-09-30', 'annuale'],
            ['Renato Romano', 'PEC', 'comunicazioni@irispec.it', '2026-05-12', 'annuale'],
            ['Il Centro S.r.l.', 'PEC', 'ctld@irispec.it', '2026-09-16', 'annuale'],
            ['D\'Onofrio Domenico', 'PEC', 'dadomatica@irispec.it', '2027-05-03', 'annuale'],
            ['Service Infoweb di Enzo Cavallaro', 'PEC Bronze + 6GB', 'dallair@peclegal.it', '2027-01-11', 'annuale'],
            ['Service Infoweb di Enzo Cavallaro', 'PEC', 'dmcutensili@peclegal.it', '2026-05-27', 'annuale'],
            ['Service Infoweb di Enzo Cavallaro', 'PEC', 'dmigrandimacchine@peclegal.it', '2026-10-26', 'annuale'],
            ['Service Infoweb di Enzo Cavallaro', 'PEC', 'edil.costruzioni@peclegal.it', '2026-05-23', 'annuale'],
            ['Service Infoweb di Enzo Cavallaro', 'PEC', 'fabiomacciocca@peclegal.it', '2026-06-12', 'annuale'],
            ['Service Infoweb di Enzo Cavallaro', 'PEC', 'fashionflairgroupsrl@peclegal.it', '2026-07-15', 'annuale'],
            ['Digitecno S.n.c.', 'PEC bronze', 'fatturapa@cert.comune.fanoadriano.te.it', '2027-03-10', 'annuale'],
            ['Ferdinando Damiano', 'PEC bronze', 'ferdinandodamiano@irispec.it', '2026-09-09', 'annuale'],
            ['Smet S.r.l.', 'Hosting', 'gestionale.smet.it', '2026-10-16', 'annuale'],
            ['Service Infoweb di Enzo Cavallaro', 'PEC', 'gmeuro@peclegal.it', '2027-03-29', 'annuale'],
            ['Osculati S.r.l.', 'Hosting', 'Hosting 100G', '2026-09-01', 'annuale'],
            ['Algoritmica LAB S.c.r.l.', 'Hosting', 'Hosting wholesale', '2027-01-01', 'annuale'],
            ['Service Infoweb di Enzo Cavallaro', 'Hosting', 'Hosting wholesale', '2026-07-01', 'trimestrale'],
            ['Multinet S.c.a.r.l.', 'Hosting', 'Hosting wholesale', '2027-01-01', 'annuale'],
            ['Il Centro S.r.l.', 'PEC', 'ilcentro@irispec.it', '2026-09-14', 'annuale'],
            ['Beta Cavi S.r.l.', 'PEC Silver', 'info@cert.betacavi.com', '2027-03-15', 'annuale'],
            ['Consac IES - Infrastrutture energia servizi S.p.A', 'PEC bronze', 'info@cert.consacinfrastrutture.it', '2026-07-15', 'annuale'],
            ['D\'Onofrio Domenico', 'PEC', 'info@cert.studiocantoniluca.it', '2026-09-29', 'annuale'],
            ['Renato Romano', 'PEC dominio', 'irispec.it', '2026-05-12', 'annuale'],
            ['Service Infoweb di Enzo Cavallaro', 'PEC', 'laroccasas@peclegal.it', '2026-11-15', 'annuale'],
            ['L.F.G.M. Inox S.r.l.', 'PEC', 'leonelliacciai@irispec.it', '2027-01-28', 'annuale'],
            ['Cantine Marisa Cuomo S.r.l.', 'PEC', 'marisacuomo@irispec.it', '2026-10-21', 'annuale'],
            ['Marisa Cuomo Azienda Agricola S.r.l.', 'PEC', 'marisacuomosa@irispec.it', '2026-08-04', 'annuale'],
            ['Metalstyle S.r.l.', 'Hosting', 'metalstyle.com', '2027-03-01', 'annuale'],
            ['Algoritmica LAB S.c.r.l.', 'SMTP Professional', 'ml.marigoitalia.com', '2026-06-01', 'mensile'],
            ['Rinaldo S.r.l.', 'SMTP Personal', 'ml.rinaldo.it', '2026-06-01', 'mensile'],
            ['Unique Experience di Nicola Asprella', 'SMTP Personal', 'ml.uniqueexperience.it', '2026-06-01', 'mensile'],
            ['Multinet S.c.a.r.l.', 'PEC Silver', 'multinet@irispec.it', '2026-06-27', 'annuale'],
            ['Beta Cavi S.r.l.', 'Licenza Elementor PRO', 'newsletter.betacavi.com', '2026-05-29', 'annuale'],
            ['Beta Cavi S.r.l.', 'Licenza WPForms Pro', 'newsletter.betacavi.com', '2026-05-29', 'annuale'],
            ['Service Infoweb di Enzo Cavallaro', 'PEC bronze', 'operaacr@peclegal.it', '2026-06-04', 'annuale'],
            ['Digitecno S.n.c.', 'PEC', 'paesaniliquori@irispec.it', '2026-11-11', 'annuale'],
            ['D\'Onofrio Domenico', 'PEC', 'pasticceriacarioni@irispec.it', '2026-07-03', 'annuale'],
            ['Pica Ciamarra Associati - PCA int S.r.l.', 'PEC', 'pca@pec.pcaint.eu', '2026-12-31', 'annuale'],
            ['Pica Ciamarra Associati - PCA int S.r.l.', 'PEC dominio', 'PEC di Aruba', '2026-12-31', 'annuale'],
            ['Pica Ciamarra Associati - PCA int S.r.l.', 'PEC', 'PEC di Aruba', '2026-12-31', 'annuale'],
            ['Pica Ciamarra Associati - PCA int S.r.l.', 'PEC dominio', 'pec.pcaint.eu', '2026-12-24', 'annuale'],
            ['Service Infoweb di Enzo Cavallaro', 'PEC dominio', 'peclegal.it', '2026-05-12', 'annuale'],
            ['Service Infoweb di Enzo Cavallaro', 'PEC', 'pivotsrl@peclegal.it', '2026-07-29', 'annuale'],
            ['A Day S.r.l.', 'VPS', 'Server win2016', '2026-07-01', 'trimestrale'],
            ['Gamma Tributi S.r.l.', 'VPS', 'VPS dedicato', '2026-07-01', 'trimestrale'],
        ];

        foreach ($items as [$ragione, $tipNome, $desc, $scadenza, $period]) {
            $cid = $clienteId($ragione);
            $tid = $tipologiaId($tipNome);
            if (!$cid) continue;

            $artId = DB::table('articoli')->insertGetId([
                'cliente_id'   => $cid,
                'tipologia_id' => $tid,
                'descrizione'  => $desc,
                'prezzo'       => 0.00,
                'attivo'       => true,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            DB::table('scadenze')->insert([
                'articolo_id'   => $artId,
                'data_scadenza' => $scadenza,
                'stato'         => 'attiva',
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}