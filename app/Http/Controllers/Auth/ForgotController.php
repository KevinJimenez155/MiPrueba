<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotRequest;
use App\Http\Requests\ResetRequest;
use App\TwUsuario;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotController extends Controller
{
    public function forgot(ForgotRequest $request){
        $email = $request->input('email');

        if(TwUsuario::where('email', $email)->doesntExist()){
            return response(['message' => 'No existe el usuario'], 404);
        }
        $token = Str::random(10);
        try{
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token
            ]);
            Mail::send('Mails.forgot', ['token' => $token], function(Message $message) use ($email){
                $message->to($email);
                $message->subject('Recuperar Contraseña');
            });
            return response(['message' => 'Revisa tu correo'], 200);
        }catch(\Exception $e){
             return response(['message' => $e->getMessage()], 400);
        }
    }

    public function reset(ResetRequest $request){
        $token = $request->input('token');
        if(!$passwordReset = DB::table('password_resets')->where('token', $token)->first()){
            return response(['message' => 'token invalido'], 400);
        }
        /** @var TwUsuario $user */
        if(!$user = TwUsuario::where('email', $passwordReset->email)->first()){
            return response(['message' => 'Usuario no existe'], 404);
        }

        $user->password = bcrypt($request->input('password'));
        $user->save();

        return response(['message' => 'Se cambio la contraseña de manera correcta'], 200);
    }

}
