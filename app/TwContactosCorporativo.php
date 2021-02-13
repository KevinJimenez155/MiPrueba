<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwContactosCorporativo extends Model
{
    protected $fillable = [
        'S_Nombre', 'S_Puesto', 'S_Comentarios', 'N_TelefonoFijo', 'N_TelefonoMovil', 'S_Email',
        'tw_corporativos_id',
    ];

    public function corporativo(){
        return $this->belongsTo('App\TwCorporativo', 'tw_corporativos_id', 'id');
    }
}
