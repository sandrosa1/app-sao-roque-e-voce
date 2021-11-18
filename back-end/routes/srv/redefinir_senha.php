<?php

use \App\Http\Response;
use App\Controller\Srv;


//Rota de redefinir senha (GET)
$objRouter->get('/srv/redefinir_senha',[
    'middlewares' => [
        'required-srv-logout',
    ],
    function($request){
       
        return new Response(200, Srv\RedefinePassword::getRedefinePassword($request));
    }
]);

//Rota de redefinir senha (POST)
$objRouter->post('/srv/redefinir_senha',[
    'middlewares' => [
        'required-srv-logout',
    ],
    function($request){
       
        return new Response(200, Srv\RedefinePassword::setRedefinePassword($request));
    }
]);



