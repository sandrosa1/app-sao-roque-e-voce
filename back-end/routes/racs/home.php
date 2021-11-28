<?php

use \App\Http\Response;
use App\Controller\RACS;

//Rota de principal do painel de amin do cliente
$objRouter->get('/racs/home',[
    'middlewares' => [
        'required-racs-login'
    ],
    function($request){
        return new Response(200, RACS\HomeRacs::getHome($request));
    }
    
]);
