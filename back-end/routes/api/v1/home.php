<?php

use \App\Http\Response;
use \App\Controller\Api;


//Rota de consulta para um app 
$objRouter->get('/api/v1/home',[
    'middlewares' => [
        'api'
    ],
    function($request){
        return new Response(200,Api\Home::getAllApps($request),'application/json');
    }
]);

