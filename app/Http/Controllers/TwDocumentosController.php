<?php

namespace App\Http\Controllers;

use App\TwDocumento;
use App\TwDocumentosCorporativo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TwDocumentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contratos = TwDocumento::with('corporativos')->get();
        return response([
            'message'=>'correcto',
            'contratos'=> $contratos
            ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'S_Nombre' => 'required',
            'N_Obligatorio' => 'required',
            'S_Descripcion' => 'required',
            'tw_corporativos_id' => 'required',
            'S_ArchivoUrl' => 'required|file|mimes:pdf,docx,doc'
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        try{
            if($request->hasFile('S_ArchivoUrl')){
                $url = $request->file('S_ArchivoUrl')->store('public/documentos');
            }
            $documento = TwDocumento::create([
                'S_Nombre' => $request->S_Nombre,
                'N_Obligatorio' => $request->N_Obligatorio,
                'S_Descripcion' => $request->S_Descripcion,
            ]);
             $documentoCorporativo =TwDocumentosCorporativo::create([
            'tw_corporativos_id' => $request->tw_corporativos_id,
            'tw_documentos_id'=> $documento->id,
            'S_ArchivoUrl' => $url
        ]);
        return response([
            'message' => 'Se agrego correctamente',
            'documento'=> $documento,
        ], 200);
        }catch(\Exception $e){
            return response(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($id == null){
            return response(['Error'=>'No seleciono un docuemnto'], 400);
        }
        $documento = TwDocumento::with('corporativos')->find($id);
        if(!$documento){
            return response(['Error'=>'No existe el docuemnto'], 404);
        }
        return response(['doceumento'=>$documento], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $documento = TwDocumento::with('corporativos')->find($id);
        if(!$documento){
            return response(['Error'=>'No existe el documento'], 404);
        }
        $validator = Validator::make($request->all(), [
            'S_Nombre' => 'required',
            'N_Obligatorio' => 'required',
            'S_Descripcion' => 'required',
            'tw_corporativos_id' => 'required',
            'S_ArchivoUrl' => 'file|mimes:pdf,docx,doc'
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $documento->update([
            'S_Nombre' => $request->S_Nombre,
            'N_Obligatorio' => $request->N_Obligatorio,
            'S_Descripcion' => $request->S_Descripcion,
            'tw_corporativos_id' => $request->tw_corporativos_id,
        ]);
        $corporativoDocumento =TwDocumentosCorporativo::find($documento->corporativos[0]->pivot->id);
        $corporativoDocumento->update([
            'tw_corporativos_id' => $request->tw_corporativos_id,
        ]);
        if($request->hasFile('S_ArchivoUrl')){
            $url = $request->file('S_ArchivoUrl')->store('public/documentos');
            $corporativoDocumento->S_ArchivoUrl = $url;
            $corporativoDocumento->save();
        }
        return response(['message' => 'documento midficado correctamente','documento'=>$documento], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id == null){
            return response(['Error'=>'No seleciono un documento'], 400);
        }
        $documento = TwDocumento::destroy($id);
        if(!$documento){
            return response(['Error'=>'No existe el documento'], 404);
        }
        return response(['message' => 'documento eliminado correctamente','documento'=>$documento], 200);
    }
}
