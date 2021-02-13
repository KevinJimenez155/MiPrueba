<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwDocumentosCorporativo extends Model
{
    protected $fillable = [
        'tw_corporativos_id', 'tw_documentos_id', 'S_ArchivoUrl'
    ];
}
