<?php

use \App\Http\Response;
use App\Controller\Srv;

//Rota de depoimentos
$objRouter->get('/srv/forum',[
    'middlewares' => [  
        'required-srv-login'
    ],
    function($request){
      
        return new Response(200, Srv\ForumSrv::getForum($request));
    }
    
]);
