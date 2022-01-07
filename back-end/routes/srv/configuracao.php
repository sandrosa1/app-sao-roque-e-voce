<?php

use \App\Http\Response;
use App\Controller\Srv;

//Rota de detalhes
$objRouter->get('/srv/configuracao',[
    'middlewares' => [  
         'required-srv-login'
    ],
    function($request){
       
        return new Response(200, Srv\Config::getConfig($request));
    }
    
]);
//Rota de pesquisa do cep (POST)
$objRouter->post('/srv/configuracao/cep',[
    'middlewares' => [  
        'required-srv-login'
   ],
    function($request){
        return new Response(200,Srv\Config::cep($request));
    }
]);

//Rota de detalhes
$objRouter->post('/srv/configuracao',[
    'middlewares' => [  
         'required-srv-login'
    ],
    function($request){
       
        return new Response(200, Srv\Config::postConfig($request));
    }
    
]);
