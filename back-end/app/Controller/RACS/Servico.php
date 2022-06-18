<?php

namespace App\Controller\RACS;

use \App\Utils\View;
use \SandroAmancio\Search\Address;
use \App\Validate\Validate;
use \App\Help\Help;
use \App\Help\HelpEntity;
use \App\Model\Entity\Aplication\App as EntityApp;
use \App\Model\Entity\Customer\Customer as EntityCustomer;
use \App\Model\Entity\Aplication\Servico\Servico as EntityServico;

class Servico extends PageRacs{


    public static function getCepApp($request)
    {

        $postVars = $request->getPostVars();

        $query = new Address();
        $addressQuery = $query->getAddressFromZipCode($postVars['cepApp']);
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
     * Renderiza o conteúdo da view de apps
     * 
     *
     * @param Request $request
     * @return String
     */
    public static function getAppServico($request){

        $getVars = $request->getQueryParams();
        $validate = new Validate();

        if($getVars['idApp']){
            $entityApp = EntityApp::getAppById($getVars['idApp']);
            $user = EntityCustomer::getCustomerById($getVars["idApp"]);
            $appServico = EntityServico::getServicoById($getVars['idApp']);
            
        }

        if($getVars['delete']){
    
            
            $user = EntityCustomer::getCustomerById($getVars['delete']);

            if($user->permission != 'root'){

                
                
            }else{
                EntityCustomer::deleteCustomer($getVars['delete']);
                EntityApp::deleteApp($getVars['delete']);
                EntityServico::deleteServico($getVars['delete']);
    
                $diretorio = "/var/www/html/app-sao-roque-e-voce/back-end/img/imgApp";  
                unlink($diretorio.$getVars['imagem-0']);

            }
           
               
           
        }
        

        
        if($getVars['idApp'] && $entityApp->segmento == 'servicos' && $appServico instanceof EntityServico){


            $content = View::render('racs/modules/servico/index',[
                'processo'         => 'Editar ou excluír ponto Serviço?',
                'preview'          => self::getPreview($entityApp,$appServico),
                'nomeFantasia'     => $entityApp->nomeFantasia,
                'permission'       => self::getPermission($user->permission),
                'idApp'            => $entityApp->idApp,
                'tipo'             => $entityApp->tipo,
                'tipoFormatado'    => 'Selecione o tipo',
                'telefone'         => $entityApp->telefone,
                'cepApp'           => $entityApp->cep,
                'numero'           => $entityApp->numero,
                'logradouro'       => $entityApp->logradouro,
                'bairro'           => $entityApp->bairro,
                'localidade'       => $entityApp->localidade,
                'adicionais'       => $entityApp->adicionais,
                'chaves'           => $entityApp->chaves,
                'seletores'        => $entityApp->seletores,
                'logo'             => $entityApp->logo,
                'botoes'           => self::getBotaoEditar($entityApp,$appServico,$user->permission),
                'semana'           => $appServico->semana,
                'sabado'           => $appServico->sabado,
                'domingo'          => $appServico->domingo,
                'feriado'          => $appServico->feriado,
                'descricao'        => $appServico->descricao,
                'tableAppServico'  => self::getTableAppServico(),
                'estacionamento'   => $appServico->estacionamento == -2 ? 'checked' : '',
                'acessibilidade'   => $appServico->acessibilidade == -2 ? 'checked' : '',
                'entregaDomicilio' => $appServico->entregaDomicilio  == -2 ? 'checked' : '',
                'whatsapp'         => $appServico->whatsapp  == -2 ? 'checked' : '',
                
            
            ]);

          
        }else{

            $content = View::render('racs/modules/servico/index',[
                'processo' => 'Criar novo Serviço',
                'preview'   => self::getPreview(false,false),
                'nomeFantasia' => '',
                'permission' => '',
                'idApp' => '',
                'tipo' => '',
                'tipoFormatado' => 'Selecione o tipo',
                'telefone' => '',
                'cepApp' => '',
                'numero' => '',
                'logradouro' => '',
                'bairro' => '',
                'localidade' => '',
                'adicionais' => '',
                'chaves' => '',
                'seletores' => '',
                'logo' => '',
                'botoes' => self::getBotaoCadastrar(),
                'semana' => '',
                'sabado' => '',
                'domingo' => '',
                'feriado' => '',
                'descricao' => '',
                'tableAppServico' => self::getTableAppServico(),
    
    
            ]);

        }
        return parent::getPanel('Apps - RACS', $content,'apps');

    }

    public static function getPermission($user){

        return View::render('racs/modules/servico/permissao/permissao',[
            'permission' => $user,
        ]);
    }
    public static function getBotaoCadastrar(){

        return View::render('racs/modules/servico/botoes/cadastrar',[]);
    }
    public static function getBotaoEditar($app,$appServico,$user){

        if($user == 'root'){

            return View::render('racs/modules/servico/botoes/editar',[

                'idApp'   => $app->idApp,
                'nome'    => $app->nomeFantasia,
                'imagem-0' => $app->img1,
               
            ]);
        }else{
            return View::render('racs/modules/servico/botoes/block',[

                
            ]);

        }
        
    }


    public static function getPostAppServico($request){

        $validate = new Validate();
        $postVars = $request->getPostVars();


      

        if($postVars['action'] == 'insert'){

            

            $objApp = new EntityApp();
          
            $idRacs = new EntityCustomer();
            $idRacs->name = 'Racs'; 
            $idRacs->permission = 'root'; 
            $idRacs->status = 'active'; 
            $objApp->idApp = $idRacs->insertNewCustomer();
            $appId = self::insertNewAppServico($postVars, $validate, $objApp);

            
        }elseif($postVars["action"] == "atualizar"){

            
            $objApp = EntityApp::getAppById($postVars["idApp"]);

            $user = EntityCustomer::getCustomerById($postVars["idApp"]);

            if($user->permission != 'root'){
                
                $validate->setErro("Somente o usuario pode fazer atualizações");
            }
            $appId = self::insertNewAppServico($postVars, $validate, $objApp);

        }else{

            $validate->setErro("Tamanho da imagem inválido!");
        }

        if(count($validate->getErro()) > 0){

            $arrResponse = [

                'retorno' => 'erro',
                'erros' => $validate->getErro()
            ];
        }else{
            if($postVars["action"] == 'insert'){
                $msg = 'Cadastrado';
            }else{
                $msg = 'Editado';
            }

            $arrResponse = [
                'retorno' => 'success',
                'success' => ["$msg com sucesso :)"],
                'page'    => "criar-servico?idApp=$appId",
            ];

        }

        return json_encode($arrResponse);
       
    }

    private static function insertNewAppServico($postVars, $validate, $objApp){

    
        $campos = []; 
        $campos[0] = $objApp->nomeFantasia = $postVars['nomeFantasia'] ? $postVars['nomeFantasia']: $objApp->nomeFantasia;
        $campos[1] = $objApp->tipo         = $postVars['tipo']         ? $postVars['tipo']        : $objApp->tipo;
        $campos[2] = $objApp->segmento     = 'servicos';
        $campos[3] = $objApp->email        = $postVars['email']        ? $postVars['email']       : $objApp->email;
        $campos[4] = $objApp->celular      = '';
        $campos[5] = $objApp->cep          = $postVars['cepApp']       ? $postVars['cepApp']      : $objApp->cep;
        $campos[6] = $objApp->logradouro   = $postVars['logradouro']   ? $postVars['logradouro']  : $objApp->logradouro;
        $campos[7] = $objApp->numero       = $postVars['numero']       ? $postVars['numero']      : $objApp->numero;
        $campos[8] = $objApp->bairro       = $postVars['bairro']       ? $postVars['bairro']      : $objApp->bairro;
        $campos[9] = $objApp->localidade   = $postVars['localidade']   ? $postVars['localidade']  : $objApp->localidade;
        $objApp->telefone                  = $postVars['telefone']     ? $postVars['telefone']    : '';
        $objApp->adicionais                = $postVars['adicionais']   ? $postVars['adicionais']  : $objApp->adicionais;
        $objApp->chaves                    = $postVars['chaves']       ? $postVars['chaves']      : $objApp->chaves;
        $captcha                           = $postVars['g-recaptcha-response'];

        $objApp->chaves = Help::helpTextForArray($objApp->chaves);

        $validate->validateBlockedWord($objApp->chaves);

        $objApp->chaves = Help::helpArrayForString($objApp->chaves);

      
       
        $coordenadas = Help::helpGetCoordinates($campos[5],$campos[6],$campos[8],$campos[9],TOKEN_MAPBOX);


        if($coordenadas){

            $objApp->latitude =$coordenadas[0] ;
            $objApp->longitude =$coordenadas[1] ;
            
        }

        if(count($validate->getErro()) == 0){

            if($postVars['action'] == 'insert'){
                //Recebe a imagem padrao
                $objApp->img1  ='um.jpg';
                $objApp->visualizacao = 0;
                $objApp->totalCusto = 0;
                $objApp->totalAvaliacao = 0;
                $objApp->avaliacao = 0;
                $update = false;  
                            
               $status = $objApp->insertNewApp();

            }elseif($postVars["action"] == "atualizar"){

                $update = true;
                $status = $objApp->updateApp();
            }

            //Cria uma instancia de novo App
            if($status){
               
   
                if( HelpEntity::helpServico($objApp->idApp, $postVars)){

                  
                    if(self::uploadImageServico($objApp->idApp,$objApp,$validate,$update)){


                        return $objApp->idApp;

                    }else{

                        EntityCustomer::deleteCustomer($objApp->idApp);
                        EntityApp::deleteApp($objApp->idApp);
                        EntityServico::deleteServico($objApp->idApp);
                        $validate->setErro('Erro ao fazer upload de imagens.');
                        return false;
                       
                    }

                }else{

                    $validate->setErro('Erro ao criar Criar Serviço.');
                    EntityCustomer::deleteCustomer($objApp->idApp);
                    EntityApp::deleteApp($objApp->idApp);
                    return false;
                }
                
            }else{
                $validate->setErro('Erro ao criar APP.');
                return false;
            }
        }else{

            return false;
        }

         

    }


    /** 
    * Metódo que retorna o componente de serviços do preview do app
    *
    * @return string
    */
    private static function getServicos($app){

    
        $appTipo = HelpEntity::helpGetEntity($app);

      

        return View::render('racs/modules/servico/preview/components/servicos',[
            
            'nome'       => $app->nomeFantasia ? "<p class='c-popi fz-10 fwb'> ".$app->nomeFantasia ."</p>":"",
            'endereco'   => "<i class='c-pri fz-15 fas fa-map-marked-alt'></i><span class=' c-popi fz-5'> ".$app->logradouro .', Nº '. $app->numero.', '.$app->bairro."</span>",
            'telefone'   => $app->telefone   ?"<i class='c-pri fz-15 fas fa-phone-volume'></i><span class=' c-popi fz-5'> ".$app->telefone."</span>": '',
            'site'       => $app->site       ?"<i class='pb-5 c-pri fz-15 fas fa-globe'></i><span class=' c-popi fz-5'> ".$app->site."</span>" :'',
            'horarios'   => $appTipo->semana ?"<p class=' c-popi fz-5'>Semana ".$appTipo->semana."</p><p class=' c-popi fz-5'>Sabádo ".$appTipo->sabado."</p><p class=' c-popi fz-5'>Domingo ".$appTipo->domingo."</p><p class=' c-popi fz-5'>Fériados ".$appTipo->feriado."</p>" : '',
            'logo'       => $app->img1       ? $app->img1 : '' ,
        ]);
    }

    public static function getPreview($app, $appServico){

        if($app && $appServico){

            return View::render('racs/modules/servico/preview/servico',[
                'display'       => self::getDisplay(),
                'header'        => self::getHeader($app),
                'informacoes'   => Self::getServicos($app),
            ]);

        }else{

            return View::render('racs/modules/servico/preview/servico',[

                'display'         => self::getDisplay(),
                'header'          => '',
                'informacoes'     => '',
            ]);
        }

    }

    /**
    * Metódo que retorna o componente de display do preview do app 
    *
    * @return string
    */
    private static function getDisplay(){
        return View::render('racs/modules/servico/preview/components/display',[
            'hora' => date('h:i'),
        ]);
    }
    /**
    * Metódo que retorna o componente de header do preview do app
    *
    * @return string
    */
    private static function getHeader($app){

        $header = Help::helpGetTypeHeader($app);
      
        return View::render('racs/modules/servico/preview/components/header',[
            'icon' => $header[1],
            'tipo' => $header[0],
        ]);
    }
   

    /**
     * Modo responsável peo controlar o upload de imagens
     *
     * @param [
     * @return void
     * public static function hellUploadImage($validate, $app, $appSegmento,$update)
     * uploadImageServico($objApp->idApp,$objApp,$validate,$update)
     */
    public static function uploadImageServico($idApp, $objApp, $validate, $update){


      
        $appSegmento = HelpEntity::helpGetEntity($objApp);
       
        $uploads = Help::hellUploadImage($validate,$objApp,$appSegmento,$update);

        if($uploads){

           return true;
    
        }else{
    
            $validate->setErro('Algo de errado ao inseria o caminho das imagems');
            return false;
        }
       
    }

   
    public static function getTableAppServico(){


        return View::render('racs/modules/servico/table/thead',[
            'tbody' => self::getTbodyAppServico(),
        ]);

        

    }

    public static function getTbodyAppServico(){

        $appServico = HelpEntity::hellGetAllsApps();
    

        $content = '';
 
        foreach ($appServico as $key => $value) {

           $user = EntityCustomer::getCustomerById($value['idApp']);
            if($value['segmento'] == 'servicos'){

                $content .= View::render('racs/modules/servico/table/tbody',[

                    'idApp'        => $value['idApp'],
                    'nomeFantasia' => $value['nomeFantasia'],
                    'permission'   => $user->permission
        
                ]);

            }
         
        }
        
        return $content;
    }


}