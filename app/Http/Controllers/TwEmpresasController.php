<?php

namespace App\Http\Controllers;

use App\TwEmpresasCorporativo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TwEmpresasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresas = TwEmpresasCorporativo::all();
        return response([
            'message'=>'correcto',
            'empresas'=> $empresas
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
            'S_RazonSocial' => 'required|string|max:150',
            'S_RFC' => 'required|string|max:13',
            'S_Pais' => 'required|string|max:75',
            'S_Estado' => 'required|string|max:75',
            'S_Municipio' => 'required|string|max:75',
            'S_ColoniaLocalidad' => 'required|string|max:75',
            'S_Domicilio' => 'required|string|max:100',
            'S_CodigoPostal' => 'required|string|max:5',
            'S_UsoCFDI' => 'required',
            'S_UrlRFC' => 'required|file|mimes:pdf,docx,doc',
            'S_UrlActaConstitutiva' => 'required|file|mimes:pdf,docx,doc',
            'S_Activo' => 'required',
            'S_Comentarios' => 'required|string|max:255',
            'tw_corporativos_id' => 'required'
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        if ($request->hasFile('S_UrlRFC') && $request->hasFile('S_UrlActaConstitutiva')) {
            $urlRfc = $request->file('S_UrlRFC')->store('public/empresas');
            $urlActa = $request->file('S_UrlActaConstitutiva')->store('public/empresas');
        }
       $empresa = TwEmpresasCorporativo::create([
        'S_RazonSocial' => $request->S_RazonSocial ,
        'S_RFC' => $request->S_RFC,
        'S_Pais' => $request->S_Pais,
        'S_Estado' => $request->S_Estado,
        'S_Municipio' => $request->S_Municipio,
        'S_ColoniaLocalidad' => $request->S_ColoniaLocalidad,
        'S_Domicilio' => $request->S_Domicilio,
        'S_CodigoPostal' => $request->S_CodigoPostal,
        'S_UsoCFDI' => $request->S_UsoCFDI,
        'S_UrlRFC' => $urlRfc,
        'S_UrlActaConstitutiva' => $urlActa,
        'S_Activo' => $request->S_Activo,
        'S_Comentarios' => $request->S_Comentarios,
        'tw_corporativos_id' => $request->tw_corporativos_id,
       ]);
        return response([
            'message' => 'Se agrego correctamente',
            'empresa'=>$empresa
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
            return response(['Error'=>'No seleciono una empresa'], 400);
        }
        $empresa = TwEmpresasCorporativo::find($id);
        if(!$empresa){
            return response(['Error'=>'No existe la empresa'], 404);
        }
        return response(['empresa'=>$empresa], 200);
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
        $empresa = TwEmpresasCorporativo::find($id);
        if(!$empresa){
            return response(['Error'=>'No existe la empresa'], 404);
        }
        $validator = Validator::make($request->all(), [
            'S_RazonSocial' => 'required|string|max:150',
            'S_RFC' => 'required|string|max:13',
            'S_Pais' => 'required|string|max:75',
            'S_Estado' => 'required|string|max:75',
            'S_Municipio' => 'required|string|max:75',
            'S_ColoniaLocalidad' => 'required|string|max:75',
            'S_Domicilio' => 'required|string|max:100',
            'S_CodigoPostal' => 'required|string|max:5',
            'S_UsoCFDI' => 'required|string|max:45',
            'S_UrlRFC' => 'file|mimes:pdf,docx,doc',
            'S_UrlActaConstitutiva' => 'file|mimes:pdf,docx,doc',
            'S_Activo' => 'required',
            'S_Comentarios' => 'required|string|max:255',
            'tw_corporativos_id' => 'required'
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $empresa->update([
            'S_RazonSocial' => $request->S_RazonSocial,
            'S_RFC' => $request->S_RFC,
            'S_Pais' => $request->S_Pais,
            'S_Estado' => $request->S_Estado,
            'S_Municipio' => $request->S_Municipio,
            'S_ColoniaLocalidad' => $request->S_ColoniaLocalidad,
            'S_Domicilio' => $request->S_Domicilio,
            'S_CodigoPostal' => $request->S_CodigoPostal,
            'S_UsoCFDI' => $request->S_UsoCFDI,
            'S_Activo' => $request->S_Activo,
            'S_Comentarios' => $request->S_Comentarios,
            'tw_corporativos_id' => $request->tw_corporativos_id,
        ]);
        if ($request->hasFile('S_UrlRFC')) {
            $urlRfc = $request->file('S_UrlRFC')->store('public/empresas');
            $empresa->S_UrlRFC = $urlRfc;
            $empresa->save();
        }
        if($request->hasFile('S_UrlActaConstitutiva')){
            $urlActa = $request->file('S_UrlActaConstitutiva')->store('public/empresas');
            $empresa->S_UrlActaConstitutiva = $urlActa;
            $empresa->save();
        }

        return response(['message' => 'Corporativo midficado correctamente','coporativo'=>$empresa], 200);
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
            return response(['Error'=>'No seleciono una empresa'], 400);
        }
        $empresa = TwEmpresasCorporativo::destroy($id);
        if(!$empresa){
            return response(['Error'=>'No existe la empresa'], 404);
        }
        return response(['message' => 'empresa eliminada correctamente','empresa'=>$empresa], 200);
    }
}
