<?php

namespace App\Http\Controllers;

use App\TwUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TwUsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = TwUsuario::all();
        return response([
            'message'=>'correcto',
            'usuarios'=> $users
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
            'username' => 'required|string|max:45|unique:tw_usuarios',
            'email' => 'required|string|email|max:255|unique:tw_usuarios',
            'password' => 'required|string|min:5|confirmed',
            'S_Nombre' => 'required|string|max:45',
            'S_Apellidos' => 'required|string|max:45',
            'S_FotoPerfilUrl' => 'required|file|mimes:jpeg,png',
            'S_Activo' => 'required'
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        if ($request->hasFile('S_FotoPerfilUrl')) {
            $url = $request->file('S_FotoPerfilUrl')->store('public/profilePhoto');
        }
        $request['password']= bcrypt($request['password']);
        $user = TwUsuario::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'S_Nombre' => $request->S_Nombre,
            'S_Apellidos' => $request->S_Apellidos,
            'S_FotoPerfilUrl' => $url,
            'S_Activo' => $request->S_Activo,
        ]);
        return response([
            'message' => 'Se agrego correctamente',
            'usuario'=> $user
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
            return response(['Error'=>'No seleciono un usuario'], 400);
        }
        $user = TwUsuario::find($id);
        if(!$user){
            return response(['Error'=>'No existe el usuario'], 404);
        }
        return response(['usuario'=>$user], 200);
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
        $user = TwUsuario::find($id);
        if(!$user){
            return response(['Error'=>'No existe el usuario'], 404);
        }
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:45|unique:tw_usuarios,username,'. $id,
            'email' => 'required|unique:tw_usuarios,email,'. $id,
            'password' => 'nullable',
            'S_Nombre' => 'required|string|max:45',
            'S_Apellidos' => 'required|string|max:45',
            'S_Activo' => 'required'
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'S_Nombre' => $request->S_Nombre,
            'S_Apellidos' => $request->S_Apellidos,
            'S_Activo' => $request->S_Activo,
        ]);
        if ($request->hasFile('S_FotoPerfilUrl')) {
            $url = $request->file('S_FotoPerfilUrl')->store('public/profilePhoto');
            $user->S_FotoPerfilUrl = $url;
            $user->save();
        }
        if($request->has('password')&&!empty($request->get('password'))){
            $user->password = bcrypt($request->get('password'));
            $user->save();
        }
        return response(['message' => 'usuario midficado correctamente','usuario'=>$user], 200);
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
            return response(['Error'=>'No seleciono un usuario'], 400);
        }
        $user = TwUsuario::destroy($id);
        if(!$user){
            return response(['Error'=>'No existe el usuario'], 404);
        }
        return response(['message' => 'usuario eliminado correctamente','usuario'=>$user], 200);
    }
}
