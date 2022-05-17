<?php

namespace App\Controller\Api;

use \App\Model\Entity\User\Comment as EntityComments;
use \App\Model\Entity\Aplication\App as EntityApps;
use \SandroAmancio\PaginationManager\Pagination;
use \App\Validate\Validate;
use \App\Help\Help;

class Comment extends Api {


    /**
     * Cria um array com todos os comentários de um estabelecimento pelo seu idApp
     * @param Request $request
     *  @param Pagination $$objPagination
     * @return array
     */
    private static function getAllCommentApp($request,$idApp,&$objPagination,$where){
        //DEPOIMENTOS
        $itens = [];


        $queryParams = $request->getQueryParams();
        $pagianaAtual = $queryParams['page'] ?? 1;
        $filter = $queryParams['filter'] ?? "data";
        $order = $queryParams['order'] ?? "DESC";
        //QUANTIDADE TOTAL DE REGISTROS
        $quatidadeTotal = EntityComments::getComment($where.' = '.$idApp, $filter.' '.$order, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $pagianaAtual = $queryParams['page'] ?? 1;
        
        //INSTANCIA DE PAGINAÇÃO
         $objPagination = new Pagination($quatidadeTotal,$pagianaAtual, 4);

        //RESULTADOS DA PÁGINA
        $results = EntityComments::getComment($where.' = '.$idApp, $filter.' '.$order ,$objPagination->getLimit());

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
     * Retorna todos os apps e informações principais
     *
     * @param Request $request
     * @return array
     */
    public static function getCommentApp($request, $idApp){


      

        if(!is_numeric($idApp)){
            
            throw new \Exception("O id ".$idApp." não e valido", 400);

        }

        $objComment = EntityComments::getCommentByIdApp($idApp);

        if(!$objComment instanceof EntityComments){
            throw new \Exception("Não há comentários para o idApp: ".$idApp.".", 404);
        }

        return [
            'comments'      => self::getAllCommentApp($request, $idApp, $objPagination,'idApp'),
            'paginacao' => parent::getPagination($request, $objPagination)
             
        ];
    }
    /**
     * Inserí um novo comentário a um estabelecimento
     *
     * @param Request $request
     * @return array
     */
    public static function setNewCommentApp($request){


        $postVars = $request->getPostVars();

        if(!isset($postVars['idApp']) || !isset($postVars['comentario']) || !isset($postVars['avaliacao']) || !isset($postVars['custo']) ){

            throw new \Exception("Os campos idApp, comentario e avaliação são obrigatórios", 400);
            
        }

        $validate = new Validate();

        $words = Help::helpTextForArray($postVars['comentario']);
       
        if(!$validate->validateBlockedWord($words)){
            throw new \Exception("Existe palavras impróprias no coméntario", 404);
        }

       

        $objApp = EntityApps::getAppById($postVars['idApp']);
        $objApp->avaliacao       = $objApp->avaliacao + 1 ;
        $objApp->totalAvaliacao  = $objApp->totalAvaliacao + $postVars['avaliacao'];
        $objApp->totalCusto      = $objApp->totalCusto + $postVars['custo'];
        $objApp->custoMedio      =  (float)$objApp->totalCusto / (float)$objApp->avaliacao;
        $objApp->estrelas        =  (float)$objApp->totalAvaliacao / (float)$objApp->avaliacao;


        $objApp->updateApp();

        //Novo comentário
        $objComment = new EntityComments();

        $objComment->idApp      = (int)$postVars['idApp'];
        $objComment->idUsuario  = (int)$request->user->idUsuario;
        $objComment->nome       = $request->user->nomeUsuario;
        $objComment->comentario = $postVars['comentario'];
        $objComment->utilSim    = 0;
        $objComment->utilNao    = 0;
        $objComment->avaliacao  = (int)$postVars['avaliacao'];
        $objComment->custo      = (int)$postVars['custo'];

        
        $objComment->insertNewComment();

        return [
            
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
    /**
     * Atualiza um comentário a um app
     *
     * @param Request $request
     * @return array
     */
    public static function setEditCommentApp($request,$idComment){


        $postVars = $request->getPostVars();

        if(!isset($postVars['idApp']) || !isset($postVars['comentario']) || !isset($postVars['avaliacao']) || !isset($postVars['custo'])){

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
            
            $objApp->avaliacao       = $objApp->avaliacao + 1 ;
            $objApp->totalAvaliacao  = $objApp->totalAvaliacao + $postVars['avaliacao'];
            $objApp->totalCusto      = $objApp->totalCusto + $postVars['custo'];
            $objApp->custoMedio      =  (float)$objApp->totalCusto / (float)$objApp->avaliacao;
            $objApp->estrelas        =  (float)$objApp->totalAvaliacao / (float)$objApp->avaliacao;
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