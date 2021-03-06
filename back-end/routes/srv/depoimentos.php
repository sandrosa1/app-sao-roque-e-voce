<?php

use \App\Http\Response;
use App\Controller\Srv;

//Rota de depoimentos
$objRouter->get('/srv/depoimentos',[
    'middlewares' => [  
        'required-srv-login'
    ],
    function($request){
      
        return new Response(200, Srv\TestimonySrv::getTestimonials($request));
    }
    
]);
