<?php

namespace App\Http\Controllers;

use App\TwContratosCorporativo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TwContratosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contratos = TwContratosCorporativo::all();
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
            'D_FechaInicio' => 'required',
            'D_FechaFin' => 'required',
            'S_URLContrato' => 'required|file|mimes:pdf,docx,doc',
            'tw_corporativos_id' => 'required',
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        if ($request->hasFile('S_URLContrato')) {
            $url = $request->file('S_URLContrato')->store('public/contratos');
        }
        $contrato = TwContratosCorporativo::create([
            'D_FechaInicio' => $request->D_FechaInicio,
            'D_FechaFin' => $request->D_FechaFin,
            'S_URLContrato'=> $url,
            'tw_corporativos_id' => $request->tw_corporativos_id,
            ]);
        return response([
            'message' => 'Se agrego correctamente',
            'contrato'=> $contrato
        ], 200);
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
            return response(['Error'=>'No seleciono un contrato'], 400);
        }
        $contrato = TwContratosCorporativo::find($id);
        if(!$contrato){
            return response(['Error'=>'No existe el contrato'], 404);
        }
        return response(['contrato'=>$contrato], 200);
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
        $contrato = TwContratosCorporativo::find($id);
        if(!$contrato){
            return response(['Error'=>'No existe el contrato'], 404);
        }
        $validator = Validator::make($request->all(), [
            'D_FechaInicio' => 'required',
            'D_FechaFin' => 'required',
            'S_URLContrato' => 'file|mimes:pdf,docx,doc',
            'tw_corporativos_id' => 'required',
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $contrato->update([
            'D_FechaInicio' => $request->D_FechaInicio,
            'D_FechaFin' => $request->D_FechaFin,
            'tw_corporativos_id' => $request->tw_corporativos_id,
        ]);
        if ($request->hasFile('S_URLContrato')) {
            $url = $request->file('S_URLContrato')->store('public/contratos');
            $contrato->S_URLContrato = $url;
            $contrato->save();
        }
        return response(['message' => 'contrato midficado correctamente','contrato'=>$contrato], 200);
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
            return response(['Error'=>'No seleciono un contrato'], 400);
        }
        $contrato = TwContratosCorporativo::destroy($id);
        if(!$contrato){
            return response(['Error'=>'No existe el contrato'], 404);
        }
        return response(['message' => 'contrato eliminado correctamente','contrato'=>$contrato], 200);
    }
}
