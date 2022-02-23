<?php

namespace App\Controller\Srv;

use \App\Utils\View;
use \App\Help\Help;
use \App\Model\Entity\Aplication\App as EntityApp;
use \App\Image\Upload;
use \App\Image\Resize;
use \App\Validate\Validate;

class ScreenSrv extends PageSrv{


   
    /**
    * Renderiza o conteúdo da pagina de depoimentos
    *
    * @param Request $request
    * @return string
    */
    public static function getScreen(){

        // $session = new PageSrv();
        // $idApp =  $session->idSession;


        // $app = EntityApp::getAppById($idApp);

        if(Help::helpApp() instanceof EntityApp){
            $content = View::render('srv/modules/tela/index',[
                'preview' => self::getView(),
                'form'    => self::getForm(),
                'status'  => '',

                
            ]);   
        }else{
            $content = View::render('srv/modules/tela/index',[
                'status'  => self::getBlockView(),
                'preview' => '',
                'form'    => '',
                
            ]);
        }
       return parent::getPanel('Tela - SRV', $content,'tela');

    }
      /**
     * Metódo respónsavel por retornar a view do botão de cadastrar
     *
     * @return string
     */
    private static function getView(){


        $app = Help::helpApp();

       
        if($app->segmento != 'servicos'){

            return View::render('srv/modules/tela/preview/index',[
                'display'    => self::getDisplay(),
                'header'     => self::getHeader(),
                'nome'       => self::getNome(),
                'status'     => self::getStatus(),
                'carrocel'   => self::getCarrocel(),
                'seletores'  => self::getSeletores(),
                'descricao'  => self::getDescricao(),
                'comentario' => self::getComentario(),
                'endereco'   => self::getAddress(),
            ]);
        }

        return View::render('srv/modules/tela/preview/index',[

            'display'    => self::getDisplay(),
             'header'     => self::getHeader(),
            'nome'       => '',
            'status'     => '',
            'carrocel'   => Self::getServicos(),
            'seletores'  => '',
            'descricao'  => '',
            'comentario' => '',
            'endereco'   => '',
        ]);

       
       
    }
      /**
     * Metódo respónsavel por retornar a view do botão de atualizar e deletar
     *
     * @return string
     */
    private static function getBlockView(){
        return View::render('srv/modules/tela/block/index',[]);
    }

    /**
    * Metódo respónsavel por retornar a view do botão de atualizar e deletar
    *
    * @return string
    */
   private static function getForm(){


    $app = Help::helpApp();

       
    if($app->segmento != 'servicos'){
        return View::render('srv/modules/tela/form/form',[]);

    }else{
        return View::render('srv/modules/tela/form/formServicos',[]);

    }
   }

   /**
    * Metódo que retorna o display 
    *
    * @return string
    */
    private static function getDisplay(){
        return View::render('srv/modules/tela/preview/components/display',[
            'hora' => date('h:i'),
        ]);
    }
       /**
    * Metódo que retorna o display 
    *
    * @return string
    */
    private static function getHeader(){

       
       
        $header = Help::helpGetTypeHeader(Help::helpApp());
      
        return View::render('srv/modules/tela/preview/components/header',[
            'icon' => $header[1],
            'tipo' => $header[0],
        ]);
    }
    /** 
    * Metódo que retorna o display 
    *
    * @return string
    */
    private static function getNome(){

       
       
        $header = Help::helpApp();
      
        return View::render('srv/modules/tela/preview/components/nome',[
            'nome'=> $header->nomeFantasia,
        ]);
    }
    /** 
    * Metódo que retorna o display 
    *
    * @return string
    */
    private static function getStatus(){
      
        return View::render('srv/modules/tela/preview/components/status',[]);
    }
    /** 
    * Metódo que retorna o display 
    *
    * @return string
    */
    private static function getCarrocel(){
      
        $app = Help::helpApp();
        $appTipo = Help::helpGetEntity($app);

        return View::render('srv/modules/tela/preview/components/carrocel',[
            'img1' => $app->img1,
            'img2' => $appTipo->img2,
            'img3' => $appTipo->img3,
        ]);
        
    }
    
    /** 
    * Metódo que retorna o display 
    *
    * @return string
    */
    private static function getSeletores(){


        $appTipo = (array)Help::helpGetEntity(Help::helpApp());

        $opcoes = '';
        foreach ($appTipo as $key => $value) {
               
                if ($value == -2 ){
                    $value = Help::helpOptions($key)[1];
                    $nome = Help::helpOptions($key)[0];
                    $opcoes .= View::render('srv/modules/tela/preview/components/opcao',[
                        'value' => $value,
                        'nome'  => $nome,
                        
                    ]);
                   
                }
            }

        return View::render('srv/modules/tela/preview/components/seletores',[
            'seletores' => $opcoes,
        ]);
    }
    /** 
    * Metódo que retorna o display 
    *
    * @return string
    */
    private static function getDescricao(){
        
        $appTipo = Help::helpGetEntity(Help::helpApp());
       
        return View::render('srv/modules/tela/preview/components/descricao',[
            'descricao' => $appTipo->descricao,
        ]);
    }

     /** 
    * Metódo que retorna o display 
    *
    * @return string
    */
    private static function getComentario(){
        
        
        return View::render('srv/modules/tela/preview/components/comentario',[
            
        ]);
    }

     /** 
    * Metódo que retorna o display 
    *
    * @return string
    */
    private static function getAddress(){

        $app = Help::helpApp();
     
        return View::render('srv/modules/tela/preview/components/endereco',[
            
            'endereco' => "<div class='col  s12'><i class='ml-2 c-pri fz-15 fas fa-map-marked-alt'></i><span class=' c-popi fz-5'> ".$app->logradouro .', Nº '. $app->numero.', '.$app->bairro."</span></div>",
            'telefone' => $app->telefone ? "<div class='col  s12'><i class='ml-2 c-pri fz-15 fas fa-phone-volume'></i><span class=' c-popi fz-5'> ".$app->telefone."</span></div>": '',
            'site'     => $app->site ? "<div class='col  s12'><i class='ml-2 pb-5 c-pri fz-15 fas fa-globe'></i><span class=' c-popi fz-5'> ".$app->site."</span></div>" :'',
        ]);
    }

    /** 
    * Metódo que retorna o display 
    *
    * @return string
    */
    private static function getServicos(){

        $app = Help::helpApp();
        $appTipo = Help::helpGetEntity($app);

     
        return View::render('srv/modules/tela/preview/components/servicos',[
            
            'endereco'   => "<i class='c-pri fz-15 fas fa-map-marked-alt'></i><span class=' c-popi fz-5'> ".$app->logradouro .', Nº '. $app->numero.', '.$app->bairro."</span>",
            'telefone'   => $app->telefone   ?"<i class='c-pri fz-15 fas fa-phone-volume'></i><span class=' c-popi fz-5'> ".$app->telefone."</span>": '',
            'site'       => $app->site       ?"<i class='pb-5 c-pri fz-15 fas fa-globe'></i><span class=' c-popi fz-5'> ".$app->site."</span>" :'',
            'horarios'   => $appTipo->semana ?"<p class=' c-popi fz-5'>Semana ".$appTipo->semana."</p><p class=' c-popi fz-5'>Sabádo ".$appTipo->sabado."</p><p class=' c-popi fz-5'>Domingo ".$appTipo->domingo."</p><p class=' c-popi fz-5'>Fériados ".$appTipo->feriado."</p>" : '',
            'logo'       =>  'O',
        ]);
    }

    /**
     * 
     *
     * @param [
     * @return void
     */
    public static function uploadImage(){

        $app = Help::helpApp();
        $validate = new Validate();

        if(isset($_FILES['arquivo'])){

            $uploads = Upload::createMultiUpload($_FILES['arquivo']);
            $pathImages = [];
            $number = 1;
            foreach ($uploads as $objUpload) {
                // Move os arquivos de upload
                $objUpload->generateNewName($app->idApp, $number++);

                $sucesso = $objUpload->upload('/var/www/html/app-sao-roque-e-voce/back-end/img/imgApp');

                array_push($pathImages, $objUpload->getBasename());
                //Instacia de redimencionamento
                $objResize = new Resize('/var/www/html/app-sao-roque-e-voce/back-end/img/imgApp/'.$objUpload->getBasename());

                $objResize->resize(250,);

                $objResize->save('/var/www/html/app-sao-roque-e-voce/back-end/img/imgApp/'.$objUpload->getBasename(),70);

                if($sucesso){
                    //echo 'Arquivo <strong>'.$objUpload->getBasename().'</strong> enviado com sucesso!';

        
                    continue;
                }else{

                    $validate->setErro('Erro ao enviar o arquivo <br>');
                }

               
            
            }

            if(count($validate->getErro()) > 0){
                echo $validate->getErro();
                
            }else{

                ScreenSrv::insertPathImageDataBase($app,$pathImages);

                return self::getScreen();
            }

            

           //exit;
            
        }
       

    }

    private static function insertPathImageDataBase($app, $pathImages){

        $app = Help::helpApp();
        $appSegmento = Help::helpGetEntity($app); 
        
      

        switch ($app->segmento) {
            case 'gastronomia':
                return help::helpImgGastronomia($app, $appSegmento,$pathImages);

            case 'evento':
                return help::helpImgEvento($app, $appSegmento,$pathImages);

            case 'servicos':
                return help::helpImgServico($app, $appSegmento,$pathImages);

            case 'comercio':
                return help::helpImgComercio($app, $appSegmento,$pathImages);

            case 'hospedagem':
                return help::helpImgHospedagem($app, $appSegmento,$pathImages);

            case 'turismo':
                return help::helpImgGastronomia($app, $appSegmento,$pathImages);
           
        }


    }




}