<?php

namespace App\Controller\Api;

use \App\Model\Entity\User\Forum as EntityComments;
use \SandroAmancio\PaginationManager\Pagination;

class Comments extends Api {



     /**
     * Método responsável por obter a renderização  dos itens de depoimentos para a página
     * @param Request $request
     *  @param Pagination $$objPagination
     * @return string
     */
    private static function getAllCommentApp($request,$id,&$objPagination){
        //DEPOIMENTOS
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTROS
        $quatidadeTotal = EntityComments::getForum('idApp = '.$id,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;

        //PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $pagianaAtual = $queryParams['page'] ?? 1;
        
        //INSTANCIA DE PAGINAÇÃO
         $objPagination = new Pagination($quatidadeTotal,$pagianaAtual, 4);

        //RESULTADOS DA PÁGINA
        $results = EntityComments::getForum(null,'data DESC',$objPagination->getLimit());

        //RENDERIZA ITEM
        while($objApp = $results->fetchObject(EntityComments::class)){
        
            $itens [] = [
                'idApp' => $objApp->idApp,
                'idUsuario' => $objApp->idUsuario,
                'nome' => $objApp->nome,
                'comentario' => $objApp->comentario,
                'utilSim' => $objApp->utilSim,
                'utilNao' => $objApp->utilNao,
                'data' => $objApp->data,
                'avaliacao' => $objApp->avaliacao,
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
    public static function getCommentApp($request, $id){


        if(!is_numeric($id)){
            
            throw new \Exception("O id ".$id." não e valido", 400);

        }

        $objComments = EntityComments::getForumByIdApp($id);

        if(!$objComments instanceof EntityComments){
            throw new \Exception("Não há comentários para o id: ".$id.".", 404);
        }

        return [
            'comments'      => self::getAllCommentApp($request,$id,$objPagination),
            'paginacao' => parent::getPagination($request,$objPagination)
             
        ];
    }


   

   
}