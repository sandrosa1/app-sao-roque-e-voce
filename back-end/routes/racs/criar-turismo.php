<?php

use \App\Http\Response;
use App\Controller\RACS;

//Rota dos apps get
$objRouter->get('/racs/criar-turismo',[
    'middlewares' => [
        'required-racs-login',
    ],
    function($request){
        return new Response(200, RACS\Turismo::getAppTurismo($request));
    }
    
]);

//Rota dos apps post
$objRouter->post('/racs/criar-turismo',[
    'middlewares' => [
        'required-racs-login',
    ],
    function($request){
        
        return new Response(200, RACS\Turismo::getPostAppTurismo($request));
    }
    
]);

//Rota dos apps post
$objRouter->post('/racs/criar-turismo/cep',[
    'middlewares' => [
        'required-racs-login',
    ],
    function($request){
        return new Response(200, RACS\Turismo::getCepApp($request));
    }
    
]);
