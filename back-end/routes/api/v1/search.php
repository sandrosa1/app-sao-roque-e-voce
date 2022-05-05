<?php

use \App\Http\Response;
use \App\Controller\Api;

//Rota de consulta para um app passando como parametro a pagína
$objRouter->get('/api/v1/search',[
    'middlewares' => [
        'api'
    ],
    function($request){
        return new Response(200,Api\Search::getSearch($request),'application/json');
    }
]);

