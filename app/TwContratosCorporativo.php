<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwContratosCorporativo extends Model
{
    protected $fillable = [
        'D_FechaInicio', 'D_FechaFin', 'S_URLContrato', 'tw_corporativos_id'
    ];
    public function corporativo(){
        return $this->belongsTo('App\TwCorporativo', 'tw_corporativos_id', 'id');
    }
}
