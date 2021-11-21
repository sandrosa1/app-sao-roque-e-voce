<?php

use \App\Http\Response;
use App\Controller\RACS;


//Rota de login
$objRouter->get('/racs/login',[
    'middlewares' => [],
    function($request){
        
        return new Response(200, RACS\Login::getLogin($request));
    }
]);

//Rota de login (POST)
$objRouter->post('/racs/login',[
    'middlewares' => [],
    function($request){
        // echo '<pre>';
        // print_r('p1');
        // echo '</pre>';
        // exit;
        return new Response(200, RACS\Login::setLogin($request));
    }
]);

//Rota de logout
$objRouter->get('/racs/logout',[
    'middlewares' => [],
    function($request){
        return new Response(200, RACS\Login::setLogout($request));
    }
]);

