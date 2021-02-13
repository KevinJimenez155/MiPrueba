<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('login', 'Auth\AuthController@login');
    Route::post('signup', 'Auth\AuthController@signUp');
    Route::post('forgot', 'Auth\ForgotController@forgot');
    Route::post('reset', 'Auth\ForgotController@reset');
});

Route::middleware('auth:api')->group(function () {
    Route::get('logout', 'Auth\AuthController@logout');

    Route::prefix('user')->group(function () {
        Route::get('all', 'TwUsuariosController@index');
        Route::post('create', 'TwUsuariosController@store');
        Route::get('{id}', 'TwUsuariosController@show');
        Route::post('update/{id}', 'TwUsuariosController@update');
        Route::delete('delete/{id}', 'TwUsuariosController@destroy');
    });

    Route::prefix('corporativo')->group(function () {
        Route::get('all', 'TwCorporativosController@index');
        Route::post('create', 'TwCorporativosController@store');
        Route::get('{id}', 'TwCorporativosController@show');
        Route::get('data/{id}', 'TwCorporativosController@corporativoData');
        Route::post('update/{id}', 'TwCorporativosController@update');
        Route::delete('delete/{id}', 'TwCorporativosController@destroy');

        Route::prefix('empresa')->group(function () {
            Route::get('all', 'TwEmpresasController@index');
            Route::post('create', 'TwEmpresasController@store');
            Route::get('{id}', 'TwEmpresasController@show');
            Route::post('update/{id}', 'TwEmpresasController@update');
            Route::delete('delete/{id}', 'TwEmpresasController@destroy');
        });

        Route::prefix('contacto')->group(function () {
            Route::get('all', 'TwContactosController@index');
            Route::post('create', 'TwContactosController@store');
            Route::get('{id}', 'TwContactosController@show');
            Route::post('update/{id}', 'TwContactosController@update');
            Route::delete('delete/{id}', 'TwContactosController@destroy');
        });

        Route::prefix('contrato')->group(function () {
            Route::get('all', 'TwContratosController@index');
            Route::post('create', 'TwContratosController@store');
            Route::get('{id}', 'TwContratosController@show');
            Route::post('update/{id}', 'TwContratosController@update');
            Route::delete('delete/{id}', 'TwContratosController@destroy');
        });

        Route::prefix('documento')->group(function () {
            Route::get('all', 'TwDocumentosController@index');
            Route::post('create', 'TwDocumentosController@store');
            Route::get('{id}', 'TwDocumentosController@show');
            Route::post('update/{id}', 'TwDocumentosController@update');
            Route::delete('delete/{id}', 'TwDocumentosController@destroy');
        });
    });

});
