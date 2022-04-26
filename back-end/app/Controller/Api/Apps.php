<?php

namespace App\Controller\Api;

use App\Help\Help;
use \App\Model\Entity\Aplication\App as EntityApps;
use \App\Help\HelpEntity;
use \SandroAmancio\PaginationManager\Pagination;

class Apps extends Api {



     /**
     * Método responsável por obter a renderização  dos itens de depoimentos para a página
     * @param Request $request
     *  @param Pagination $$objPagination
     * @return string
     */
    private static function getAppsItems($request,&$objPagination){
        //DEPOIMENTOS
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTROS
        $quatidadeTotal = EntityApps::getApp(null,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;

        //PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $pagianaAtual = $queryParams['page'] ?? 1;
        
        //INSTANCIA DE PAGINAÇÃO
         $objPagination = new Pagination($quatidadeTotal,$pagianaAtual, 4);

        //RESULTADOS DA PÁGINA
        $results = EntityApps::getApp(null,'idApp DESC',$objPagination->getLimit());

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
            'celular'        => $objApp->celular,
            'cep'            => $objApp->cep,
            'logradouro'     => $objApp->logradouro,
            'numero'         => $objApp->numero,
            'bairro'         => $objApp->bairro,
            'localidade'     => $objApp->localidade,
            'chaves'         => $objApp->chaves,
            'visualizacao'   => $objApp->visualizacao,
            'totalCusto'     => $objApp->totalCusto,
            'totalAvaliacao' => $objApp->totalAvaliacao,
            'custo'          => $objApp->custo,
            'avaliacao'      => $objApp->avaliacao,
            'img1'           => 'http://www.racsstudios.com/img/imgApp/'.$objApp->img1,
            'adicionais'     => $objApp->adicionais,
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
    public static function getApps($request){

        return [
            'apps'      => self::getAppsItems($request,$objPagination),
            'paginacao' => parent::getPagination($request,$objPagination)
            
        ];
    }


    /**
     * Retorna um app e suas informações
     *
     * @param Request $request
     * @param int $id
     * @return array
     */
    public static function getApp($request, $id){


        if(!is_numeric($id)){
            
            throw new \Exception("O id ".$id." não e valido", 400);

        }

        $objApp = EntityApps::getAppById($id);
        $objAppTur = HelpEntity::helpGetEntity($objApp );

        if(!$objApp instanceof EntityApps){
            throw new \Exception("O App ".$id." não foi localizado", 404);
        }

        return  [
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
            'totalCusto'     => $objApp->totalCusto,
            'totalAvaliacao' => $objApp->totalAvaliacao,
            'custo'          => $objApp->custo,
            'avaliacao'      => $objApp->avaliacao,
            'img1'           => 'http://www.racsstudios.com/img/imgApp/'.$objApp->img1,
            'adicionais'     => $objApp->adicionais,
            'complemeto'     =>self::getEntity($objApp->segmento,$objAppTur)

        ];
        

    }


     /**
     * Retorna a entidade
     *
     * @param string $segmento
     * @return array
     */
    private static function getEntity($segmento, $app){

       
        switch ($segmento) {
            case 'gastronomia':
                return self::gastronomia($app);

            case 'evento':
                return self::evento($app);

            case 'servicos':
                return self::servico($app);

            case 'comercio':
                return self::comercio($app);

            case 'hospedagem':
                return self::hospedagem($app);

            case 'turismo':
                return self::turismo($app);
           
        }
    }


    /**
     * Metódo responsável por retonar informações adicionas do App da hospedagem
     *
     * @param Entity $objHospedagem
     * @return array
     */
    private static function hospedagem($objHospedagem){

      
        return [
            'semana' => $objHospedagem->semana,
            'sabado' => $objHospedagem->sabado,
            'domingo' => $objHospedagem->domingo,
            'feriado' => $objHospedagem->feriado,
            'estacionamento' => $objHospedagem->estacionamento == -1 ? false : true,
            'brinquedos' => $objHospedagem->brinquedos == -1 ? false : true,
            'restaurante' => $objHospedagem->restaurante == -1 ? false : true,
            'arCondicionado' => $objHospedagem->arCondicionado == -1 ? false : true,
            'wiFi' => $objHospedagem->wiFi == -1 ? false : true,
            'academia' => $objHospedagem->academia == -1 ? false : true,
            'piscina' => $objHospedagem->piscina == -1 ? false : true,
            'refeicao' => $objHospedagem->refeicao == -1 ? false : true,
            'emporio' => $objHospedagem->emporio == -1 ? false : true,
            'adega' => $objHospedagem->adega == -1 ? false : true,
            'bebidas' => $objHospedagem->bebidas == -1 ? false : true,
            'sorveteria' => $objHospedagem->sorveteria == -1 ? false : true,
            'whatsapp' => $objHospedagem->whatsapp == -1 ? false : true,
            'descricao' => $objHospedagem->descricao,
            'img2' => $objHospedagem->img2,
            'img3' => $objHospedagem->img3,
        ];
         
        
    }
    /**
     *  Metódo responsável por retonar informações adicionas da App Gastronomia
     *
     * @param Entity $objGastronomia
     * @return array
     */
    private static function gastronomia($objGastronomia){

        return [

            'semana' => $objGastronomia->semana,
            'sabado' => $objGastronomia->sabado,
            'domingo' => $objGastronomia->domingo,
            'feriado' => $objGastronomia->feriado,
            'estacionamento' => $objGastronomia->estacionamento == -1 ? false : true,
            'acessibilidade' => $objGastronomia->acessibilidade == -1 ? false : true,
            'wiFi' => $objGastronomia->wiFi == -1 ? false : true,
            'brinquedos' => $objGastronomia->brinquedos == -1 ? false : true,
            'restaurante' => $objGastronomia->restaurante == -1 ? false : true,
            'emporio' => $objGastronomia->emporio == -1 ? false : true,
            'adega' => $objGastronomia->adega == -1 ? false : true,
            'bebidas' => $objGastronomia->bebidas == -1 ? false : true,
            'sorveteria' => $objGastronomia->sorveteria == -1 ? false : true,
            'entregaDomicilio' => $objGastronomia->entregaDomicilio == -1 ? false : true,
            'whatsapp' => $objGastronomia->whatsapp == -1 ? false : true,
            'descricao' => $objGastronomia->descricao,
            'img2' => $objGastronomia->img2,
            'img3' => $objGastronomia->img3,

        ];
        
    }
     /**
     *  Metódo responsável por retonar informações adicionas do App de evento
     *
     * @param Entity $objEvento
     * @return array
     */
    private static function evento($objEvento){

       return [

            'semana' => $objEvento->semana,
            'sabado' => $objEvento->sabado,
            'domingo' => $objEvento->domingo,
            'feriado' => $objEvento->feriado,
            'estacionamento' => $objEvento->estacionamento == -1 ? false : true,
            'acessibilidade' => $objEvento->acessibilidade == -1 ? false : true,
            'wiFi' => $objEvento->wiFi == -1 ? false : true,
            'trilhas' => $objEvento->trilhas == -1 ? false : true,
            'refeicao' => $objEvento->refeicao == -1 ? false : true,
            'emporio' => $objEvento->emporio == -1 ? false : true,
            'adega' => $objEvento->adega == -1 ? false : true,
            'bebidas' => $objEvento->bebidas == -1 ? false : true,
            'sorveteria' => $objEvento->sorveteria == -1 ? false : true,
            'musica' => $objEvento->musica == -1 ? false : true,
            'whatsapp' => $objEvento->whatsapp == -1 ? false : true,
            'descricao' => $objEvento->descricao,
            'img2' => $objEvento->img2,
            'img3' => $objEvento->img3,
       ];


    }
    /**
     *  Metódo responsável por retonar informações adicionas do App de serviços
     *
     * @param Entity $objServico
     * @return array
     */
    private static function servico($objServico){

        return [
            'semana' => $objServico->semana,
            'sabado' => $objServico->sabado,
            'domingo' => $objServico->domingo,
            'feriado' => $objServico->feriado,
            'estacionamento' => $objServico->estacionamento == -1 ? false : true,
            'acessibilidade' => $objServico->acessibilidade == -1 ? false : true,
            'entregaDomicilio' => $objServico->entregaDomicilio == -1 ? false : true,
            'whatsapp' => $objServico->whatsapp == -1 ? false : true,
            'descricao' => $objServico->descricao,
            'logo' => $objServico->logo,
        ];
        
    }
    /**
     *  Metódo responsável por retonar informações adicionas do App de comércio
     *
     * @param Entity $$objComercio
     * @return array
     */
    private static function comercio($objComercio){

        return [
            'semana' => $objComercio->semana,
            'sabado' => $objComercio->sabado,
            'domingo' => $objComercio->domingo,
            'feriado' => $objComercio->feriado  == -1 ? false : true,
            'estacionamento' => $objComercio->estacionamento  == -1 ? false : true,
            'acessibilidade' => $objComercio->acessibilidade  == -1 ? false : true,
            'entregaDomicilio' => $objComercio->entregaDomicilio  == -1 ? false : true,
            'whatsapp' => $objComercio->whatsapp  == -1 ? false : true,
            'descricao' => $objComercio->descricao,
            'img2' => $objComercio->img2,
            'img3' => $objComercio->img3,
        ];
            
    }

    /**
     *  Metódo responsável por retonar informações adicionas do App de turísmo
     *
     * @param Entity $$objTurismo
     * @return array
     */
    private static function turismo($objTurismo){


        return[
           'semana' => $objTurismo->semana,
           'sabado' => $objTurismo->sabado,
           'domingo' => $objTurismo->domingo,
           'feriado' => $objTurismo->feriado,
           'estacionamento' => $objTurismo->estacionamento == -1 ? false : true,
           'acessibilidade' => $objTurismo->acessibilidade == -1 ? false : true,
           'fe' => $objTurismo->fe == -1 ? false : true,
           'trilhas' => $objTurismo->trilhas == -1 ? false : true,
           'refeicao' => $objTurismo->refeicao == -1 ? false : true,
           'natureza' => $objTurismo->natureza == -1 ? false : true,
           'cachoeira' => $objTurismo->cachoeira == -1 ? false : true,
           'parque' => $objTurismo->parque == -1 ? false : true,
           'descricao' => $objTurismo->descricao, 
           'img2' => $objTurismo->img2,
           'img3' => $objTurismo->img3,
        ] ;

    }
}