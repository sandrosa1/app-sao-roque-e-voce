<?php

use \App\Http\Response;
use \App\Controller\Api;


//Rota de consulta para um app 
$objRouter->get('/api/v1/allapps',[
    'middlewares' => [
        'api'
    ],
    function($request){
        return new Response(200,Api\AllApps::getAllApps($request),'application/json');
    }
]);


//Rota de consulta para um app 
$objRouter->post('/api/v1/allapps/{segmento}',[
    'middlewares' => [
        'api'
    ],
    function($request,$segmento){
        return new Response(200,Api\AllApps::getAllAppsForType($request,$segmento),'application/json');
    }
]);