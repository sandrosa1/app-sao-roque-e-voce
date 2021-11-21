<?php

use \App\Http\Response;
use App\Controller\RACS;

//Rota dos apps
$objRouter->get('/racs/apps',[
    'middlewares' => [
        'required-racs-login',
    ],
    function($request){
        return new Response(200, RACS\App::getApps($request));
    }
    
]);
