<?php

namespace App\Controller\Api;

use \App\Model\Entity\User\Comment as EntityComments;

class Util extends Api {

    /**
     * Atualiza um comentário a um app
     *
     * @param Request $request
     * @return array
     */
    public static function setUtil($request){

       
        $queryParams = $request->getQueryParams();
        $idComment = $queryParams['idComment'];
        $util = $queryParams['util'];
      
        $objComment = EntityComments::getCommentByIdAppComment($idComment);

        if(!$objComment instanceof EntityComments){

            throw new \Exception("Não há comentários para o id: ".$idComment.".", 404);
        }
        
        if($objComment->idUsuario == $request->user->idUsuario){
    
            throw new \Exception("O comentário não pode ser avaliado pelo proprio usuário", 404);
        }

        if($util){
            $objComment->utilSim =   $objComment->utilSim + 1;
        }else{
            $objComment->utilNao =   $objComment->utilNao + 1;
        }
       
        //Atualiza o comentário
        $objComment->updateComment();

        //Retorna o commentario atualizado
        return [

            'idComment'  => (int)$objComment->idComment,
            'idApp'      => (int)$objComment->idApp,
            'idUsuario'  => $objComment->idUsuario,
            'nome'       => $objComment->nome,
            'comentario' => $objComment->comentario,
            'utilSim'    => (int)$objComment->utilSim,
            'utilNao'    => (int)$objComment->utilNao,
            'data'       => $objComment->data,
            'avaliacao'  => (int)$objComment->avaliacao,
            'custo'      => (int)$objComment->custo,
        ];
    }
   
}