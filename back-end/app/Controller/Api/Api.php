<?php

namespace App\Controller\Api;

class Api{

    /**
     * Retorna as informações da api
     *
     * @param Request $request
     * @return array
     */
    public static function getDetails($request){

        return [
            'nome' => 'API- SRV',
            'versao' => 'v1.0.0',
            'autor' => 'RACS studios',
            'email' => 'contato@racsstudios.com'
        ];
    }

    protected static function getPagination($request,$objPagination){


        $queryParams = $request->getQueryParams();

        $pages = $objPagination->getPages();


        return [
            'paginaAtual'            => isset($queryParams['page']) ? (int)$queryParams['page'] : 1,
            'quantidadeTotalPaginas' => !empty($pages) ? count($pages) : 1
        ];
       
    }
}