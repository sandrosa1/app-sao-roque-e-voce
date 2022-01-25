<?php

namespace App\Controller\Srv;

use \SandroAmancio\Search\Address;
use \App\Help\Help;
use \App\Model\Entity\Aplication\App as EntityApp;
use \App\Model\Entity\Aplication\Hospedagem\Hospedagem as EntityHospedagem;
use \App\Model\Entity\Aplication\Comercio\Comercio as EntityComercio;
use \App\Model\Entity\Aplication\Evento\Evento as EntityEvento;
use \App\Model\Entity\Aplication\Servico\Servico as EntityServico;
use \App\Model\Entity\Aplication\Gastronomia\Gastronomia as EntityGastronomia;
use \App\Validate\Validate;


use \App\Utils\View;
use JetBrains\PhpStorm\Deprecated;

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
        //Classe de validação
        $validate = new Validate();

        //Procura se a uma Instacia de App para esse cliente
        $objApp = EntityApp::getAppById($idCustomer);

        //Se nãoo tiver estância, cria uma
        if (!$objApp instanceof EntityApp){

            $objApp = new EntityApp();
        }

        if($objApp->segmento != $postVars['segmento']){

            $validate->setErro('Exclua o anúncio para mudar de segmento');
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
        $objApp->telefone                  = $postVars['telefone']     ? $postVars['telefone']    : '';
        $objApp->adicionais                = $postVars['adicionais']   ? $postVars['adicionais']  : $objApp->adicionais;
        $objApp->chaves                    = $postVars['chaves']       ? $postVars['chaves']      : $objApp->chaves;
        $action                            = $postVars['action'];
        $captcha                           = $postVars['g-recaptcha-response'];


        
        $validate->validateFields($campos);
        $validate->validateCaptcha($captcha);
        $validate->validateEmail($objApp->email);
        $validate->validadeCep($objApp->cep);
        $validate->validadeCelular($objApp->celular);
       if($objApp->telefone ){
            $validate->validadeTelefone($objApp->telefone);
       }
        $words = Help::helpTextForArray($postVars['chaves']);
        $validate->validateBlockedWord($words);

    

        if(count($validate->getErro()) > 0){

            $arrResponse = [
                "retorno" => 'erro',
                "erros"   => $validate->getErro()
            ];

        }else{

          
            $mensagem = [];

            if($action === 'insert'){

                $objApp->insertNewApp();
                $mensagem = ["Configurações inseridas com sucesso", "Clique em detalhes no menu lateral para prosseguir"];
               
                switch ($objApp->segmento) {
                    case 'hospedagem':
                    self::createHospedagem($idCustomer,  $postVars);
                        break;
                    case 'evento':
                        self::createEvento($idCustomer,  $postVars);
                            break;
                    case 'comercio':
                        self::createComercio($idCustomer,  $postVars);
                            break;
                    case 'servico':
                        self::createServico($idCustomer,  $postVars);
                            break;
                    case 'gastronomia':
                        self::createGastronomia($idCustomer,  $postVars);
                            break;
                }

            }
            if($action === 'update'){

                $objApp->updateApp();
                $mensagem = ['Informações atualizadas com sucesso.'];
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
    public static function createHospedagem($idApp,  $postVars){

      
        $objHospedagem = EntityHospedagem::getHospedagemById($idApp);

       

        $objHospedagem->idApp            = $idApp;
        $objHospedagem->idAppHospedagem  = $objHospedagem->idAppHospedagem;
        $objHospedagem->estacionamento   = $postVars['estacionamento'] ? -2 : -1;
        $objHospedagem->brinquedos        = $postVars['brinquedos']      ? -2 : -1;
        $objHospedagem->restaurante      = $postVars['restaurante']    ? -2 : -1;
        $objHospedagem->arCondicionado   = $postVars['arCondicionado'] ? -2 : -1;
        $objHospedagem->wiFi             = $postVars['wiFi']           ? -2 : -1;
        $objHospedagem->academia         = $postVars['academia']       ? -2 : -1;
        $objHospedagem->piscina          = $postVars['piscina']        ? -2 : -1;
        $objHospedagem->refeicao         = $postVars['refeicao']       ? -2 : -1;
        $objHospedagem->emporio          = $postVars['emporio']        ? -2 : -1;
        $objHospedagem->adega            = $postVars['adega']          ? -2 : -1;
        $objHospedagem->bebidas          = $postVars['bebidas']        ? -2 : -1;
        $objHospedagem->sorveteria       = $postVars['sorveteria']     ? -2 : -1;
        $objHospedagem->whatsapp         = $postVars['whatsapp']       ? -2 : -1;
        $objHospedagem->semana           = !$postVars['semana']  || $postVars['semana']   == '00:00 - 00:00'  ? 'Fechado' : $postVars['semana'];
        $objHospedagem->sabado           = !$postVars['sabado']  || $postVars['sabado']   == '00:00 - 00:00'  ? 'Fechado' : $postVars['sabado'];
        $objHospedagem->domingo           = !$postVars['domingo']  || $postVars['domingo']   == '00:00 - 00:00'  ? 'Fechado' : $postVars['domingo'];
        $objHospedagem->feriado          = !$postVars['feriado'] || $postVars['feriado']  == '00:00 - 00:00'  ? 'Fechado' : $postVars['feriado'];
        $objHospedagem->img2             = $postVars['img2']           ? $postVars['img2']           : '';
        $objHospedagem->img3             = $postVars['img3']           ? $postVars['img3']           : '';
        $objHospedagem->descricao        = $postVars['descricao']      ? $postVars['descricao']      : ''; 

        if($postVars['action'] == 'atualizar' ){

            $objHospedagem->updateHospedagem();
            
        }else{
            
            $objHospedagem->insertNewHospedagem();
        
        }

        return true;
        
    }
    /**
     * Metódo responsável por criar um novo Evento
     *
     * @param [type] $idApp
     * @return void
     */
    public static function createEvento($idApp,  $postVars){
        $objEvento = new EntityEvento();

        $objEvento->idApp          = $idApp;
        $objEvento->estacionamento = $postVars['estacionamento'] ? $postVars['estacionamento'] : -1;
        $objEvento->acessibilidade = $postVars['acessibilidade'] ? $postVars['acessibilidade'] : -1;
        $objEvento->wiFi           = $postVars['wiFi']           ? $postVars['wiFi']           : -1;
        $objEvento->trilhas        = $postVars['trilhas']        ? $postVars['trilhas']        : -1;
        $objEvento->refeicao       = $postVars['refeicao']       ? $postVars['refeicao']       : -1;
        $objEvento->emporio        = $postVars['emporio']        ? $postVars['emporio']        : -1;
        $objEvento->adega          = $postVars['adega']          ? $postVars['adega']          : -1;
        $objEvento->bebidas        = $postVars['bebidas']        ? $postVars['bebidas']        : -1;
        $objEvento->sorveteria     = $postVars['sorveteria']     ? $postVars['sorveteria']     : -1;
        $objEvento->musica         = $postVars['musica']         ? $postVars['musica']         : -1;
        $objEvento->whatsapp       = $postVars['whatsapp']       ? $postVars['whatsapp']       : -1;
        $objEvento->semana         = $postVars['semana']         ? $postVars['semana']         : '00:00 às 00:00';
        $objEvento->sabado         = $postVars['sabado']         ? $postVars['sabado']         : '00:00 às 00:00';
        $objEvento->domingo         = $postVars['domingo']         ? $postVars['domingo']         : '00:00 às 00:00';
        $objEvento->feriado        = $postVars['feriado']        ? $postVars['feriado']        : '00:00 às 00:00';
        $objEvento->img2           = $postVars['img2']           ? $postVars['img2']           : '';
        $objEvento->img3           = $postVars['img3']           ? $postVars['img3']           : '';
        $objEvento->descricao      = $postVars['descricao']      ? $postVars['descricao']      : ''; 

        if($postVars['action'] == 'atualizar' ){
          
            
        }else{
            $objEvento->insertNewEvento();
        }
    }
    /**
     * Metódo responsável por criar um novo Serviço
     *
     * @param [type] $idApp
     * @return void
     */
    public static function createServico($idApp,  $postVars){

        $objServico = new EntityServico();

        $objServico->idApp                = $idApp;
        $objServico->estacionamento       = $postVars['estacionamento']   ? $postVars['estacionamento']   : -1;
        $objServico->acessibilidade       = $postVars['acessibilidade']   ? $postVars['acessibilidade']   : -1;
        $objServico->entregaDomicilio     = $postVars['entregaDomicilio'] ? $postVars['entregaDomicilio'] : -1;
        $objServico->whatsapp             = $postVars['whatsapp']         ? $postVars['whatsapp']         : -1;
        $objServico->semana               = $postVars['semana']           ? $postVars['semana']           : '00:00 às 00:00';
        $objServico->sabado               = $postVars['sabado']           ? $postVars['sabado']           : '00:00 às 00:00';
        $objServico->domingo               = $postVars['domingo']           ? $postVars['domingo']           : '00:00 às 00:00';
        $objServico->feriado              = $postVars['feriado']          ? $postVars['feriado']          : '00:00 às 00:00';
        $objServico->logo                 = $postVars['logo']             ? $postVars['logo']             : '';
        $objServico->img2                 = $postVars['img2']             ? $postVars['img2']             : '';
        $objServico->img3                 = $postVars['img3']             ? $postVars['img3']             : '';
        $objServico->descricao            = $postVars['descricao']        ? $postVars['descricao']        : ''; 

        if($postVars['action'] == 'atualizar' ){
          
            
        }else{
            $objServico->insertNewServico();
        }
    }
    /**
     * Metódo responsável por criar uma nova opção gastronomica
     *
     * @param [type] $idApp
     * @return void
     */
    public static function createGastronomia($idApp,  $postVars){

        $objGastronomia = new EntityGastronomia();

        $objGastronomia->idApp             = $idApp;
        $objGastronomia->estacionamento    = $postVars['estacionamento']   ? $postVars['estacionamento']   : -1;
        $objGastronomia->acessibilidade    = $postVars['acessibilidade']   ? $postVars['acessibilidade']   : -1;
        $objGastronomia->wiFi              = $postVars['wiFi']             ? $postVars['wiFi']             : -1;
        $objGastronomia->brinquedos         = $postVars['brinquedos']        ? $postVars['brinquedos']        : -1;
        $objGastronomia->restaurante       = $postVars['restaurante']      ? $postVars['restaurante']      : -1;
        $objGastronomia->emporio           = $postVars['emporio']          ? $postVars['emporio']          : -1;
        $objGastronomia->adega             = $postVars['adega']            ? $postVars['adega']            : -1;
        $objGastronomia->bebidas           = $postVars['bebidas']          ? $postVars['bebidas']          : -1;
        $objGastronomia->sorveteria        = $postVars['sorveteria']       ? $postVars['sorveteria']       : -1;
        $objGastronomia->entregaDomicilio  = $postVars['entregaDomicilio'] ? $postVars['entregaDomicilio'] : -1;
        $objGastronomia->whatsapp          = $postVars['whatsapp']         ? $postVars['whatsapp']         : -1;
        $objGastronomia->semana            = $postVars['semana']           ? $postVars['semana']           : '00:00 às 00:00';
        $objGastronomia->sabado            = $postVars['sabado']           ? $postVars['sabado']           : '00:00 às 00:00';
        $objGastronomia->domingo            = $postVars['domingo']           ? $postVars['domingo']           : '00:00 às 00:00';
        $objGastronomia->feriado           = $postVars['feriado']          ? $postVars['feriado']          : '00:00 às 00:00';
        $objGastronomia->img2              = $postVars['img2']             ? $postVars['img2']             : '';
        $objGastronomia->img3              = $postVars['img3']             ? $postVars['img3']             : '';
        $objGastronomia->descricao         = $postVars['descricao']       ? $postVars['descricao']         : ''; 

        if($postVars['action'] == 'atualizar' ){
          
            
        }else{
            $objGastronomia->insertNewGastronomia();

        }
        
        
    }
    /**
     * Metódo responsável por criar um novo Comércio
     *
     * @param [type] $idCustomer
     * @return void
     */
    public static function createComercio($idCustomer,  $postVars){

        $objComercio = new EntityComercio();

        $objComercio->idApp = $idCustomer;
        $objComercio->estacionamento   = $postVars['estacionamento']   ? $postVars['estacionamento']   : -1;
        $objComercio->acessibilidade   = $postVars['acessibilidade']   ? $postVars['acessibilidade']   : -1;
        $objComercio->entregaDomicilio = $postVars['entregaDomicilio'] ? $postVars['entregaDomicilio'] : -1;
        $objComercio->whatsapp         = $postVars['whatsapp']         ? $postVars['whatsapp']         : -1;
        $objComercio->semana           = $postVars['semana']           ? $postVars['semana']           : '00:00 às 00:00';
        $objComercio->sabado           = $postVars['sabado']           ? $postVars['sabado']           : '00:00 às 00:00';
        $objComercio->domingo           = $postVars['domingo']           ? $postVars['domingo']           : '00:00 às 00:00';
        $objComercio->feriado          = $postVars['feriado']          ? $postVars['feriado']          : '00:00 às 00:00';
        $objComercio->img2             = $postVars['img2']             ? $postVars['img2']             : '';
        $objComercio->img3             = $postVars['img3']             ? $postVars['img3']             : '';
        $objComercio->descricao        = $postVars['descricao']        ? $postVars['descricao']        : '';

        if($postVars['action'] == 'atualizar' ){
          
            
        }else{ 
            $objComercio->insertNewComercio();
    
        }
    }

}
