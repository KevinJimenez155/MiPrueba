<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TwDocumento extends Model
{
    protected $fillable = [
        'S_Nombre', 'N_Obligatorio', 'S_Descripcion'
    ];

    public function corporativos(): BelongsToMany{
        return $this->belongsToMany(TwCorporativo::class,'tw_documentos_corporativos', 'tw_documentos_id', 'tw_corporativos_id')->withPivot('id','S_ArchivoUrl');
    }

}
