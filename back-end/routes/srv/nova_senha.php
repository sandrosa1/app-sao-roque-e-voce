<?php

use \App\Http\Response;
use App\Controller\Srv;


//Rota de get de nova senha
$objRouter->get('/srv/nova_senha',[
    'middlewares' => [
        'required-srv-logout',
    ],
    function($request){
       
        return new Response(200, Srv\NewPassword::getNewPassword($request));
    }
]);

//Rota de (POST) nova senha
$objRouter->post('/srv/nova_senha',[
    'middlewares' => [
        'required-srv-logout',
    ],
    function($request){
      
        return new Response(200, Srv\NewPassword::setNewPassword($request));
    }
]);



