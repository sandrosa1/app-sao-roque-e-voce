<?php

namespace App\Controller\Api;

use \App\Model\Entity\Aplication\App as EntityApps;
use \SandroAmancio\PaginationManager\Pagination;

class Search extends Api {

    /**
     * Método responsável por obter a renderização  dos itens de depoimentos para a página
     * @param Request $request
     *  @param Pagination $$objPagination
     * @return string
     */
    private static function getAppsItems($request,&$objPagination){
        //DEPOIMENTOS
        $itens = [];
        $queryParams = $request->getQueryParams();
        $pagianaAtual = $queryParams['page'] ?? 1;
        $like = $queryParams['like'] ?? 0;
        $filter = $queryParams['filter'] ?? "visualizacao";
        $order = $queryParams['order'] ?? "DESC";
   
        if($like){
            //QUANTIDADE TOTAL DE REGISTROS
            $quatidadeTotal = EntityApps::getApp('chaves LIKE "%'.$like .'%"',null,null,'COUNT(*) as qtd')->fetchObject()->qtd;
            $query = 'chaves LIKE "%'.$like .'%"';
            
        }
        
        //INSTANCIA DE PAGINAÇÃO
         $objPagination = new Pagination($quatidadeTotal,$pagianaAtual, 4);

        //RESULTADOS DA PÁGINA
        $results = EntityApps::getApp($query,$filter.' '.$order, $objPagination->getLimit());

        //RENDERIZA ITEM
        while($objApp = $results->fetchObject(EntityApps::class)){
        
        
            if($objApp->status != 'block'){

                $itens [] = [

                    'idApp'          => (int)$objApp->idApp,
                    'nomeFantasia'   => $objApp->nomeFantasia,
                    'segmento'       => $objApp->segmento,
                    'tipo'           => $objApp->tipo,
                    'email'          => $objApp->email,
                    'telefone'       => $objApp->telefone,
                    'site'           => $objApp->site,
                    'celular'        => $objApp->celular,
                    'cep'            => $objApp->cep,
                    'logradouro'     => $objApp->logradouro,
                    'numero'         => $objApp->numero,
                    'bairro'         => $objApp->bairro,
                    'localidade'     => $objApp->localidade,
                    'chaves'         => $objApp->chaves,
                    'visualizacao'   => $objApp->visualizacao,
                    'avaliacao'      => $objApp->avaliacao,
                    'img1'           => 'http://www.racsstudios.com/img/imgApp/'.$objApp->img1,
                    'adicionais'     => $objApp->adicionais,
                    'estrelas'       => (float)$objApp->estrelas,
                    'custoMedio'     => (float)$objApp->custoMedio   
                      
                    ];
                }
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
    public static function getSearch($request){

        return [
            'apps'      => self::getAppsItems($request,$objPagination),
            'paginacao' => parent::getPagination($request,$objPagination)
            
        ];
    }


   
}