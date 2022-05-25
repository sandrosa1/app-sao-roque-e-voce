<?php

use \App\Http\Response;
use \App\Controller\Api;


//Rota de consulta, traz todos os comentários de um Estabelecimento com paginação   
$objRouter->get('/api/v1/commentall/{idApp}',[
    'middlewares' => [
        'api'

    ],
    function($request, $idApp){
        return new Response(200,Api\CommentAll::getCommentAppAll($request,$idApp),'application/json');
    }
]);

