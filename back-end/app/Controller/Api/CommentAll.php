<?php
namespace App\Controller\Api;

use \App\Model\Entity\User\Comment as EntityComments;
use \SandroAmancio\PaginationManager\Pagination;


class CommentAll extends Api {


    /**
     * Cria um array com todos os comentários de um estabelecimento pelo seu idApp sem paginação
     * @param Request $request
     *  @param Pagination $$objPagination
     * @return array
     */
    private static function getAllCommentAppAll($request,$idApp,$where){
        //DEPOIMENTOS
        $itens = [];

        $queryParams = $request->getQueryParams();
        $pagianaAtual = $queryParams['page'] ?? 1;
        $filter = $queryParams['filter'] ?? "data";
        $order = $queryParams['order'] ?? "DESC";
        //QUANTIDADE TOTAL DE REGISTROS
        $quatidadeTotal = EntityComments::getComment($where.' = '.$idApp, $filter.' '.$order, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

       
        //RESULTADOS DA PÁGINA
        $results = EntityComments::getComment($where.' = '.$idApp, $filter.' '.$order);

        //RENDERIZA ITEM
        while($objComment = $results->fetchObject(EntityComments::class)){
        
            $itens [] = [

                'idComment'        => (int)$objComment->idComment,
                'idApp'            => (int)$objComment->idApp,
                'idUsuario'        => (int)$objComment->idUsuario,
                'estabelecimento'  => $objComment->estabelecimento,
                'nome'             => $objComment->nome,
                'comentario'       => $objComment->comentario,
                'utilSim'          => (int)$objComment->utilSim,
                'utilNao'          => (int)$objComment->utilNao,
                'data'             => $objComment->data,
                'avaliacao'        => (int)$objComment->avaliacao,
                'custo'            => (int)$objComment->custo,
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
    public static function getCommentAppAll($request, $idApp){


      

        if(!is_numeric($idApp)){
            
            throw new \Exception("O id ".$idApp." não e valido", 400);

        }

        $objComment = EntityComments::getCommentByIdApp($idApp);

        if(!$objComment instanceof EntityComments){
            throw new \Exception("Não há comentários para o idApp: ".$idApp.".", 404);
        }

        return [
            'comments'      => self::getAllCommentAppAll($request, $idApp,'idApp'),
             
        ];
    }
  
   
}