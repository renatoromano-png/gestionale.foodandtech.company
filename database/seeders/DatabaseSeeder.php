<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TipologieScadenzaSeeder::class,
            ClientiSeeder::class,
            DominiSeeder::class,
            AccountCredenzialiSeeder::class,
            ScadenzeSeeder::class,
        ]);
    }
}
