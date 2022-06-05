<?php

use \App\Http\Response;
use \App\Controller\Api;

//Para reenviar token ou esqueci minha senha
$objRouter->post('/api/v1/setuser/',[
    'middlewares' => [
        'api'
    ],
    function($request){
       
        return new Response(200,Api\SetUser::setUserApp($request),'application/json');
    }
]);

//Rota de put,inserir nova senha
$objRouter->put('/api/v1/setuser/',[
    'middlewares' => [
        'api',
    ],
    function($request){

        return new Response(200,Api\SetUser::setEditUserApp($request),'application/json');
    }
]);


