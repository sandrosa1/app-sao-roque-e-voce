<?php

use \App\Http\Response;
use App\Controller\RACS;

//Rota dos apps get
$objRouter->get('/racs/criar-servico',[
    'middlewares' => [
        'required-racs-login',
    ],
    function($request){
        return new Response(200, RACS\Servico::getAppServico($request));
    }
    
]);

//Rota dos apps post
$objRouter->post('/racs/criar-servico',[
    'middlewares' => [
        'required-racs-login',
    ],
    function($request){
        
        return new Response(200, RACS\Servico::getPostAppServico($request));
    }
    
]);

//Rota dos apps post
$objRouter->post('/racs/criar-servico/cep',[
    'middlewares' => [
        'required-racs-login',
    ],
    function($request){
        return new Response(200, RACS\Servico::getCepApp($request));
    }
    
]);
