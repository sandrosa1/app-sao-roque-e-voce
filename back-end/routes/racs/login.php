<?php

use \App\Http\Response;
use App\Controller\RACS;


//Rota de login
$objRouter->get('/racs/login',[
    'middlewares' => [
     'required-racs-logout',
    ],
    function($request){
        
        return new Response(200, RACS\Login::getLogin($request));
    }
]);

//Rota de login (POST)
$objRouter->post('/racs/login',[
    'middlewares' => [
        'required-racs-logout',
    ],
    function($request){
        return new Response(200, RACS\Login::setLogin($request));
    }
]);

//Rota de logout
$objRouter->get('/racs/logout',[
    'middlewares' => [
        'required-racs-login',
    ],
    function($request){
        return new Response(200, RACS\Login::setLogout($request));
    }
]);

