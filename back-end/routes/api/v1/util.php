<?php

use \App\Http\Response;
use \App\Controller\Api;

//Rota de listagem de todos os apps com paginação
$objRouter->get('/api/v1/util/',[
    'middlewares' => [
        'api'
    ],
    function($request){
       
        return new Response(200,Api\Util::setUtil($request),'application/json');
    }
]);


