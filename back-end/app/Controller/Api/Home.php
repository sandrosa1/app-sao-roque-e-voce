<?php

namespace App\Controller\Api;

use \App\Model\Entity\Aplication\App as EntityApps;



class Home extends Api {

    /**
     * Retorna todos os apps e informações principais
     *
     * @param Request $request
     * @return array
     */
    public static function getAllApps(){


        
        $results = EntityApps::getApp( null,'visualizacao DESC',10);
      
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
            'appsMostViewed'      => $itens   
        ];
    }

    

   
}