<?php

namespace App\Controller\Srv;

use \SandroAmancio\Search\Address;
use \App\Help\HelpEntity;
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

            $tipoDefinido = $app->segmento. " - ".$app->tipo;
           
        
            $content = View::render('srv/modules/configuracao/index', [
                'botoes'             => self::getButtonEdit(),
                'h1'                 => 'Atualize ou delete seu dados aqui',
                'nomeFantasia'       => $app->nomeFantasia,
                'tipoFormatado'      => 'Selecione o tipo',
                'tipo'               => '',
                'segmentoFormatado'  => $tipoDefinido ,
                'segmento'           => $app->segmento  ,
                'email'              => $app->email,
                'telefone'           => $app->telefone,
                'site'               => $app->site,
                'facebook'           => $app->facebook,
                'instagram'          => $app->instagram,
                'youtube'            => $app->youtube,
                'celular'            => $app->celular,
                'cep'                => $app->cep,
                'logradouro'         => $app->logradouro,
                'numero'             => $app->numero,
                'bairro'             => $app->bairro,
                'localidade'         => $app->localidade,
                'adicionais'         => $app->adicionais,
                'chaves'             => $app->chaves,
                'customer'           => $app->idApp

            ]);
        } else {
            $content = View::render('srv/modules/configuracao/index', [
                'botoes'             => self::getButtonRegister(),
                'h1'                 => 'Configurações',
                'nomeFantasia'       => '',
                'tipoFormatado'      =>  'Selecione o tipo',
                'tipo'               =>  '',
                'segmentoFormatado'  =>  'Selecione um segmento',
                'email'              => '',
                'telefone'           => '',
                'site'               => '',
                'facebook'           => '',
                'instagram'          => '',
                'youtube'            => '',
                'celular'            => '',
                'cep'                => '',
                'logradouro'         => '',
                'numero'             => '',
                'bairro'             => '',
                'localidade'         => '',
                'adicionais'         => '',
                'chaves'             => '',
                'site'               => $app->site,
                'tipos'              => '',

        
            ]);
        }

        return parent::getPanel('Configuração - SRV', $content, 'configuracao');
    }

    private static function getFieldInput($tipo, $status){

        return View::render('srv/modules/configuracao/tipo/input', [
            'value'   => $tipo,
            'status' => $status
        ]);

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

        $tipo = '';
        if($postVars['segmento'] == 'servicos'){

            $tipo = $postVars['tipo2'];

        }
        else{
            $tipo = $postVars['tipo1'];
        }
      
        if($objApp->segmento != '' && $objApp->segmento != $postVars['segmento']){

            $validate->setErro('Exclua o anúncio para mudar de segmento');
        }

        
       
        //Array de campos obrigatorios
        $campos = [];
        //Criando o APP ou Atualizando APP
        $objApp->idApp        = $idCustomer;

        $campos['nomeFantasia']            = $objApp->nomeFantasia = $postVars['nomeFantasia'] ? $postVars['nomeFantasia']: $objApp->nomeFantasia;
        $campos['tipo']                    = $objApp->tipo         = $tipo                     ? $tipo                    : $objApp->tipo;
        $campos['segmento']                = $objApp->segmento     = $postVars['segmento']     ? $postVars['segmento']    : $objApp->segmento;
        $campos['email']                   = $objApp->email        = $postVars['email']        ? $postVars['email']       : $objApp->email;
        $campos['celular']                 = $objApp->celular      = $postVars['celular']      ? $postVars['celular']     : $objApp->celular;
        $campos['cep']                     = $objApp->cep          = $postVars['cep']          ? $postVars['cep']         : $objApp->cep;
        $campos['logradouro']              = $objApp->logradouro   = $postVars['logradouro']   ? $postVars['logradouro']  : $objApp->logradouro;
        $campos['numero']                  = $objApp->numero       = $postVars['numero']       ? $postVars['numero']      : $objApp->numero;
        $campos['bairro']                  = $objApp->bairro       = $postVars['bairro']       ? $postVars['bairro']      : $objApp->bairro;
        $campos['localidade']              = $objApp->localidade   = $postVars['localidade']   ? $postVars['localidade']  : $objApp->localidade;
        $objApp->telefone                  = $postVars['telefone']     ? $postVars['telefone']    : '';
        $objApp->site                      = $postVars['site']         ? $postVars['site']        : $objApp->site;
        $objApp->facebook                  = $postVars['facebook']     ? $postVars['facebook']    : $objApp->facebook;
        $objApp->instagram                 = $postVars['instagram']    ? $postVars['instagram']   : $objApp->instagram;
        $objApp->youtube                   = $postVars['youtube']      ? $postVars['youtube']     : $objApp->youtube;
        $objApp->adicionais                = $postVars['adicionais']   ? $postVars['adicionais']  : $objApp->adicionais;
        $objApp->chaves                    = $postVars['chaves']       ? $postVars['chaves']      : $objApp->chaves;
        $action                            = $postVars['action'];
        $captcha                           = $postVars['g-recaptcha-response'];


        if($objApp->site){
            
            $validate->validateSite($objApp->site);
        }
        
       
        $validate->validateFields($campos);
       // $validate->validateCaptcha($captcha);
        $validate->validateEmail($objApp->email);
        $validate->validadeCep($objApp->cep);
        $validate->validadeCelular($objApp->celular);
        $validate->validateIssetAppFields( $objApp->idApp, $objApp->email,$objApp->celular,$objApp->telefone);

        if($objApp->telefone ){
            $validate->validadeTelefone($objApp->telefone);
         }
        $objApp->chaves = Help::helpTextForArray($objApp->chaves);

        $validate->validateBlockedWord($objApp->chaves);

        $objApp->chaves = Help::helpArrayForString($objApp->chaves);

        $coordenadas = Help::helpGetCoordinates($campos['cep'],$campos['logradouro'],$campos['bairro'],$campos['localidade'],TOKEN_MAPBOX);


        if($coordenadas){

            $objApp->latitude =$coordenadas[0] ;
            $objApp->longitude =$coordenadas[1] ;
            
        }

        if(count($validate->getErro()) > 0){

            $arrResponse = [
                "retorno" => 'erro',
                "erros"   => $validate->getErro()
            ];

        }else{

          
            $mensagem = [];
           
            if($action === 'insert'){
               
                //Recebe a imagem padrao e configurações adicionais
                $objApp->img1  ='um.jpg';
                $objApp->visualizacao = 0;
                $objApp->totalCusto = 0;
                $objApp->totalAvaliacao = 0;
                $objApp->avaliacao = 0;  

                //Cria uma instancia de novo App
                $objApp->insertNewApp();
                $mensagem = ["Configurações inseridas com sucesso", "Clique em detalhes no menu lateral para prosseguir"];
               
                //Cria uma instancia de acordo com o segmento
                switch ($objApp->segmento) {
                    case 'hospedagem':
                        HelpEntity::helpHospedagem($idCustomer,  $postVars);
                        break;
                    case 'evento':
                        HelpEntity::helpEvento($idCustomer,  $postVars);
                        break;
                    case 'comercio':
                        HelpEntity::helpComercio($idCustomer,  $postVars);
                        break;
                    case 'servicos':
                        HelpEntity::helpServico($idCustomer,  $postVars);
                        break;
                    case 'gastronomia':
                        HelpEntity::helpGastronomia($idCustomer,  $postVars);
                        break;
                }

            }
            if($action === 'update'){

                $objApp->updateApp();
                $mensagem = ['Informações atualizadas com sucesso.'];
            }
        
            $arrResponse=[
                "retorno" => "success",
                "page"    => "configuracao",
                "success" => $mensagem
            ];   

        }

        return json_encode($arrResponse);
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


}
