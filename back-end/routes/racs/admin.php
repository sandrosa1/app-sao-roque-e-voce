<?php

use \App\Http\Response;
use App\Controller\RACS;

//Rota de administração
$objRouter->get('/racs/admin',[
    'middlewares' => [],
    function($request){
        return new Response(200, RACS\Admin::getAdmins($request));
    }
    
]);
