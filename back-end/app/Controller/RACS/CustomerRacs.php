<?php

namespace App\Controller\RACS;

use \App\Utils\View;
use \App\Help\HelpEntity;
use \App\Help\Help;
use \App\Model\Entity\Aplication\App as EntityApp;
use \App\Model\Entity\Customer\Customer as EntityCustomer;
use \App\Validate\Validate;

class CustomerRacs extends PageRacs{

    /**
     * Renderiza o conteúdo da view de clientes 
     * 
     *
     * @param Request $request
     * @return string
     */
    public static function getCustomers($request){

        $getVars = $request->getQueryParams();

        if($getVars['block']){

           $msg = self::blockApp($getVars['block']);
        }

        if($getVars['open']){

            $msg = self::openApp($getVars['open']);
        }
        
        if($getVars['idApp']){

            

            $entityApp = EntityApp::getAppById($getVars['idApp']);
            $appTurismo = HelpEntity::helpGetEntity($entityApp);

            $content = View::render('racs/modules/customer/index',[
                'tabelaClientes'     => self::getTabelaClientes(),
                'tabelaApps'         => self::getTabelaApps('app'),
                'tabelaHospedagens'  => self::getTabelaApps('hospedagem'),
                'tabelaTurismo'      => self::getTabelaApps('turismo'),
                'tabelaGastronomia'  => self::getTabelaApps('gastronomia'),
                'tabelaEventos'      => self::getTabelaApps('evento'),
                'tabelaComercio'     => self::getTabelaApps('comercio'),
                'tabelaServicos'     => self::getTabelaApps('servicos'),
                'infoCliente'        => self::getInfoCustomer($entityApp,$appTurismo),
                'previewApps'        => self::getDisplayAppRacs($entityApp,$appTurismo),
                'previewHospedagens' => self::getDisplayAppRacs($entityApp,$appTurismo),
                'previewTurismo'     => self::getDisplayAppRacs($entityApp,$appTurismo),
                'previewGastronomia' => self::getDisplayAppRacs($entityApp,$appTurismo),
                'previewEventos'     => self::getDisplayAppRacs($entityApp,$appTurismo),
                'previewComercio'    => self::getDisplayAppRacs($entityApp,$appTurismo),
                'previewServicos'    => self::getDisplayAppRacs($entityApp,$appTurismo),
            ]);

        }else{

            $content = View::render('racs/modules/customer/index',[
                'tabelaClientes'     => self::getTabelaClientes(),
                'tabelaApps'         => self::getTabelaApps('app'),
                'tabelaHospedagens'  => self::getTabelaApps('hospedagem'),
                'tabelaTurismo'      => self::getTabelaApps('turismo'),
                'tabelaGastronomia'  => self::getTabelaApps('gastronomia'),
                'tabelaEventos'      => self::getTabelaApps('evento'),
                'tabelaComercio'     => self::getTabelaApps('comercio'),
                'tabelaServicos'     => self::getTabelaApps('servicos'),
                'infoCliente'        => '',
                'previewApps'        => self::getDisplayAppRacs(false,false),
                'previewHospedagens' => self::getDisplayAppRacs(false,false),
                'previewTurismo'     => self::getDisplayAppRacs(false,false),
                'previewGastronomia' => self::getDisplayAppRacs(false,false),
                'previewEventos'     => self::getDisplayAppRacs(false,false),
                'previewComercio'    => self::getDisplayAppRacs(false,false),
                'previewServicos'    => self::getDisplayAppRacs(false,false),
            ]);

        }

        
            return parent::getPanel('Customer - RACS', $content,'customer',$msg);

    }

    private static function blockApp($idApp){

        $app = EntityApp::getAppById($idApp);

        if(self::alertblockCustomer($idApp)){

            $app->status = 'block';

            if($app->updateApp()){

                $msg = "Pagina bloqueado com sucesso.";
    
                 return $msg;
            }else{

                $msg = "Erro ao bloquear, email enviado ao cliente.";
    
                return $msg;

            }   

        }else{

            $msg = "Ocorreu um problema no envio do e-mail";

            return $msg;
        }



    }

    private static function openApp($idApp){

        $app = EntityApp::getAppById($idApp);

        if(self::alertOpenCustomer($idApp)){

            $app->status = 'ativo';

            if($app->updateApp()){

                $msg = "Pagina liberada com sucesso.";
    
                 return $msg;
            }else{

                $msg = "Erro ao liberar, email enviado ao cliente.";
    
                return $msg;

            }   

        }else{

            $msg = "Ocorreu um problema no envio do e-mail";

            return $msg;
        }

        
    }

    private static function alertblockCustomer($idApp){

        $customer = EntityCustomer::getCustomerById($idApp);

        $validate = new Validate();

        $address = $customer->email;

        $subjet = "Alerta de bloqueio de conteúdo São Roque e Você.";

        $body = "<h5>Atenção pagina bloqueada.</h5>
        <p>Olá  $customer->name</p>
        <p>Sua página no sistema São Roque e Você foi bloqueada por conteúdo malicioso, pedimos que a modifique e entre em contato pelo fale conosco, assunto página bloqueada, para habilitá-la novamente.
        A mensagem deve explicar o que ocasionou esse contéudo.</p>
       
        <br><br><br>
        <p>Atenciosamente:</p>
        <img src='http://www.racsstudios.com/img/logo-srv-300.png' alt='Logotipo do aplicativo São roque e vocẽ'>";


        if(!$validate->validateSendEmail($address, $subjet, $body, $customer->name)){

            return false;
        }

        return true;

    }

    private static function alertOpenCustomer($idApp){

        $customer = EntityCustomer::getCustomerById($idApp);

        $validate = new Validate();

        $address = $customer->email;

        $subjet = "Alerta de desbloqueio de conteúdo São Roque e Você.";

        $body = "<h5>Parabéns sua página foi desbloqueada.</h5>
        <p>Olá  $customer->name</p>
        <p>Sua página no sistema São Roque e Você foi desbloqueada, agradecemos a colaboração.</p>
       
        <br><br><br>
        <p>Atenciosamente:</p>
        <img src='http://www.racsstudios.com/img/logo-srv-300.png' alt='Logotipo do aplicativo São roque e vocẽ'>";


        if(!$validate->validateSendEmail($address, $subjet, $body, $customer->name)){

            return false;
        }

        return true;

    }

    /**
     * Retorna a lista de clientes
     *
     * @return string
     */
    private static function getTabelaClientes(){

       return View::render('racs/modules/customer/components/tabela/theadClientes',[
            'tbodyClientes'=> self::getTbodyClientes(),
       ]);
    }


    private static function getTbodyClientes(){

        $customers = HelpEntity::hellGetAllsCustomers();

        $content = '';

        $modal = 0;
 
        foreach ($customers as $key => $value) {
 
            $content .= View::render('racs/modules/customer/components/tabela/tbodyClientes',[

                'nome'         => $value['name'],
                'email'        => $value['email'],
                'phone'        => $value['phone'],
                'createDate'   => $value['createDate'],
                'status'       => $value['status'],
                'idApp'        => $value['idApp'],
                'modal'        =>$modal.''
            ]);

            $modal ++;
            
         
        }
         return $content ;
    }

    private static function getTabelaApps($segmento){

        return View::render('racs/modules/customer/components/tabela/theadApps',[
            
            'tbodyApps' => self::getTbodySegmento($segmento),
        ]);
     }


    private static function getTbodySegmento($segmento){

        $apps = HelpEntity::hellGetAllsApps();

        $content = '';
 
        $modal = 0;
        foreach ($apps as $key => $value) {
 
            if($segmento == $value['segmento'] || $segmento == 'app'){

                if($value['status'] == 'block'){
                    $content .= View::render('racs/modules/customer/components/tabela/tbodyAppsBlock',[

                        'nomeFantasia' => $value['nomeFantasia'],
                        'segmento'     => ucwords($value['segmento']),
                        'tipo'         => $value['tipo'],
                        'celular'      => $value['celular'],
                        'email'        => $value['email'],
                        'idApp'        => $value['idApp'],
                        'modal'        =>$modal.$segmento
                    ]);


                }else{

                    $content .= View::render('racs/modules/customer/components/tabela/tbodyApps',[

                        'nomeFantasia' => $value['nomeFantasia'],
                        'segmento'     => ucwords($value['segmento']),
                        'tipo'         => $value['tipo'],
                        'celular'      => $value['celular'],
                        'email'        => $value['email'],
                        'idApp'        => $value['idApp'],
                        'modal'        =>$modal.$segmento
                    ]);
    
                }

               $modal ++;
            }
         
        }
         return $content ;
    }

    private static function getInfoCustomer($entityApp, $appTurismo){

            $customer = EntityCustomer::getCustomerById($entityApp->idApp);

            return View::render('racs/modules/customer/components/infoCliente/index',[

                'idUser' => $customer->idUser,
                'name' => $customer->name,
                'cpf' => $customer->cpf,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'birthDate' => $customer->birthDate,
                'permission' => $customer->permission,
                'status' => $customer->status,
                'nomeFantasia'=> $entityApp->nomeFantasia,
                'segmento' => $entityApp->segmento,
                'tipo' => $entityApp->tipo,
                'email' => $entityApp->email,
                'telefone' => $entityApp->telefone,
                'site' => $entityApp->site,
                'celular' => $entityApp->celular,
                'cep' => $entityApp->cep,
                'logradouro' => $entityApp->logradouro,
                'numero' => $entityApp->numero,
                'bairro' => $entityApp->bairro,
                'localidade' => $entityApp->localidade,
                'visualizacao' => $entityApp->visualizacao,

            ]);

    }
  
    private static function getDisplayAppRacs($app, $appTurismo){

        if($app && $appTurismo){

                if($app->segmento != 'servicos'){
    
                    return View::render('racs/modules/customer/preview/index',[
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
    
                    return View::render('racs/modules/customer/preview/servico',[
        
                        'display'    => self::getDisplay(),
                        'header'     => self::getHeader($app),
                        'informacoes'  => self::getServicos($app, $appTurismo),
                     
                    ]);
                }


        }else{

            return View::render('racs/modules/customer/preview/index',[

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

        return View::render('racs/modules/customer/preview/components/display',[
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
      
        return View::render('racs/modules/customer/preview/components/header',[
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
       
        return View::render('racs/modules/customer/preview/components/nome',[
            'nome'=> $app->nomeFantasia,
        ]);
    }
    /** 
    * Metódo que retorna o componente de status do preview do app
    *
    * @return string
    */
    private static function getStatus(){
      
        return View::render('racs/modules/customer/preview/components/status',[]);
    }
    /** 
    * Metódo que retorna o componente de carrocel de imagens do preview do app
    *
    * @return string
    */
    private static function getCarrocel($app, $appTurismo){

       
        return View::render('racs/modules/customer/preview/components/carrocel',[
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
                    $opcoes .= View::render('racs/modules/customer/preview/components/opcao',[
                        'value' => $value,
                         'nome'  => $nome,
                    ]);
                }
            }

        return View::render('racs/modules/customer/preview/components/seletores',[
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
       
        return View::render('racs/modules/customer/preview/components/descricao',[
            'descricao' => $appTipo->descricao,
        ]);
    }

     /** 
    * Metódo que retorna o componente de comentário do preview do app
    *
    * @return string
    */
    private static function getComentario(){
        
        
        return View::render('racs/modules/customer/preview/components/comentario',[
            
        ]);
    }

    /** 
    * Metódo que retorna o componente de endereço do preview do app
    *
    * @return string
    */
    private static function getAddress($app){

     
        return View::render('racs/modules/customer/preview/components/endereco',[
            
            'endereco' => "<div class='col  s12'><i class='ml-2 c-pri fz-15 fas fa-map-marked-alt'></i><span class=' c-popi fz-5'> ".$app->logradouro .', Nº '. $app->numero.', '.$app->bairro."</span></div>",
            'telefone' => $app->telefone ? "<div class='col  s12'><i class='ml-2 c-pri fz-15 fas fa-phone-volume'></i><span class=' c-popi fz-5'> ".$app->telefone."</span></div>": '',
            'site'     => $app->site ? "<div class='col  s12'><i class='ml-2 pb-5 c-pri fz-15 fas fa-globe'></i><span class=' c-popi fz-5'> ".$app->site."</span></div>" :'',
        ]);
    }


    /** 
    * Metódo que retorna o componente de serviços do preview do app
    *
    * @return string
    */
    private static function getServicos($entityApp, $appTurismo){

        return View::render('racs/modules/customer/preview/components/servicos',[
            
            'nome'       => $entityApp->nomeFantasia ? "<p class='c-popi fz-10 fwb'> ".$entityApp->nomeFantasia ."</p>":"",
            'endereco'   => "<i class='c-pri fz-15 fas fa-map-marked-alt'></i><span class=' c-popi fz-5'> ".$entityApp->logradouro .', Nº '. $entityApp->numero.', '.$entityApp->bairro."</span>",
            'telefone'   => $entityApp->telefone   ?"<i class='c-pri fz-15 fas fa-phone-volume'></i><span class=' c-popi fz-5'> ".$entityApp->telefone."</span>": '',
            'site'       => $entityApp->site       ?"<i class='pb-5 c-pri fz-15 fas fa-globe'></i><span class=' c-popi fz-5'> ".$entityApp->site."</span>" :'',
            'horarios'   => $appTurismo->semana ?"<p class=' c-popi fz-5'>Semana ".$appTurismo->semana."</p><p class=' c-popi fz-5'>Sabádo ".$appTurismo->sabado."</p><p class=' c-popi fz-5'>Domingo ".$appTurismo->domingo."</p><p class=' c-popi fz-5'>Fériados ".$appTurismo->feriado."</p>" : '',
            'logo'       => $entityApp->img1       ? "<img src='{{URL}}/img/imgApp/$entityApp->img1' alt='Imagem de logotipo'>" : '' ,
        ]);
    }

 
}

