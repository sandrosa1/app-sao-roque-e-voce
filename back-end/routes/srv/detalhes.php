<?php

use \App\Http\Response;
use App\Controller\Srv;

//Rota de detalhes
$objRouter->get('/srv/detalhes',[
    'middlewares' => [  
         'required-srv-login'
    ],
    function($request){
       
        return new Response(200, Srv\SettingSrv::getSetting($request));
    }
    
]);

//Rota de pesquisa do atualizar (POST)
$objRouter->post('/srv/detalhes',[
    'middlewares' => [  
        'required-srv-login'
   ],
    function($request){
       
        return new Response(200,Srv\SettingSrv::update($request));
    }
]);