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

        if($objApp->segmento != '' && $objApp->segmento != $postVars['segmento']){

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
       // $validate->validateCaptcha($captcha);
        $validate->validateEmail($objApp->email);
        $validate->validadeCep($objApp->cep);
        $validate->validadeCelular($objApp->celular);
        $validate->validateIssetAppFields( $objApp->idApp, $objApp->email,$objApp->celular,$objApp->telefone);
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
                    case 'servicos':
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
                    case 'servicos':
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

        if (!$objHospedagem instanceof EntityHospedagem){
       
            $objHospedagem = new EntityHospedagem();

        }
        

        $objHospedagem->idApp            = $idApp;
        $objHospedagem->idAppHospedagem  = $objHospedagem->idAppHospedagem;
        $objHospedagem->semana           = !$postVars['semana']  || $postVars['semana']   == '00:00 - 00:00'  ? 'Fechado' : $postVars['semana'];
        $objHospedagem->sabado           = !$postVars['sabado']  || $postVars['sabado']   == '00:00 - 00:00'  ? 'Fechado' : $postVars['sabado'];
        $objHospedagem->domingo          = !$postVars['domingo'] || $postVars['domingo']  == '00:00 - 00:00'  ? 'Fechado' : $postVars['domingo'];
        $objHospedagem->feriado          = !$postVars['feriado'] || $postVars['feriado']  == '00:00 - 00:00'  ? 'Fechado' : $postVars['feriado'];
        $objHospedagem->estacionamento   = $postVars['estacionamento'] ? -2 : -1;
        $objHospedagem->brinquedos       = $postVars['brinquedos']     ? -2 : -1;
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
     * Metódo responsável por criar uma nova opção gastronomica
     *
     * @param [type] $idApp
     * @return void
     */
    public static function createGastronomia($idApp,  $postVars){

        $objGastronomia = EntityGastronomia::getGastronomiaById($idApp);

        if (!$objGastronomia instanceof EntityGastronomia){
       
            $objGastronomia = new EntityGastronomia();

        }


        $objGastronomia->idApp             = $idApp;
        $objGastronomia->idAppGastronomia  = $objGastronomia->idAppGastronomia;
        $objGastronomia->semana            = !$postVars['semana']  || $postVars['semana']   == '00:00 - 00:00'  ? 'Fechado' : $postVars['semana'];
        $objGastronomia->sabado            = !$postVars['sabado']  || $postVars['sabado']   == '00:00 - 00:00'  ? 'Fechado' : $postVars['sabado'];
        $objGastronomia->domingo           = !$postVars['domingo'] || $postVars['domingo']  == '00:00 - 00:00'  ? 'Fechado' : $postVars['domingo'];
        $objGastronomia->feriado           = !$postVars['feriado'] || $postVars['feriado']  == '00:00 - 00:00'  ? 'Fechado' : $postVars['feriado'];
        $objGastronomia->estacionamento    = $postVars['estacionamento']   ? -2 : -1;
        $objGastronomia->acessibilidade    = $postVars['acessibilidade']   ? -2 : -1;
        $objGastronomia->wiFi              = $postVars['wiFi']             ? -2 : -1;
        $objGastronomia->brinquedos        = $postVars['brinquedos']       ? -2 : -1;
        $objGastronomia->restaurante       = $postVars['restaurante']      ? -2 : -1;
        $objGastronomia->emporio           = $postVars['emporio']          ? -2 : -1;
        $objGastronomia->adega             = $postVars['adega']            ? -2 : -1;
        $objGastronomia->bebidas           = $postVars['bebidas']          ? -2 : -1;
        $objGastronomia->sorveteria        = $postVars['sorveteria']       ? -2 : -1;
        $objGastronomia->entregaDomicilio  = $postVars['entregaDomicilio'] ? -2 : -1;
        $objGastronomia->whatsapp          = $postVars['whatsapp']         ? -2 : -1;
        $objGastronomia->img2              = $postVars['img2']             ? $postVars['img2']             : '';
        $objGastronomia->img3              = $postVars['img3']             ? $postVars['img3']             : '';
        $objGastronomia->descricao         = $postVars['descricao']        ? $postVars['descricao']        : ''; 

        if($postVars['action'] == 'atualizar' ){
          $objGastronomia->updateGastronomia();
            
        }else{
            $objGastronomia->insertNewGastronomia();

        }
        
        
    }
    /**
     * Metódo responsável por criar um novo Evento
     *
     * @param [type] $idApp
     * @return void
     */
    public static function createEvento($idApp,  $postVars){

        $objEvento = EntityEvento::getEventoById($idApp);

        if (!$objEvento instanceof EntityEvento){
            $objEvento = new EntityEvento();

        }

        $objEvento->idApp          = $idApp;
        $objEvento->idEvento       = $objEvento->idEvento;
        $objEvento->semana         = !$postVars['semana']  || $postVars['semana']   == '00:00 - 00:00'  ? 'Fechado' : $postVars['semana'];
        $objEvento->sabado         = !$postVars['sabado']  || $postVars['sabado']   == '00:00 - 00:00'  ? 'Fechado' : $postVars['sabado'];
        $objEvento->domingo        = !$postVars['domingo'] || $postVars['domingo']  == '00:00 - 00:00'  ? 'Fechado' : $postVars['domingo'];
        $objEvento->feriado        = !$postVars['feriado'] || $postVars['feriado']  == '00:00 - 00:00'  ? 'Fechado' : $postVars['feriado'];
        $objEvento->estacionamento = $postVars['estacionamento'] ? -2 : -1;
        $objEvento->acessibilidade = $postVars['acessibilidade'] ? -2 : -1;
        $objEvento->wiFi           = $postVars['wiFi']           ? -2 : -1;
        $objEvento->trilhas        = $postVars['trilhas']        ? -2 : -1;
        $objEvento->refeicao       = $postVars['refeicao']       ? -2 : -1;
        $objEvento->emporio        = $postVars['emporio']        ? -2 : -1;
        $objEvento->adega          = $postVars['adega']          ? -2 : -1;
        $objEvento->bebidas        = $postVars['bebidas']        ? -2 : -1;
        $objEvento->sorveteria     = $postVars['sorveteria']     ? -2 : -1;
        $objEvento->musica         = $postVars['musica']         ? -2 : -1;
        $objEvento->whatsapp       = $postVars['whatsapp']       ? -2 : -1;
        $objEvento->img2           = $postVars['img2']           ? $postVars['img2']           : '';
        $objEvento->img3           = $postVars['img3']           ? $postVars['img3']           : '';
        $objEvento->descricao      = $postVars['descricao']      ? $postVars['descricao']      : ''; 

        if($postVars['action'] == 'atualizar' ){
            $objEvento->updateEvento();

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

        $objServico = EntityServico::getServicoById($idApp);
        
         if (!$objServico instanceof EntityServico){
            $objServico = new EntityServico();

        }
        
        $objServico->idApp                = $idApp;
        $objServico->idAppServico         = $objServico->idAppServico;
        $objServico->semana               = !$postVars['semana']  || $postVars['semana']   == '00:00 - 00:00'  ? 'Fechado' : $postVars['semana'];
        $objServico->sabado               = !$postVars['sabado']  || $postVars['sabado']   == '00:00 - 00:00'  ? 'Fechado' : $postVars['sabado'];
        $objServico->domingo              = !$postVars['domingo'] || $postVars['domingo']  == '00:00 - 00:00'  ? 'Fechado' : $postVars['domingo'];
        $objServico->feriado              = !$postVars['feriado'] || $postVars['feriado']  == '00:00 - 00:00'  ? 'Fechado' : $postVars['feriado'];
        $objServico->estacionamento       = $postVars['estacionamento']   ? -2 : -1;
        $objServico->acessibilidade       = $postVars['acessibilidade']   ? -2 : -1;
        $objServico->entregaDomicilio     = $postVars['entregaDomicilio'] ? -2 : -1;
        $objServico->whatsapp             = $postVars['whatsapp']         ? -2 : -1;
        $objServico->logo                 = $postVars['logo']             ? $postVars['logo']             : '';
        $objServico->img2                 = $postVars['img2']             ? $postVars['img2']             : '';
        $objServico->img3                 = $postVars['img3']             ? $postVars['img3']             : '';
        $objServico->descricao            = $postVars['descricao']        ? $postVars['descricao']        : ''; 

        
        if($postVars['action'] == 'atualizar' ){
          $objServico->updateServico();
            
        }else{

            $objServico->insertNewServico();
        }
    }
    /**
     * Metódo responsável por criar um novo Comércio
     *
     * @param [type] $idCustomer
     * @return void
     */
    public static function createComercio($idApp,  $postVars){

        $objComercio = EntityComercio::getComercioById($idApp);

    
        if (!$objComercio instanceof EntityComercio){
            $objComercio = new EntityComercio();

        }

        $objComercio->idApp            = $idApp;
        $objComercio->idAppComercio    = $objComercio->idAppComercio;
        $objComercio->semana           = !$postVars['semana']  || $postVars['semana']   == '00:00 - 00:00'  ? 'Fechado' : $postVars['semana'];
        $objComercio->sabado           = !$postVars['sabado']  || $postVars['sabado']   == '00:00 - 00:00'  ? 'Fechado' : $postVars['sabado'];
        $objComercio->domingo          = !$postVars['domingo'] || $postVars['domingo']  == '00:00 - 00:00'  ? 'Fechado' : $postVars['domingo'];
        $objComercio->feriado          = !$postVars['feriado'] || $postVars['feriado']  == '00:00 - 00:00'  ? 'Fechado' : $postVars['feriado'];
        $objComercio->estacionamento   = $postVars['estacionamento']   ? -2 : -1;
        $objComercio->acessibilidade   = $postVars['acessibilidade']   ? -2 : -1;
        $objComercio->entregaDomicilio = $postVars['entregaDomicilio'] ? -2 : -1;
        $objComercio->whatsapp         = $postVars['whatsapp']         ? -2 : -1;
        $objComercio->img2             = $postVars['img2']             ? $postVars['img2']             : '';
        $objComercio->img3             = $postVars['img3']             ? $postVars['img3']             : '';
        $objComercio->descricao        = $postVars['descricao']        ? $postVars['descricao']        : '';

        if($postVars['action'] == 'atualizar' ){
          $objComercio->updateComercio();
            
        }else{ 
            $objComercio->insertNewComercio();
    
        }
    }

}
