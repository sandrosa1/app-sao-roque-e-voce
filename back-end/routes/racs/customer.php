<?php

use \App\Http\Response;
use App\Controller\RACS;

//Rota de clientes
$objRouter->get('/racs/customer',[
    'middlewares' => [
        'required-racs-login',
    ],
    function($request){
        return new Response(200, RACS\Customer::getCustomers($request));
    }
    
]);
