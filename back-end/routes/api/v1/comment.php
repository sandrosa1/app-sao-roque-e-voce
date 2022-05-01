<?php

use \App\Http\Response;
use \App\Controller\Api;


//Rota de consulta, traz todos os comentários de um Estabelecimento
$objRouter->get('/api/v1/comment/{idApp}',[
    'middlewares' => [
        'api'

    ],
    function($request, $idApp){
        return new Response(200,Api\Comment::getCommentApp($request,$idApp),'application/json');
    }
]);

//Rota de inserção, inseri um novo comentária em um Estabelecimento. 
//No corpo deve haver o idApp, comentário e avaliação. No header o email e senha do usuário
$objRouter->post('/api/v1/comment/',[
    'middlewares' => [
        'api',
        'user-basic-auth' 
    ],
    function($request){
        return new Response(201,Api\Comment::setNewCommentApp($request),'application/json');
    }
]);

//Rota de edição, atualiza um comentário de um Estabelecimento. Somente o autor do comentário pode editar. 
//No corpo deve haver o idApp, comentário e avaliação. No header o email e senha do usuário
$objRouter->put('/api/v1/comment/{idComment}',[
    'middlewares' => [
        'api',
        'user-basic-auth' 
    ],
    function($request, $idComment){
        return new Response(200,Api\Comment::setEditCommentApp($request,$idComment),'application/json');
    }
]);

//Rota de exclusão, deteta o comentário de um estabelecimento através do idComment
//No header o email e senha do usuário
$objRouter->delete('/api/v1/comment/{idComment}',[
    'middlewares' => [
        'api',
        'user-basic-auth' 
    ],
    function($request, $idComment){
        return new Response(200,Api\Comment::setDeleteCommentApp($request,$idComment),'application/json');
    }
]);