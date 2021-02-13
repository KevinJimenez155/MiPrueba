<?php

use App\TwUsuario;
use Illuminate\Database\Seeder;

class TwUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(TwUsuario::class, 10)->create();
    }
}
