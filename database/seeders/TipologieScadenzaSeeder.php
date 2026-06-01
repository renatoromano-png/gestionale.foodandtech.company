<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipologieScadenzaSeeder extends Seeder
{
    public function run(): void
    {
        $tipologie = [
            ['nome' => 'Generatepress Premium',                          'periodicita' => 'annuale',  'colore' => '#fd7e14'],
            ['nome' => 'Hosting',                                        'periodicita' => 'annuale',  'colore' => '#0d6efd'],
            ['nome' => 'Hosting windows 20Gbyte',                        'periodicita' => 'annuale',  'colore' => '#0d6efd'],
            ['nome' => 'Hosting Windows 5Gbyte',                         'periodicita' => 'annuale',  'colore' => '#0d6efd'],
            ['nome' => 'Licenza Elementor PRO',                          'periodicita' => 'annuale',  'colore' => '#6f42c1'],
            ['nome' => 'Licenza Eventin PRO',                            'periodicita' => 'annuale',  'colore' => '#6f42c1'],
            ['nome' => 'Licenza Evently theme',                          'periodicita' => 'annuale',  'colore' => '#6f42c1'],
            ['nome' => 'Licenza Flexible Checkout Fields PRO',           'periodicita' => 'annuale',  'colore' => '#6f42c1'],
            ['nome' => 'Licenza Rank Math PRO',                          'periodicita' => 'annuale',  'colore' => '#6f42c1'],
            ['nome' => 'Licenza Slider Revolution',                      'periodicita' => 'annuale',  'colore' => '#6f42c1'],
            ['nome' => 'Licenza Woocommerce - Catalog Visibility Options','periodicita' => 'annuale',  'colore' => '#6f42c1'],
            ['nome' => 'Licenza WP Bakery builder',                      'periodicita' => 'annuale',  'colore' => '#6f42c1'],
            ['nome' => 'Licenza WPForms Pro',                            'periodicita' => 'annuale',  'colore' => '#6f42c1'],
            ['nome' => 'Licenza WPML',                                   'periodicita' => 'annuale',  'colore' => '#6f42c1'],
            ['nome' => 'PEC',                                            'periodicita' => 'annuale',  'colore' => '#198754'],
            ['nome' => 'PEC bronze',                                     'periodicita' => 'annuale',  'colore' => '#198754'],
            ['nome' => 'PEC bronze + 1GB',                              'periodicita' => 'annuale',  'colore' => '#198754'],
            ['nome' => 'PEC Bronze + 2GB',                              'periodicita' => 'annuale',  'colore' => '#198754'],
            ['nome' => 'PEC Bronze + 3GB',                              'periodicita' => 'annuale',  'colore' => '#198754'],
            ['nome' => 'PEC Bronze + 4GB',                              'periodicita' => 'annuale',  'colore' => '#198754'],
            ['nome' => 'PEC Bronze + 6GB',                              'periodicita' => 'annuale',  'colore' => '#198754'],
            ['nome' => 'PEC dominio',                                    'periodicita' => 'annuale',  'colore' => '#198754'],
            ['nome' => 'PEC Silver',                                     'periodicita' => 'annuale',  'colore' => '#198754'],
            ['nome' => 'SMTP Personal',                                  'periodicita' => 'annuale',  'colore' => '#20c997'],
            ['nome' => 'SMTP Professional',                              'periodicita' => 'annuale',  'colore' => '#20c997'],
            ['nome' => 'VPS',                                            'periodicita' => 'annuale',  'colore' => '#dc3545'],
        ];

        foreach ($tipologie as $t) {
            DB::table('tipologie_scadenza')->insertOrIgnore([
                'nome'        => $t['nome'],
                'periodicita' => $t['periodicita'],
                'colore'      => $t['colore'],
                'attivo'      => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
