<?php

use App\TwCorporativo;
use Illuminate\Database\Seeder;

class TwCorporativoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(TwCorporativo::class, 10)->create();
    }
}
