<?php

use \App\Http\Response;
use \App\Controller\Api;

//Rota de listagem de todos os apps com paginação
$objRouter->get('/api/v1/apps',[
    'middlewares' => [
        'api'
    ],
    function($request){
       
        return new Response(200,Api\Apps::getApps($request),'application/json');
    }
]);

//Rota de consulta para um app passando como parametro a pagína
$objRouter->get('/api/v1/apps/{id}',[
    'middlewares' => [
        'api'
    ],
    function($request,$id){

        return new Response(200,Api\Apps::getApp($request,$id),'application/json');
    }
]);

