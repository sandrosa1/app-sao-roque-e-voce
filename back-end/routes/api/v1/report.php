<?php

use \App\Http\Response;
use \App\Controller\Api;

//Rota de post, inseri um novo usuário
$objRouter->post('/api/v1/report/',[
    'middlewares' => [
        'api',
    ],
    function($request){
       
        return new Response(200,Api\Report::setNewUserReport($request),'application/json');
    }
]);

