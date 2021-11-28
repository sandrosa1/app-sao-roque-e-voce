<?php

use \App\Http\Response;
use App\Controller\Srv;

//Rota de confirmação de cadastro
$objRouter->get('/srv/confirmation',[
    'middlewares' => [  
        
    ],
    function($request){
        
        return new Response(200, Srv\ConfirmationSrv::getConfirmation($request));
    }
]);
