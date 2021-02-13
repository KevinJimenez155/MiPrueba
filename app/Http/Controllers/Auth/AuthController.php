<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\TwUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function signUp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:45',
            'email' => 'required|string|email|max:255|unique:tw_usuarios',
            'password' => 'required|string|min:5|confirmed',
            'S_Nombre' => 'required|string|max:45',
            'S_Apellidos' => 'required|string|max:45',
            'S_FotoPerfilUrl' => 'required|string',
            'S_Activo' => 'required|string|max:45'
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $request['password']= bcrypt($request['password']);
        $user = TwUsuario::create($request->toArray());
        $response = ['message' => 'Registro exitoso'];
        return response($response, 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        $response = [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ];
        return response($response, 200);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
