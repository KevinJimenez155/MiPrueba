<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class TwCorporativo extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'S_NombreCorto', 'S_nombreCompleto', 'S_LogoURL', 'S_DBName', 'S_DBPassword', 'S_SystemUrl',
        'S_Activo', 'D_FechaIncorporacion', 'tw_usuarios_id'
    ];

    public function usuario(){
        return $this->belongsTo('App\TwUsuario');
    }

    public function documentos(): BelongsToMany{
        return $this->belongsToMany(TwDocumento::class, 'tw_documentos_corporativos', 'tw_corporativos_id', 'tw_documentos_id',)->withPivot('id','S_ArchivoUrl');
    }
    // public function documentos(){
    //     return $this->hasMany('App\TwDocumentosCorporativo');
    // }

    public function contactos(){
        return $this->hasMany('App\TwContactosCorporativo', 'tw_corporativos_id', 'id');
    }

    public function contratos(){
        return $this->hasMany('App\TwContratosCorporativo', 'tw_corporativos_id', 'id');
    }

    public function empresa(){
        return $this->belongsTo(TwEmpresasCorporativo::class, 'id', 'tw_corporativos_id');
    }


}
