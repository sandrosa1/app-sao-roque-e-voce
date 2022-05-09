<?php

use \App\Http\Response;
use \App\Controller\Api;

//Rota de get vai enviar email para o usuario confirmar se e ele mesmo
$objRouter->get('/api/v1/login/',[
    'middlewares' => [
        'api'
    ],
    function($request){
       
        return new Response(200,Api\Login::resetPassword($request),'application/json');

    }
]);

//Rota de post verifica se o usuário e senha confere
$objRouter->post('/api/v1/login/',[
    'middlewares' => [
        'api',
    ],
    function($request){

        return new Response(200,Api\Login::existUser($request),'application/json');
    }
]);

//Rota de put atualiza a nova senha
$objRouter->put('/api/v1/login/',[
    'middlewares' => [
        'api', 
    ],
    function($request){

        return new Response(200,Api\Login::setNewPassword($request),'application/json');
    }
]);
