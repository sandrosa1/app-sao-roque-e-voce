<?php

use \App\Http\Response;
use App\Controller\Srv;

//Rota de principal do painel de amin do cliente
$objRouter->get('/srv/home',[
    'middlewares' => [  
        'required-srv-login'
    ],
    function($request){
      
        return new Response(200, Srv\HomeSrv::getHome($request));
    }
    
]);
