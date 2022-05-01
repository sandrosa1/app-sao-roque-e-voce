<?php

use \App\Http\Response;
use \App\Controller\Api;

//Rota de post, inseri um novo usuário
$objRouter->post('/api/v1/user/',[
    'middlewares' => [
        'api'
    ],
    function($request){
       
        return new Response(200,Api\User::setNewUserApp($request),'application/json');
    }
]);

//Rota de put, as configurações de usuário
$objRouter->put('/api/v1/user/',[
    'middlewares' => [
        'api',
        'user-basic-auth' 
    ],
    function($request){

        return new Response(200,Api\User::setEditUserApp($request),'application/json');
    }
]);

//Rota de deleta, exclui o usuário e seus comentários
$objRouter->delete('/api/v1/user/',[
    'middlewares' => [
        'api',
        'user-basic-auth' 
    ],
    function($request){

        return new Response(200,Api\User::setDeleteUserApp($request),'application/json');
    }
]);
