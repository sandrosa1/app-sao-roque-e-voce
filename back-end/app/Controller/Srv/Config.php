<?php

namespace App\Controller\Srv;

use \SandroAmancio\Search\Address;
use \App\Model\Entity\Aplication\App as EntityApp;
use \App\Model\Entity\Aplication\Hospedagem\Hospedagem as EntityHospedagem;
use \App\Model\Entity\Aplication\Comercio\Comercio as EntityComercio;
use \App\Model\Entity\Aplication\Evento\Evento as EntityEvento;
use \App\Model\Entity\Aplication\Servico\Servico as EntityServico;
use \App\Model\Entity\Aplication\Gastronomia\Gastronomia as EntityGastronomia;
use \App\Validate\Validate;


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
                'customer'     => $app->idApp

            ]);
        } else {
            $content = View::render('srv/modules/configuracao/index', [
                'botoes'       => self::getButtonRegister(),
                'h1'           => 'Configurações',
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

        //Capta o id do cliente pela sessaõ
        $idCustomer = $_SESSION['admin']['customer']['idUser'];

        //Procura se a uma Instacia de App para esse cliente
        $objApp = EntityApp::getAppById($idCustomer);

        //Se nãoo tiver estância, cria uma
        if (!$objApp instanceof EntityApp){

            $objApp = new EntityApp();
        }
        //Array de campos obrigatorios
        $campos = [];
        //Criando o APP ou Atualizando APP
        $objApp->idApp        = $idCustomer;

        $campos[0] = $objApp->nomeFantasia = $postVars['nomeFantasia'] ? $postVars['nomeFantasia']: $objApp->nomeFantasia;
        $campos[1] = $objApp->tipo         = $postVars['tipo']         ? $postVars['tipo']        : $objApp->tipo;
        $campos[2] = $objApp->segmento     = $postVars['segmento']     ? $postVars['segmento']    : $objApp->segmento;
        $campos[3] = $objApp->email        = $postVars['email']        ? $postVars['email']       : $objApp->email;
        $campos[4] = $objApp->celular      = $postVars['celular']      ? $postVars['celular']     : $objApp->celular;
        $campos[5] = $objApp->cep          = $postVars['cep']          ? $postVars['cep']         : $objApp->cep;
        $campos[6] = $objApp->logradouro   = $postVars['logradouro']   ? $postVars['logradouro']  : $objApp->logradouro;
        $campos[7] = $objApp->numero       = $postVars['numero']       ? $postVars['numero']      : $objApp->numero;
        $campos[8] = $objApp->bairro       = $postVars['bairro']       ? $postVars['bairro']      : $objApp->bairro;
        $campos[9] = $objApp->localidade   = $postVars['localidade']   ? $postVars['localidade']  : $objApp->localidade;
        $objApp->telefone                  = $postVars['telefone']     ? $postVars['telefone']    : $objApp->telefone;
        $objApp->adicionais                = $postVars['adicionais']   ? $postVars['adicionais']  : $objApp->adicionais;
        $objApp->chaves                    = $postVars['chaves']       ? $postVars['chaves']      : $objApp->chaves;
        $action                            = $postVars['action'];
        $captcha                           = $postVars['g-recaptcha-response'];


        //Classe de validação
        $validate = new Validate();
        $validate->validateFields($campos);
        //$validate->validateCaptcha($captcha);
        $validate->validateEmail($objApp->email);
        $validate->validadeCep($objApp->cep);
        $validate->validadeCelular($objApp->celular);
        //$validate->validadeTelefone($objApp->telefone);

        if(count($validate->getErro()) > 0){

            $arrResponse = [
                "retorno" => 'erro',
                "erros"   => $validate->getErro()
            ];

        }else{

          
            $mensagem = [];

            if($action === 'insert'){

                $objApp->insertNewApp();
                $mensagem = ["Configuração inseridas com sucesso", "Clique em detalhes no menu lateral para prosseguir"];
               
                switch ($objApp->segmento) {
                    case 'hospedagem':
                    self::createHospedagem($idCustomer);
                        break;
                    case 'evento':
                        self::createEvento($idCustomer);
                            break;
                    case 'comercio':
                        self::createComercio($idCustomer);
                            break;
                    case 'servico':
                        self::createServico($idCustomer);
                            break;
                    case 'gastronomia':
                        self::createGastronomia($idCustomer);
                            break;
                }

            }
            if($action === 'update'){

                $objApp->updateApp();
                $mensagem = ['Informaçẽs atualizadas com sucesso.'];
            }
        
            $arrResponse=[
                "retorno" => "success",
                "page"    => "srv/configuracao",
                "success" => $mensagem
            ];   

        }

        echo json_encode($arrResponse);
    }

   
    public static function configDelete($request){

        $postVars = $request->getQueryParams();

        $delete = $postVars['delete'];
        $segmento = $postVars['segmento'];

        $idApp = $_SESSION['admin']['customer']['idUser'];

        $objApp = EntityApp::getAppById($delete);

       

        // //Se nãoo tiver estância, cria uma
        if (!$objApp instanceof EntityApp){

           
        }else{

            if($delete == $idApp){

               EntityApp::deleteApp($idApp);
                switch ($segmento) {
                    case 'hospedagem':
                       EntityHospedagem::deleteHospedagem($idApp);
                        break;
                    case 'evento':
                        EntityEvento::deleteEvento($idApp);
                            break;
                    case 'comercio':
                        EntityComercio::deleteComercio($idApp);
                            break;
                            
                    case 'gastronomia':
                        EntityGastronomia::deleteGastronomia($idApp);
                            break;
                    case 'servico':
                        EntityServico::deleteServico($idApp);
                            break;
                    default:
                        # code...
                        break;
                }

            }
           
           $request->getRouter()->redirect('/srv/home');
        }

        
        
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
    /**
     * Metódo responsável por criar um novo Evento
     *
     * @param [type] $idCustomer
     * @return void
     */
    private static function createEvento($idCustomer){
        $objEvento = new EntityEvento();

        $objEvento->idApp = $idCustomer;
        $objEvento->estacionamento = -1;
        $objEvento->acessibilidade = -1;
        $objEvento->wiFi = -1;
        $objEvento->trilhas = -1;
        $objEvento->refeicao = -1;
        $objEvento->emporio = -1;
        $objEvento->adega = -1;
        $objEvento->bebidas = -1;
        $objEvento->sorveteria = -1;
        $objEvento->musica = -1;
        $objEvento->whatsapp = -1;
        $objEvento->semana = '00:00 às 00:00';
        $objEvento->sabado = '00:00 às 00:00';
        $objEvento->domigo = '00:00 às 00:00';
        $objEvento->feriado = '00:00 às 00:00';
        $objEvento->img2 = '';
        $objEvento->img3 = '';
        $objEvento->descricao = ''; 
        $objEvento->insertNewEvento();
    }
    /**
     * Metódo responsável por criar um novo Serviço
     *
     * @param [type] $idCustomer
     * @return void
     */
    private static function createServico($idCustomer){

        $objServico = new EntityServico();

        $objServico->idApp = $idCustomer;
        $objServico->estacionamento = -1;
        $objServico->acessibilidade = -1;
        $objServico->entregaDomicilio = -1;
        $objServico->whatsapp = -1;
        $objServico->semana = '00:00 às 00:00';
        $objServico->sabado = '00:00 às 00:00';
        $objServico->domigo = '00:00 às 00:00';
        $objServico->feriado = '00:00 às 00:00';
        $objServico->logo = '';
        $objServico->img2 = '';
        $objServico->img3 = '';
        $objServico->descricao = ''; 
        $objServico->insertNewServico();
    }
    /**
     * Metódo responsável por criar uma nova opção gastronomica
     *
     * @param [type] $idCustomer
     * @return void
     */
    private static function createGastronomia($idCustomer){

        $objGastronomia = new EntityGastronomia();

        $objGastronomia->idApp = $idCustomer;
        $objGastronomia->estacionamento = -1;
        $objGastronomia->acessibilidade = -1;
        $objGastronomia->wiFi = -1;
        $objGastronomia->briquedos = -1;
        $objGastronomia->restaurante = -1;
        $objGastronomia->emporio = -1;
        $objGastronomia->adega = -1;
        $objGastronomia->bebidas = -1;
        $objGastronomia->sorveteria = -1;
        $objGastronomia->entregaDomicilio = -1;
        $objGastronomia->semana = '00:00 às 00:00';
        $objGastronomia->sabado = '00:00 às 00:00';
        $objGastronomia->domigo = '00:00 às 00:00';
        $objGastronomia->feriado = '00:00 às 00:00';
        $objGastronomia->img2 = '';
        $objGastronomia->img3 = '';
        $objGastronomia->descricao = ''; 
        $objGastronomia->insertNewGastronomia();
    }
    /**
     * Metódo responsável por criar um novo Comércio
     *
     * @param [type] $idCustomer
     * @return void
     */
    private static function createComercio($idCustomer){

        $objComercio = new EntityComercio();

        $objComercio->idApp = $idCustomer;
        $objComercio->estacionamento = -1;
        $objComercio->acessibilidade = -1;
        $objComercio->entregaDomicilio = -1;
        $objComercio->whatsapp = -1;
        $objComercio->semana = '00:00 às 00:00';
        $objComercio->sabado = '00:00 às 00:00';
        $objComercio->domigo = '00:00 às 00:00';
        $objComercio->feriado = '00:00 às 00:00';
        $objComercio->img2 = '';
        $objComercio->img3 = '';
        $objComercio->descricao = ''; 
        $objComercio->insertNewComercio();
    }


}
