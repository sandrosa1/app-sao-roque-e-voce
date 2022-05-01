<?php

namespace App\Controller\Api;

use \App\Model\Entity\User\Comment as EntityComments;
use \App\Model\Entity\Aplication\App as EntityApps;
use \SandroAmancio\PaginationManager\Pagination;
use \App\Validate\Validate;
use \App\Help\Help;

class CommentUser extends Api {


    /**
     * Método responsável por obter a renderização  dos itens de comentário para um usuário
     * @param Request $request
     *  @param Pagination $$objPagination
     * @return string
     */
    private static function getAllCommentApp($request,$idUsuario,&$objPagination,$where){
        //DEPOIMENTOS
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTROS
        $quatidadeTotal = EntityComments::getComment($where.' = '.$idUsuario,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;

        //PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $pagianaAtual = $queryParams['page'] ?? 1;
        
        //INSTANCIA DE PAGINAÇÃO
         $objPagination = new Pagination($quatidadeTotal,$pagianaAtual, 4);

        //RESULTADOS DA PÁGINA
        $results = EntityComments::getComment($where.' = '.$idUsuario,'data DESC',$objPagination->getLimit());

        //RENDERIZA ITEM
        while($objComment = $results->fetchObject(EntityComments::class)){
        
            $itens [] = [
                'idComment'  => (int)$objComment->idComment,
                'idApp'      => (int)$objComment->idApp,
                'idUsuario'  => (int)$objComment->idUsuario,
                'nome'       => $objComment->nome,
                'comentario' => $objComment->comentario,
                'utilSim'    => (int)$objComment->utilSim,
                'utilNao'    => (int)$objComment->utilNao,
                'data'       => $objComment->data,
                'avaliacao'  => (int)$objComment->avaliacao,
                'custo'      => (int)$objComment->custo,
            ];
            
        }

        //RETORNA OS DEPOIMENTOS
        return $itens;
    }

    /**
     * Retorna todos os comentários de um usuário 
     *
     * @param Request $request
     * @return array
     */
    public static function getCommentApp($request){


        if(!is_numeric($request->user->idUsuario)){
            
            throw new \Exception("O id ".$request->user->idUsuario." não e valido", 400);

        }

        $objComment = EntityComments::getCommentByIdUser($request->user->idUsuario);

        if(!$objComment instanceof EntityComments){
            throw new \Exception("Não há comentários para o id: ".$request->user->idUsuario.".", 404);
        }

        return [
            'comments'      => self::getAllCommentApp($request,$request->user->idUsuario,$objPagination,'idUsuario'),
            'paginacao' => parent::getPagination($request,$objPagination)
             
        ];
    }
   
    /**
     * Atualiza um comentário a um app
     *
     * @param Request $request
     * @return array
     */
    public static function setEditCommentApp($request,$idComment){


        $postVars = $request->getPostVars();

        if(!isset($postVars['idApp']) || !isset($postVars['comentario']) || !isset($postVars['avaliacao']) ){

            throw new \Exception("Os campos idApp, comentario e avaliação são obrigatórios", 400);
            
        }

        $objComment = EntityComments::getCommentByIdAppComment($idComment);

        if(!$objComment instanceof EntityComments){
            throw new \Exception("Não há comentários para o id: ".$idComment.".", 404);
        }
        
        if($objComment->idUsuario != $request->user->idUsuario){
    
            throw new \Exception("O comentário não pode ser editado por outra usuário", 404);

        }

        $validate = new Validate();

        $words = Help::helpTextForArray($postVars['comentario']);
       
        if(!$validate->validateBlockedWord($words)){
            throw new \Exception("Existe palavras impróprias no coméntario", 404);
        }

        $objApp = EntityApps::getAppById($postVars['idApp']);
         
        $objComment->idApp          = $postVars['idApp'];
        $objComment->idUsuario      = $request->user->idUsuario;
        $objComment->nome           = $request->user->nomeUsuario;
        $objComment->comentario     = $postVars['comentario'];
        $objComment->custo          = $postVars['custo'];

        if( $objComment->avaliacao != $postVars['avaliacao']){
            $objComment->avaliacao  = $postVars['avaliacao'];
            $objApp->avaliacao      = $objApp->avaliacao + 1 ;
            $objApp->totalAvaliacao = $objApp->totalAvaliacao + $postVars['avaliacao'];
            $objApp->totalCusto     = $objApp->totalCusto + $postVars['custo'];
            $objApp->updateApp();
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
    /**
     * Excuir um comentário a um app
     *
     * @param Request $request
     * @return array
     */
    public static function setDeleteCommentApp($request,$idComment){


        $postVars = $request->getPostVars();
        
        $objComment = EntityComments::getCommentByIdAppComment($idComment);

        if(!$objComment instanceof EntityComments){
            throw new \Exception("Não há comentários para o id: ".$idComment.".", 404);
        }
        
        if($objComment->idUsuario != $request->user->idUsuario){
    
            throw new \Exception("O comentário não pode ser excluído por outro usuário", 404);
        }

        //deleta o comentário
        $objComment->deleteComment();

        //Retorna o sucesso da exclusão
        return [
            'success'  => true,  
        ];

    }
   
}