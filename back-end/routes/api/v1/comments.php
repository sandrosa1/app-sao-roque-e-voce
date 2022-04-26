<?php

use \App\Http\Response;
use \App\Controller\Api;


//Rota de consulta para um app 
$objRouter->get('/api/v1/comments/{id}',[
    'middlewares' => [
        'api'
    ],
    function($request, $id){
        return new Response(200,Api\Comments::getCommentApp($request,$id),'application/json');
    }
]);