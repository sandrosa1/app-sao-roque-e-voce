<?php

use \App\Http\Response;
use App\Controller\RACS;

//Rota dos apps get
$objRouter->get('/racs/apps',[
    'middlewares' => [
        'required-racs-login',
    ],
    function($request){
        return new Response(200, RACS\AppRacs::getApps($request));
    }
    
]);

//Rota dos apps post
$objRouter->post('/racs/apps',[
    'middlewares' => [
        'required-racs-login',
    ],
    function($request){
        
        return new Response(200, RACS\AppRacs::getPostApp($request));
    }
    
]);

//Rota dos apps post
$objRouter->post('/racs/apps/cep',[
    'middlewares' => [
        'required-racs-login',
    ],
    function($request){
        return new Response(200, RACS\AppRacs::getCepApp($request));
    }
    
]);
