<?php

use \App\Http\Response;
use \App\Controller\Api;

//Rota de consulta para trazer os comentários de um usuário 
$objRouter->get('/api/v1/commentuser/',[
    'middlewares' => [
        'api',
        'user-basic-auth' 
    ],
    function($request){
        return new Response(200,Api\CommentUser::getCommentApp($request),'application/json');
    }
]);

//Rota de consulta para trazer os comentários de um usuário 
$objRouter->get('/api/v1/commentuser/all',[
    'middlewares' => [
        'api',
        'user-basic-auth' 
    ],
    function($request){
        return new Response(200,Api\CommentUser::getCommentAppAll($request),'application/json');
    }
]);

//Rota de consulta para atualizar um comentário
$objRouter->put('/api/v1/commentuser/{idComment}',[
    'middlewares' => [
        'api',
        'user-basic-auth' 
    ],
    function($request, $idComment){
        return new Response(200,Api\CommentUser::setEditCommentApp($request,$idComment),'application/json');
    }
]);

//Rota de consulta para deletar um comentário
$objRouter->delete('/api/v1/commentuser/{idComment}',[
    'middlewares' => [
        'api',
        'user-basic-auth' 
    ],
    function($request, $idComment){
        return new Response(200,Api\CommentUser::setDeleteCommentApp($request,$idComment),'application/json');
    }
]);