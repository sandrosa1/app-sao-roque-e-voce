<?php

use \App\Http\Response;
use \App\Controller\Api;

//Rota de post, inseri um novo usuário
$objRouter->post('/api/v1/setuser/',[
    'middlewares' => [
        'api'
    ],
    function($request){
       
        return new Response(200,Api\SetUser::setUserApp($request),'application/json');
    }
]);

// //Rota de put, as configurações de usuário
$objRouter->put('/api/v1/setuser/',[
    'middlewares' => [
        'api',
    ],
    function($request){

        return new Response(200,Api\SetUser::setEditUserApp($request),'application/json');
    }
]);


