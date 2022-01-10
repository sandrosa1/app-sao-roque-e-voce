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
        $id_app = $_SESSION['admin']['customer']['idUser'];

        $app = EntityApp::getAppById($id_app);


        if ($app instanceof EntityApp) {
            $content = View::render('srv/modules/configuracao/index', [
                'botoes' => self::getButtonEdit(),
                'h1'     => 'Atualize ou delete seu dados aqui',
                'method'     => 'update',
            ]);
        } else {
            $content = View::render('srv/modules/configuracao/index', [
                'botoes' => self::getButtonRegister(),
                'h1'     => 'Configurações',
                'method'     => 'post',

                
            ]);
        }

        return parent::getPanel('Configuração - SRV', $content, 'configuracao');
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

    public static function postConfig($request)
    {

        //Recebe as variaveis POST
        $postVars = $request->getPostVars();


        

        $id_customer = $_SESSION['admin']['customer']['idUser'];
       
        $objApp = new EntityApp();
       

        $objApp->id_app       = $id_customer;
        $objApp->nomeFantasia = $postVars['nomeFantasia'];
        $objApp->tipo         = $postVars['tipo'];
        $objApp->segmento     = $postVars['segmento'];
        $objApp->email        = $postVars['email'];
        $objApp->telefone     = $postVars['telefone'];
        $objApp->celular      = $postVars['celular'];
        $objApp->cep          = $postVars['cep'];
        $objApp->logradouro   = $postVars['logradouro'];
        $objApp->numero       = $postVars['numero'];
        $objApp->bairro       = $postVars['bairro'];
        $objApp->localidade   = $postVars['localidade'];
        $objApp->complementos = $postVars['complementos'];
        $objApp->chaves       = $postVars['chaves'];



        // $objApp->insertNewApp();

        // switch ($objApp->segmento) {
        //     case 'hospedagem':
        //        self::createHospedagem($id_customer);
        //         break;
            
        //     default:
        //         # code...
        //         break;
        // }

       

        return self::getConfig();

    }

    /**
     * Metódo responsável por criar uma nova hospedagem
     *
     * @param [type] $id_customer
     * @return void
     */
    private static function createHospedagem($id_customer){

        $objHospegagem = new EntityHospedagem();

         $objHospegagem->id_app = $id_customer;
         $objHospegagem->estacionamento = -1 ; 
         $objHospegagem->briquedos = -1 ;
         $objHospegagem->restaurante = -1 ;
         $objHospegagem->ar_condicionado = -1 ;
         $objHospegagem->wi_fi = -1 ;
         $objHospegagem->academia = -1 ;
         $objHospegagem->piscina = -1 ;
         $objHospegagem->refeicao = -1 ;
         $objHospegagem->emporio = -1 ;
         $objHospegagem->adega = -1 ;
         $objHospegagem->bebidas = -1 ;
         $objHospegagem->sorveteria = -1 ;
         $objHospegagem->whatsapp = -1 ;
         $objHospegagem->semana = '00:00 às 00:00';
         $objHospegagem->sabado = '00:00 às 00:00';
         $objHospegagem->domigo = '00:00 às 00:00';
         $objHospegagem->feriado = '00:00 às 00:00';
         $objHospegagem->logo = '';
         $objHospegagem->img2 = '';
         $objHospegagem->img3 = '';
         $objHospegagem->descricao = ''; 
         $objHospegagem->insertNewHospedagem();
        
    }

}
