<?php

namespace App\Controller\Srv;

use \SandroAmancio\Search\Address;
use \App\Model\Entity\Aplication\App as EntityApp;
use \App\Model\Entity\Aplication\Hospedagem\Hospedagem as EntityHospedagem;


use \App\Utils\View;

class Config extends PageSrv
{
    /**
     * Metódo respónsavel por retornar a view do botão de cadastrar
     *
     * @return string
     */
    private static function getButtonRegister()
    {
        return View::render('srv/modules/configuracao/botoes/cadastrar');
    }
    /**
     * Metódo respónsavel por retornar a view do botão de atualizar e deletar
     *
     * @return string
     */
    private static function getButtonEdit()
    {
        return View::render('srv/modules/configuracao/botoes/editar');
    }
    /**
     * Renderiza o conteúdo da pagina de configurações
     * @param Request $request
     * @return string
     */
    public static function getConfig()
    {
        $idApp = $_SESSION['admin']['customer']['idUser'];

        $app = EntityApp::getAppById($idApp);


        if ($app instanceof EntityApp) {
            $content = View::render('srv/modules/configuracao/index', [
                'botoes'       => self::getButtonEdit(),
                'h1'           => 'Atualize ou delete seu dados aqui',
                'method'       => 'configuracao/update',
                'nomeFantasia' => $app->nomeFantasia,
                'tipo'         => $app->tipo,
                'segmento'     => $app->segmento,
                'email'        => $app->email,
                'telefone'     => $app->telefone,
                'celular'      => $app->celular,
                'cep'          => $app->cep,
                'logradouro'   => $app->logradouro,
                'numero'       => $app->numero,
                'bairro'       => $app->bairro,
                'localidade'   => $app->localidade,
                'adicionais'   => $app->adicionais,
                'chaves'       => $app->chaves,

            ]);
        } else {
            $content = View::render('srv/modules/configuracao/index', [
                'botoes'       => self::getButtonRegister(),
                'h1'           => 'Configurações',
                'method'       => 'configuracao/insert',
                'nomeFantasia' => '',
                'tipo'         => '',
                'segmento'     => 'Selecione um segmento',
                'email'        => '',
                'telefone'     => '',
                'celular'      => '',
                'cep'          => '',
                'logradouro'   => '',
                'numero'       => '',
                'bairro'       => '',
                'localidade'   => '',
                'adicionais'   => '',
                'chaves'       => '',

                
            ]);
        }

        return parent::getPanel('Configuração - SRV', $content, 'configuracao');
    }

    /**
     * Metódo responsável por inserir as configuraçôes do App
     *
     * @param Requaest $request
     * @return Method
     */
    public static function postConfig($request)
    {

        //Recebe as variaveis POST
        $postVars = $request->getPostVars();

        $idCustomer = $_SESSION['admin']['customer']['idUser'];


        $objApp= EntityApp::getAppById($idCustomer);

        if (!$objApp instanceof EntityApp){

            $objApp = new EntityApp();
        }
       
        $objApp->idApp        = $idCustomer;
        $objApp->nomeFantasia = $postVars['nomeFantasia'] ? $postVars['nomeFantasia']: $objApp->nomeFantasia;
        $objApp->tipo         = $postVars['tipo']         ? $postVars['tipo']        : $objApp->tipo;
        $objApp->segmento     = $postVars['segmento']     ? $postVars['segmento']    : $objApp->segmento;
        $objApp->email        = $postVars['email']        ? $postVars['email']       : $objApp->email;
        $objApp->telefone     = $postVars['telefone']     ? $postVars['telefone']    : $objApp->telefone;
        $objApp->celular      = $postVars['celular']      ? $postVars['celular']     : $objApp->celular;
        $objApp->cep          = $postVars['cep']          ? $postVars['cep']         : $objApp->cep;
        $objApp->logradouro   = $postVars['logradouro']   ? $postVars['logradouro']  : $objApp->logradouro;
        $objApp->numero       = $postVars['numero']       ? $postVars['numero']      : $objApp->numero;
        $objApp->bairro       = $postVars['bairro']       ? $postVars['bairro']      : $objApp->bairro;
        $objApp->localidade   = $postVars['localidade']   ? $postVars['localidade']  : $objApp->localidade;
        $objApp->adicionais   = $postVars['adicionais']   ? $postVars['adicionais']  : $objApp->adicionais;
        $objApp->chaves       = $postVars['chaves']       ? $postVars['chaves']      : $objApp->chaves;

        $action  = $postVars['action'];
        
    
        if($action === 'insert'){

            $objApp->insertNewApp();

            switch ($objApp->segmento) {
                case 'hospedagem':
                   self::createHospedagem($idCustomer);
                    break;
                
                default:
                    # code...
                    break;
            }
        }
        if($action === 'update'){

            $objApp->updateApp();
        }
        if($action === 'delete'){

            $objApp->deleteApp();

            switch ($objApp->segmento) {
                case 'hospedagem':
                    EntityHospedagem::deleteHospedagem($idCustomer);
                    break;
                
                default:
                    # code...
                    break;
            }

        }
    

        return self::getConfig();

    }

    /**
     * Metódo responsável por criar uma nova hospedagem
     *
     * @param [type] $idCustomer
     * @return void
     */
    private static function createHospedagem($idCustomer){

        $objHospegagem = new EntityHospedagem();

         $objHospegagem->idApp = $idCustomer;
         $objHospegagem->estacionamento = -1;
         $objHospegagem->briquedos = -1;
         $objHospegagem->restaurante = -1;
         $objHospegagem->arCondicionado = -1;
         $objHospegagem->wiFi = -1;
         $objHospegagem->academia = -1;
         $objHospegagem->piscina = -1;
         $objHospegagem->refeicao = -1;
         $objHospegagem->emporio = -1;
         $objHospegagem->adega = -1;
         $objHospegagem->bebidas = -1;
         $objHospegagem->sorveteria = -1;
         $objHospegagem->whatsapp = -1;
         $objHospegagem->semana = '00:00 às 00:00';
         $objHospegagem->sabado = '00:00 às 00:00';
         $objHospegagem->domigo = '00:00 às 00:00';
         $objHospegagem->feriado = '00:00 às 00:00';
         $objHospegagem->img2 = '';
         $objHospegagem->img3 = '';
         $objHospegagem->descricao = ''; 
         $objHospegagem->insertNewHospedagem();
        
    }

    public static function cep($request)
    {

        $postVars = $request->getPostVars();

        $query = new Address();
        $addressQuery = $query->getAddressFromZipCode($postVars['cep']);
        $localidade = $addressQuery['localidade'];

        if ($localidade == 'São Roque') {

            $arrResponse = [
                "retorno" => 'success',
                "inputs"  => $addressQuery,
            ];
        } else {
            $arrResponse = [
                "retorno" => 'erro',
                "erros"   => 'cep invalido'
            ];
        }
        return json_encode($arrResponse);
    }

}
