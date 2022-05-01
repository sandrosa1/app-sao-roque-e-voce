<?php

namespace App\Controller\RACS;

use \App\Utils\View;
use \SandroAmancio\Search\Address;
use \App\Validate\Validate;
use \App\Image\Upload;
use \App\Image\Resize;
use \App\Help\Help;
use \App\Help\HelpEntity;
use \App\Model\Entity\Aplication\App as EntityApp;
use \App\Model\Entity\Customer\Customer as EntityCustomer;
use \App\Model\Entity\Aplication\Turismo\Turismo as EntityTurismo;

class AppRacs extends PageRacs{


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
    public static function getApps($request){

        $getVars = $request->getQueryParams();
       

        if($getVars['idApp']){
            $entityApp = EntityApp::getAppById($getVars['idApp']);
            $appTurismo = EntityTurismo::getTurismoById($getVars['idApp']);
        }

        if($getVars['delete']){

    
            EntityCustomer::deleteCustomer($getVars['delete']);
            EntityApp::deleteApp($getVars['delete']);
            EntityTurismo::deleteTurismo($getVars['delete']);

            $diretorio = "/var/www/html/app-sao-roque-e-voce/back-end/img/imgApp";  
            unlink($diretorio.$getVars['imagem-0']);    
            unlink($diretorio.$getVars['imagem-1']);    
            unlink($diretorio.$getVars['imagem-2']);    
             

        }
        

        
        if($getVars['idApp'] && $entityApp->segmento == 'turismo' && $appTurismo instanceof EntityTurismo){


            $content = View::render('racs/modules/app/index',[
                'processo' => 'Editar ou excluír ponto turístico?',
                'preview'   => self::getPreview($entityApp,$appTurismo),
                'nomeFantasia' => $entityApp->nomeFantasia,
                'idApp' => $entityApp->idApp,
                'tipo' => $entityApp->tipo,
                'telefone' => $entityApp->telefone,
                'cepApp' => $entityApp->cep,
                'numero' => $entityApp->numero,
                'logradouro' => $entityApp->logradouro,
                'bairro' => $entityApp->bairro,
                'localidade' => $entityApp->localidade,
                'adicionais' => $entityApp->adicionais,
                'chaves' => $entityApp->chaves,
                'seletores' => $entityApp->seletores,
                'botoes' => self::getBotaoEditar($entityApp,$appTurismo),
                'semana' => $appTurismo->semana,
                'sabado' => $appTurismo->sabado,
                'domingo' => $appTurismo->domingo,
                'feriado' => $appTurismo->feriado,
                'descricao' => $appTurismo->descricao,
                'tableAppTurismo' => self::getTableAppTurismo(),
                'estacionamento' => $appTurismo->estacionamento == -2 ? 'checked' : '',
                'acessibilidade' => $appTurismo->acessibilidade == -2 ? 'checked' : '',
                'fe' => $appTurismo->fe == -2 ? 'checked' : '',
                'trilhas' => $appTurismo->trilhas == -2 ? 'checked' : '',
                'refeicao' => $appTurismo->refeicao == -2 ? 'checked' : '',
                'natureza' => $appTurismo->natureza == -2 ? 'checked' : '',
                'cachoeira' => $appTurismo->cachoeira == -2 ? 'checked' : '',
                'parque' => $appTurismo->parque == -2 ? 'checked' : '',
                'descricao' => $appTurismo->descricao,
             
    
            ]);

          
        }else{

            $content = View::render('racs/modules/app/index',[
                'processo' => 'Criar nova atração turísca',
                'preview'   => self::getPreview(false,false),
                'nomeFantasia' => '',
                'idApp' => '',
                'tipo' => '',
                'telefone' => '',
                'cepApp' => '',
                'numero' => '',
                'logradouro' => '',
                'bairro' => '',
                'localidade' => '',
                'adicionais' => '',
                'chaves' => '',
                'seletores' => '',
                'botoes' => self::getBotaoCadastrar(),
                'semana' => '',
                'sabado' => '',
                'domingo' => '',
                'feriado' => '',
                'descricao' => '',
                'tableAppTurismo' => self::getTableAppTurismo(),
    
    
            ]);

        }
        return parent::getPanel('Apps - RACS', $content,'apps');

    }
    public static function getBotaoCadastrar(){

        return View::render('racs/modules/app/botoes/cadastrar',[]);
    }
    public static function getBotaoEditar($app,$appTurismo){

        return View::render('racs/modules/app/botoes/editar',[

            'idApp' => $app->idApp,
            'nome'  => $app->nomeFantasia,
            'imagem-0' => $app->img1,
            'imagem-1' => $appTurismo->img2,
            'imagem-2' => $appTurismo->img3,
        ]);
    }


    public static function getPostApp($request){


      
        $validate = new Validate();
        $postVars = $request->getPostVars();
       
        if($postVars['action'] == 'insert'){

            $objApp = new EntityApp();
            $idRacs = new EntityCustomer();
            $idRacs->name = 'Racs'; 
            $idRacs->permission = 'root'; 
            $idRacs->status = 'active'; 
            $objApp->idApp = $idRacs->insertNewCustomer();
            $appId = self::insertNewApp($postVars, $validate, $objApp);

        }elseif($postVars["action"] == "atualizar"){

          
            $objApp = EntityApp::getAppById($postVars["idApp"]);
            $appId = self::insertNewApp($postVars, $validate, $objApp);
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
                'page'    => "apps?idApp=$appId",
            ];

        }

        return json_encode($arrResponse);
       
    }

    private static function insertNewApp($postVars, $validate, $objApp){


    
        $campos = []; 
        $campos[0] = $objApp->nomeFantasia = $postVars['nomeFantasia'] ? $postVars['nomeFantasia']: $objApp->nomeFantasia;
        $campos[1] = $objApp->tipo         = $postVars['tipo']         ? $postVars['tipo']        : $objApp->tipo;
        $campos[2] = $objApp->segmento     = 'turismo';
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

      

        if(count($validate->getErro()) == 0){

            if($postVars['action'] == 'insert'){
                //Recebe a imagem padrao
                $objApp->img1  ='um.jpg';
                $objApp->visualizacao = 0;
                $objApp->totalCusto = 0;
                $objApp->totalAvaliacao = 0;
                $objApp->avaliacao = 0;  
                            
               $status = $objApp->insertNewApp();

            }elseif($postVars["action"] == "atualizar"){

                $status = $objApp->updateApp();
            }

            //Cria uma instancia de novo Apa
            if( $status){
              
   
                if( HelpEntity::helpTurismo($objApp->idApp, $postVars)){

                   
                    if(self::uploadImageTurismo($objApp->idApp,$objApp,$validate)){


                        return $objApp->idApp;

                    }else{

                        EntityCustomer::deleteCustomer($objApp->idApp);
                        EntityApp::deleteApp($objApp->idApp);
                        EntityTurismo::deleteTurismo($objApp->idApp);
                        $validate->setErro('Erro ao fazer upload de imagens.');
                        return false;
                       
                    }

                }else{

                    $validate->setErro('Erro ao criar Criar Ponto turístico.');
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

    public static function getPreview($app, $appTurismo){

        if($app && $appTurismo){

            return View::render('racs/modules/app/preview/index',[
                'display'    => self::getDisplay(),
                'header'     => self::getHeader($app),
                'nome'       => self::getNome($app),
                'status'     => self::getStatus($app),
                'carrocel'   => self::getCarrocel($app,$appTurismo),
                'seletores'  => self::getSeletores($app),
                'descricao'  => self::getDescricao($app),
                'comentario' => self::getComentario($app),
                'endereco'   => self::getAddress($app),
            ]);
        }else{

            return View::render('racs/modules/app/preview/index',[

                'display'    => self::getDisplay(),
                'header'     => '',
                'nome'       => '',
                'status'     => '',
                'carrocel'   => '',
                'seletores'  => '',
                'descricao'  => '',
                'comentario' => '',
                'endereco'   => '',
             
            ]);
        }

    }

    /**
    * Metódo que retorna o componente de display do preview do app 
    *
    * @return string
    */
    private static function getDisplay(){
        return View::render('racs/modules/app/preview/components/display',[
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
      
        return View::render('racs/modules/app/preview/components/header',[
            'icon' => $header[1],
            'tipo' => $header[0],
        ]);
    }
    /** 
    * Metódo que retorna o componente de nome fantásia do preview do app
    *
    * @return string
    */
    private static function getNome($app){
       
        ;
      
        return View::render('racs/modules/app/preview/components/nome',[
            'nome'=> $app->nomeFantasia,
        ]);
    }
    /** 
    * Metódo que retorna o componente de status do preview do app
    *
    * @return string
    */
    private static function getStatus(){
      
        return View::render('racs/modules/app/preview/components/status',[]);
    }
    /** 
    * Metódo que retorna o componente de carrocel de imagens do preview do app
    *
    * @return string
    */
    private static function getCarrocel($app, $appTurismo){

       
        return View::render('racs/modules/app/preview/components/carrocel',[
            'img1' => $app->img1,
            'img2' => $appTurismo->img2,
            'img3' => $appTurismo->img3,
        ]);
        
    }
    /** 
    * Metódo que retorna o componente de opções do preview do app
    *
    * @return string
    */
    private static function getSeletores($app){

        $appTipo = (array)HelpEntity::helpGetEntity($app);

        $opcoes = '';

        foreach ($appTipo as $key => $value) {
               
                if ($value == -2 ){
                    $value = Help::helpOptions($key)[1];
                    $nome = Help::helpOptions($key)[0];
                    $opcoes .= View::render('racs/modules/app/preview/components/opcao',[
                        'value' => $value,
                         'nome'  => $nome,
                    ]);
                }
            }

        return View::render('racs/modules/app/preview/components/seletores',[
            'seletores' => $opcoes,
        ]);
    }
    /** 
    * Metódo que retorna o componente de descrição do preview do app
    *
    * @return string
    */
    private static function getDescricao($app){
        
        $appTipo = HelpEntity::helpGetEntity($app);
       
        return View::render('racs/modules/app/preview/components/descricao',[
            'descricao' => $appTipo->descricao,
        ]);
    }

     /** 
    * Metódo que retorna o componente de comentário do preview do app
    *
    * @return string
    */
    private static function getComentario(){
        
        
        return View::render('racs/modules/app/preview/components/comentario',[
            
        ]);
    }

    /** 
    * Metódo que retorna o componente de endereço do preview do app
    *
    * @return string
    */
    private static function getAddress($app){

     
        return View::render('racs/modules/app/preview/components/endereco',[
            
            'endereco' => "<div class='col  s12'><i class='ml-2 c-pri fz-15 fas fa-map-marked-alt'></i><span class=' c-popi fz-5'> ".$app->logradouro .', Nº '. $app->numero.', '.$app->bairro."</span></div>",
            'telefone' => $app->telefone ? "<div class='col  s12'><i class='ml-2 c-pri fz-15 fas fa-phone-volume'></i><span class=' c-popi fz-5'> ".$app->telefone."</span></div>": '',
            'site'     => $app->site ? "<div class='col  s12'><i class='ml-2 pb-5 c-pri fz-15 fas fa-globe'></i><span class=' c-popi fz-5'> ".$app->site."</span></div>" :'',
        ]);
    }

    /**
     * Modo responsável peo controlar o upload de imagens
     *
     * @param [
     * @return void
     */
    public static function uploadImageTurismo($idApp, $objApp, $validate){

        
        if(isset($_FILES['arquivoImagem']) && $_FILES['arquivoImagem']['name'][0] && $_FILES['arquivoImagem']['name'][1] && $_FILES['arquivoImagem']['name'][2]){

           
            $uploads = Upload::createMultiUpload($_FILES['arquivoImagem']);
            $tamanho = 250;
            
        }else{

            return true;
        }

    
        $pathImages = [];
        $number = 1;

        if($uploads){

            foreach ($uploads as $objUpload) {
                
               $objUpload->generateNewName($idApp, $number++);

                $sucesso = $objUpload->upload('/var/www/html/app-sao-roque-e-voce/back-end/img/imgApp');

                array_push($pathImages, $objUpload->getBasename());
              
                $objResize = new Resize('/var/www/html/app-sao-roque-e-voce/back-end/img/imgApp/'.$objUpload->getBasename());

                $objResize->resize($tamanho);

                $objResize->save('/var/www/html/app-sao-roque-e-voce/back-end/img/imgApp/'.$objUpload->getBasename(),70);

                if($sucesso){

                    
                    continue;
                    
                }else{

                    $validate->setErro('Erro ao enviar o arquivo <br>');
                }

            }
            
        }else{

            $validate->setErro('Formato da imagem inválido!');
            return false;
        }

        if(count($validate->getErro()) > 0){
          
            return false;
            
        }else{

        
            if(AppRacs::insertPathImageDataBase($objApp,$pathImages)){

                return true;

            }else{

               $validate->setErro('Algo de errado ao inseria o caminho das imagems');
                return false;
            }

        }
        
    }

    /**
     * Método responsável por controlar a inserção dos caminhos das imagens no banco de dados
     *
     * @param Entity $idApp
     * @param string $pathImages
     * @return void
     */
    private static function insertPathImageDataBase($objApp, $pathImages){


        $appSegmento = HelpEntity::helpGetEntity($objApp); 

        
            return HelpEntity::helpImgTurismo($objApp, $appSegmento, $pathImages);

           
    }

    public static function getTableAppTurismo(){


        return View::render('racs/modules/app/table/thead',[
            'tbody' => self::getTbodyAppTurimo(),
        ]);

        

    }

    public static function getTbodyAppTurimo(){

        $AppTurismo = HelpEntity::hellGetAllsApps();

        $content = '';
 
        foreach ($AppTurismo as $key => $value) {

            if($value['segmento'] == 'turismo'){

                $content .= View::render('racs/modules/app/table/tbody',[

                    'idApp'        => $value['idApp'],
                    'nomeFantasia' => $value['nomeFantasia'],
        
                ]);

            }
         
        }
        
        return $content;
    }


}