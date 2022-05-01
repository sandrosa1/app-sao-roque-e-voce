<?php

namespace App\Controller\Api;

use \App\Model\Entity\Aplication\App as EntityApps;


class AllApps extends Api {

    /**
     * Retorna todos os apps e informações principais
     *
     * @param Request $request
     * @return array
     */
    public static function getAllApps(){


        $results = EntityApps::getApp(null,'idApp DESC',null);
      
        //RENDERIZA ITEM
        while($objApp = $results->fetchObject(EntityApps::class)){
           
            $objApp = EntityApps::getAppById($objApp->idApp);
           // $objAppTur = HelpEntity::helpGetEntity($objApp);
            if($objApp->avaliacao){
                $avaliacaoMedia = round((int)$objApp->totalAvaliacao/(int)$objApp->avaliacao, 2);
                $custoMedia = round((int)$objApp->totalCusto/(int)$objApp->avaliacao, 2);

            }else{
                $avaliacaoMedia = 0;

            }
    
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
            'estrelas'       => (float)$avaliacaoMedia,
            'custoMedio'     => (float)$custoMedia  
            ];
            
        }

        //RETORNA OS DEPOIMENTOS
        return [
            'apps'      => $itens   
        ];
    }

    /**
     * Retorna todos os apps e informações principais
     *
     * @param Request $request
     * @return array
     */
    public static function getAllAppsForType($request, $segmento){


        
        $results = EntityApps::getApp(null,'idApp DESC',null);
      
        //RENDERIZA ITEM
        while($objApp = $results->fetchObject(EntityApps::class)){
           
            if($objApp->segmento == $segmento){

                $objApp = EntityApps::getAppById($objApp->idApp);
                // $objAppTur = HelpEntity::helpGetEntity($objApp);
                 if($objApp->avaliacao){
                     $avaliacaoMedia = round((int)$objApp->totalAvaliacao/(int)$objApp->avaliacao, 2);
                     $custoMedia = round((int)$objApp->totalCusto/(int)$objApp->avaliacao, 2);
     
                 }else{
                     $avaliacaoMedia = 0;
     
                 }
         
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
                    'estrelas'       => (float)$avaliacaoMedia,
                    'custoMedio'     => (float)$custoMedia  
                ];
            }
     
        }

         
        //RETORNA OS DEPOIMENTOS
        return [
            'apps'      => $itens   
        ];
    }

   
}