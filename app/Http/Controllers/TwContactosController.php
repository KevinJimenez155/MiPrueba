<?php

namespace App\Http\Controllers;

use App\TwContactosCorporativo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TwContactosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contactos = TwContactosCorporativo::all();
        return response([
            'message'=>'correcto',
            'contactos'=> $contactos
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
            'S_Nombre' => 'required|string|max:45',
            'S_Puesto' => 'required|string|max:45',
            'S_Comentarios' => 'required|string|max:255',
            'N_TelefonoFijo' => 'required',
            'N_TelefonoMovil' => 'required',
            'S_Email' => 'required|string|email',
            'tw_corporativos_id' => 'required',
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $contacto = TwContactosCorporativo::create($request->toArray());
        return response([
            'message' => 'Se agrego correctamente',
            'conatco'=> $contacto
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
            return response(['Error'=>'No seleciono un contacto'], 400);
        }
        $contacto = TwContactosCorporativo::find($id);
        if(!$contacto){
            return response(['Error'=>'No existe el contacto'], 404);
        }
        return response(['contacto'=>$contacto], 200);
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
        $contacto = TwContactosCorporativo::find($id);
        if(!$contacto){
            return response(['Error'=>'No existe el contacto'], 404);
        }
        $validator = Validator::make($request->all(), [
            'S_Nombre' => 'required|string|max:45',
            'S_Puesto' => 'required|string|max:45',
            'S_Comentarios' => 'required|string|max:255',
            'N_TelefonoFijo' => 'required|int',
            'N_TelefonoMovil' => 'required|int',
            'S_Email' => 'required|string|email',
            'tw_corporativos_id' => 'required',
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $contacto->update([
            'S_Nombre' => $request->S_Nombre,
            'S_Puesto' => $request->S_Puesto,
            'S_Comentarios' => $request->S_Comentarios,
            'N_TelefonoFijo' => $request->N_TelefonoFijo,
            'N_TelefonoMovil' => $request->N_TelefonoMovil,
            'S_Email' => $request->S_Email,
            'tw_corporativos_id' => $request->tw_corporativos_id,
        ]);
        return response(['message' => 'contacto midficado correctamente','coporativo'=>$contacto], 200);
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
            return response(['Error'=>'No seleciono un contacto'], 400);
        }
        $contacto = TwContactosCorporativo::destroy($id);
        if(!$contacto){
            return response(['Error'=>'No existe el contacto'], 404);
        }
        return response(['message' => 'contacto eliminado correctamente','contacto'=>$contacto], 200);
    }
}
