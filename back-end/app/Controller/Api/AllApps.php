<?php

namespace App\Controller\Api;

use \App\Model\Entity\Aplication\App as EntityApps;
use \SandroAmancio\PaginationManager\Pagination;


class AllApps extends Api {

    /**
     * Retorna todos os apps e informações principais
     *
     * @param Request $request
     * @return array
     */
    public static function getAllApps($request){


        $queryParams = $request->getQueryParams();
        $filter = $queryParams['filter'] ?? "visualizacao";
        $order = $queryParams['order'] ?? "DESC";

        $results = EntityApps::getApp(null, $filter.' '.$order,null);
      
        //RENDERIZA ITEM
        while($objApp = $results->fetchObject(EntityApps::class)){
           
          
    
            $itens [] = [
            'idApp'          => (int)$objApp->idApp,
            'nomeFantasia'   => $objApp->nomeFantasia,
            'segmento'       => $objApp->segmento,
            'tipo'           => $objApp->tipo,
            'email'          => $objApp->email,
            'telefone'       => $objApp->telefone,
            'site'           => $objApp->site,
            'facebook'       => $objApp->facebook,
            'instagram'      => $objApp->instagram,
            'youtube'        => $objApp->youtube,
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

        //RETORNA OS DEPOIMENTOS
        return [
            'apps'      => $itens   
        ];
    }

    /**
     * Método responsável por obter a renderização  dos itens de depoimentos para a página
     * @param Request $request
     *  @param Pagination $$objPagination
     * @return string
     */
    private static function getAppsItems($request,$segmento,&$objPagination,$where){

        //DEPOIMENTOS
        $itens = [];
        //QUANTIDADE TOTAL DE REGISTROS
        $quatidadeTotal = EntityApps::getApp($where.' = "'.$segmento .'"',null,null,'COUNT(*) as qtd')->fetchObject()->qtd;

        //PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $pagianaAtual = $queryParams['page'] ?? 1;
        
        //INSTANCIA DE PAGINAÇÃO
         $objPagination = new Pagination($quatidadeTotal,$pagianaAtual, 4);

        //RESULTADOS DA PÁGINA
        $results = EntityApps::getApp($where.' = "'.$segmento .'"','idApp DESC',$objPagination->getLimit());

        //RENDERIZA ITEM
        while($objApp = $results->fetchObject(EntityApps::class)){
        


            if($objApp->segmento == $segmento){
          
                $itens [] = [
                'idApp'          => (int)$objApp->idApp,
                'nomeFantasia'   => $objApp->nomeFantasia,
                'segmento'       => $objApp->segmento,
                'tipo'           => $objApp->tipo,
                'email'          => $objApp->email,
                'telefone'       => $objApp->telefone,
                'site'           => $objApp->site,
                'facebook'       => $objApp->facebook,
                'instagram'      => $objApp->instagram,
                'youtube'        => $objApp->youtube,
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
    public static function getAllAppsForType($request,$segmento){


        return [
            'apps'      => self::getAppsItems($request,$segmento,$objPagination,'segmento'),
            'paginacao' => parent::getPagination($request,$objPagination)
            
        ];
    }


   
}