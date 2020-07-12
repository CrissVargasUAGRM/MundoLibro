<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    //aqui podemos crear funciones para ayudarnos en los tests

    //encontramos el usuario:
    function defaultUser(){
        return User::find(1);
    }

    //creamos los headers para obtener el token del usuario y ver si esta autentificado
    function headers(){
        $token = JWTAuth::fromUser($this->defaultUser());
        JWTAuth::setToken($token);

        $headers['Authorization'] = "Bearer $token";

        return $headers;
    }
}
