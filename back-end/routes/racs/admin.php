<?php

use \App\Http\Response;
use App\Controller\RACS;

//Rota de administração
$objRouter->get('/racs/admin',[
    'middlewares' => [
        'required-racs-login', 
    ],
    function($request){
        return new Response(200, RACS\AdminRacs::getAdmins($request));
    }
    
]);
