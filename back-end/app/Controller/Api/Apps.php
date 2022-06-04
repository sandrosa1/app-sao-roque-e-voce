<?php

namespace App\Controller\Api;

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

        $queryParams = $request->getQueryParams();
        $pagianaAtual = $queryParams['page'] ?? 1;
        $filter = $queryParams['filter'] ?? "visualizacao";
        $order = $queryParams['order'] ?? "DESC";
        //QUANTIDADE TOTAL DE REGISTROS
        $quatidadeTotal = EntityApps::getApp(null,$filter.' '.$order,null,'COUNT(*) as qtd')->fetchObject()->qtd;

        
        //INSTANCIA DE PAGINAÇÃO
         $objPagination = new Pagination($quatidadeTotal,$pagianaAtual, 4);

        //RESULTADOS DA PÁGINA
        $results = EntityApps::getApp(null, $filter.' '.$order,$objPagination->getLimit());

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
    public static function getApp($request,$id){

     
        if(!is_numeric($id)){
            throw new \Exception("O id ".$id." não e valido", 400);

        }
      
        $objApp = EntityApps::getAppById($id);
        $objAppTur = HelpEntity::helpGetEntity($objApp);

        if(!$objApp instanceof EntityApps){
            throw new \Exception("O App ".$id." não foi localizado", 404);
        }

        if( $objApp->status == 'block'){
            throw new \Exception("O App ".$id." esta temporariamente indisponível.", 404);

        }

        $objApp->visualizacao = (int)$objApp->visualizacao + 1;

        $objApp->updateApp();

        return  [
        
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
            'custoMedio'     => (float)$objApp->custoMedio,  
            'complemeto'     => self::getEntity($objApp->segmento,$objAppTur )
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

            'semana'         => $objHospedagem->semana,
            'sabado'         => $objHospedagem->sabado,
            'domingo'        => $objHospedagem->domingo,
            'feriado'        => $objHospedagem->feriado,
            'estacionamento' => $objHospedagem->estacionamento == -1 ? 0 : 1,
            'brinquedos'     => $objHospedagem->brinquedos == -1 ? 0 : 1,
            'restaurante'    => $objHospedagem->restaurante == -1 ? 0 : 1,
            'arCondicionado' => $objHospedagem->arCondicionado == -1 ? 0 : 1,
            'wiFi'           => $objHospedagem->wiFi == -1 ? 0 : 1,
            'academia'       => $objHospedagem->academia == -1 ? 0 : 1,
            'piscina'        => $objHospedagem->piscina == -1 ? 0 : 1,
            'refeicao'       => $objHospedagem->refeicao == -1 ? 0 : 1,
            'emporio'        => $objHospedagem->emporio == -1 ? 0 : 1,
            'adega'          => $objHospedagem->adega == -1 ? 0 : 1,
            'bebidas'        => $objHospedagem->bebidas == -1 ? 0 : 1,
            'sorveteria'     => $objHospedagem->sorveteria == -1 ? 0 : 1,
            'whatsapp'       => $objHospedagem->whatsapp == -1 ? 0 : 1,
            'descricao'      => $objHospedagem->descricao,
            'img2'           => 'http://www.racsstudios.com/img/imgApp/'.$objHospedagem->img2,
            'img3'           => 'http://www.racsstudios.com/img/imgApp/'.$objHospedagem->img3,
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

            'semana'           => $objGastronomia->semana,
            'sabado'           => $objGastronomia->sabado,
            'domingo'          => $objGastronomia->domingo,
            'feriado'          => $objGastronomia->feriado,
            'estacionamento'   => $objGastronomia->estacionamento == -1 ? 0 : 1,
            'acessibilidade'   => $objGastronomia->acessibilidade == -1 ? 0 : 1,
            'wiFi'             => $objGastronomia->wiFi == -1 ? 0 : 1,
            'brinquedos'       => $objGastronomia->brinquedos == -1 ? 0 : 1,
            'restaurante'      => $objGastronomia->restaurante == -1 ? 0 : 1,
            'emporio'          => $objGastronomia->emporio == -1 ? 0 : 1,
            'adega'            => $objGastronomia->adega == -1 ? 0 : 1,
            'bebidas'          => $objGastronomia->bebidas == -1 ? 0 : 1,
            'sorveteria'       => $objGastronomia->sorveteria == -1 ? 0 : 1,
            'entregaDomicilio' => $objGastronomia->entregaDomicilio == -1 ? 0 : 1,
            'whatsapp'         => $objGastronomia->whatsapp == -1 ? 0 : 1,
            'descricao'        => $objGastronomia->descricao,
            'img2'             => 'http://www.racsstudios.com/img/imgApp/'.$objGastronomia->img2,
            'img3'             => 'http://www.racsstudios.com/img/imgApp/'.$objGastronomia->img3,

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

            'semana'         => $objEvento->semana,
            'sabado'         => $objEvento->sabado,
            'domingo'        => $objEvento->domingo,
            'feriado'        => $objEvento->feriado,
            'estacionamento' => $objEvento->estacionamento == -1 ? 0 : 1,
            'acessibilidade' => $objEvento->acessibilidade == -1 ? 0 : 1,
            'wiFi'           => $objEvento->wiFi == -1 ? 0 : 1,
            'trilhas'        => $objEvento->trilhas == -1 ? 0 : 1,
            'refeicao'       => $objEvento->refeicao == -1 ? 0 : 1,
            'emporio'        => $objEvento->emporio == -1 ? 0 : 1,
            'adega'          => $objEvento->adega == -1 ? 0 : 1,
            'bebidas'        => $objEvento->bebidas == -1 ? 0 : 1,
            'sorveteria'     => $objEvento->sorveteria == -1 ? 0 : 1,
            'musica'         => $objEvento->musica == -1 ? 0 : 1,
            'whatsapp'       => $objEvento->whatsapp == -1 ? 0 : 1,
            'descricao'      => $objEvento->descricao,
            'img2'           => 'http://www.racsstudios.com/img/imgApp/'.$objEvento->img2,
            'img3'           => 'http://www.racsstudios.com/img/imgApp/'.$objEvento->img3,
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
            'semana'           => $objServico->semana,
            'sabado'           => $objServico->sabado,
            'domingo'          => $objServico->domingo,
            'feriado'          => $objServico->feriado,
            'estacionamento'   => $objServico->estacionamento == -1 ? 0 : 1,
            'acessibilidade'   => $objServico->acessibilidade == -1 ? 0 : 1,
            'entregaDomicilio' => $objServico->entregaDomicilio == -1 ? 0 : 1,
            'whatsapp'         => $objServico->whatsapp == -1 ? 0 : 1,
            'descricao'        => $objServico->descricao,
            'logo'             => $objServico->logo,
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

            'semana'           => $objComercio->semana,
            'sabado'           => $objComercio->sabado,
            'domingo'          => $objComercio->domingo,
            'feriado'          => $objComercio->feriado,
            'estacionamento'   => $objComercio->estacionamento  == -1 ? 0 : 1,
            'acessibilidade'   => $objComercio->acessibilidade  == -1 ? 0 : 1,
            'entregaDomicilio' => $objComercio->entregaDomicilio  == -1 ? 0 : 1,
            'whatsapp'         => $objComercio->whatsapp  == -1 ? 0 : 1,
            'descricao'        => $objComercio->descricao,
            'img2'             => 'http://www.racsstudios.com/img/imgApp/'.$objComercio->img2,
            'img3'             => 'http://www.racsstudios.com/img/imgApp/'.$objComercio->img3,
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
           'semana'         => $objTurismo->semana,
           'sabado'         => $objTurismo->sabado,
           'domingo'        => $objTurismo->domingo,
           'feriado'        => $objTurismo->feriado,
           'estacionamento' => $objTurismo->estacionamento == -1 ? 0 : 1,
           'acessibilidade' => $objTurismo->acessibilidade == -1 ? 0 : 1,
           'fe'             => $objTurismo->fe == -1 ? 0 : 1,
           'trilhas'        => $objTurismo->trilhas == -1 ? 0 : 1,
           'refeicao'       => $objTurismo->refeicao == -1 ? 0 : 1,
           'natureza'       => $objTurismo->natureza == -1 ? 0 : 1,
           'cachoeira'      => $objTurismo->cachoeira == -1 ? 0 : 1,
           'parque'         => $objTurismo->parque == -1 ? 0 : 1,
           'descricao'      => $objTurismo->descricao, 
           'img2'           => 'http://www.racsstudios.com/img/imgApp/'.$objTurismo->img2,
           'img3'           => 'http://www.racsstudios.com/img/imgApp/'.$objTurismo->img3,
        ] ;

    }
}