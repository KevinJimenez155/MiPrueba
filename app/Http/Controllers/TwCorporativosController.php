<?php

namespace App\Http\Controllers;

use App\TwCorporativo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TwCorporativosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $corporativos = TwCorporativo::all();
        return response([
            'message'=>'correcto',
            'corporativos'=> $corporativos
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
            'S_NombreCorto' => 'required|string|max:45|unique:tw_corporativos',
            'S_nombreCompleto' => 'required|string|max:75',
            'S_LogoURL' => 'required|file|mimes:jpeg,png',
            'S_DBName' => 'required|string|max:45',
            'S_DBPassword' => 'required|string|max:150',
            'S_SystemUrl' => 'required|string',
            'S_Activo' => 'required',
            'D_FechaIncorporacion' => 'required',
            'tw_usuarios_id' => 'required'
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        if ($request->hasFile('S_LogoURL')) {
            $url = $request->file('S_LogoURL')->store('public/logos');
        }
        $corporativo = TwCorporativo::create([
            'S_NombreCorto' => $request->S_NombreCorto,
            'S_nombreCompleto' => $request->S_nombreCompleto,
            'S_LogoURL' => $url,
            'S_DBName' => $request->S_DBName,
            'S_DBPassword' => $request->S_DBPassword,
            'S_SystemUrl' => $request->S_SystemUrl,
            'S_Activo' => $request->S_Activo,
            'D_FechaIncorporacion' => $request->D_FechaIncorporacion,
            'tw_usuarios_id' => $request->tw_usuarios_id,
        ]);
        return response([
            'message' => 'Se agrego correctamente',
            'corporativo'=> $corporativo
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
            return response(['Error'=>'No seleciono un corporativo'], 400);
        }
        $corporativo = TwCorporativo::find($id);
        if(!$corporativo){
            return response(['Error'=>'No existe el corporativo'], 404);
        }
        return response(['corporativo'=>$corporativo], 200);
    }

    // Esta pendiente Corregir
    public function corporativoData($id)
    {
        if($id == null){
            return response(['Error'=>'No seleciono un corporativo'], 400);
        }
        $corporativo = TwCorporativo::with(['empresa','contactos','contratos','documentos'])->where('id',$id)->get();
        if(!$corporativo){
            return response(['Error'=>'No existe el corporativo'], 404);
        }
        return response(['corporativo'=>$corporativo], 200);
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
        $corporativo = TwCorporativo::find($id);
        if(!$corporativo){
            return response(['Error'=>'No existe el corporativo'], 404);
        }
        $validator = Validator::make($request->all(), [
            'S_NombreCorto' => 'required|string|max:45|unique:tw_corporativos,S_NombreCorto,'. $id,
            'S_nombreCompleto' => 'required|string|max:75',
            'S_LogoURL' => 'file|mimes:jpeg,png',
            'S_DBName' => 'required|string|max:45',
            'S_DBPassword' => 'required|string|max:150',
            'S_SystemUrl' => 'required|string',
            'S_Activo' => 'required',
            'D_FechaIncorporacion' => 'required',
            'tw_usuarios_id' => 'required'
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $corporativo->update([
            'S_NombreCorto' => $request->S_NombreCorto,
            'S_nombreCompleto' => $request->S_nombreCompleto,
            'S_DBName' => $request->S_DBName,
            'S_DBPassword' => $request->S_DBPassword,
            'S_SystemUrl' => $request->S_SystemUrl,
            'S_Activo' => $request->S_Activo,
            'D_FechaIncorporacion' => $request->D_FechaIncorporacion,
            'tw_usuarios_id' => $request->tw_usuarios_id,
        ]);
        if ($request->hasFile('S_LogoURL')) {
            $url = $request->file('S_LogoURL')->store('public/logos');
            $corporativo->S_LogoURL = $url;
            $corporativo->save();
        }
        return response(['message' => 'Corporativo midficado correctamente','coporativo'=>$corporativo], 200);
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
            return response(['Error'=>'No seleciono un corporativo'], 400);
        }
        $corporativo = TwCorporativo::destroy($id);
        if(!$corporativo){
            return response(['Error'=>'No existe el corporativo'], 404);
        }
        return response(['message' => 'corporativo eliminado correctamente','corporativo'=>$corporativo], 200);
    }
}
