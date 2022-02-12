<?php

use \App\Http\Response;
use App\Controller\Srv;

//Rota de configuação do preview do App
$objRouter->get('/srv/tela',[
    'middlewares' => [  
        'required-srv-login'
    ],
    function($request){
      
        return new Response(200, Srv\ScreenSrv::getScreen($request));
    }
    
]);

$objRouter->post('/srv/tela',[
    'middlewares' => [  
        'required-srv-login'
    ],
    function($request){
      
        return new Response(200, Srv\ScreenSrv::uploadImage($request));
    }
    
]);

