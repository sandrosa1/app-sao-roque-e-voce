<?php

namespace App\Controller\RACS;

use \App\Utils\View;
use \App\Model\Entity\RACS\RACS as EntityRACS;
use \App\Controller\Validate\Validate as Validate;
use \App\Session\RACS\LoginRACS as SessionRACS;

class Login extends Page{
    /**
     * Guardo os erro da validaçao
     *
     * @var array
     */
    private $erro=[];
   
    /**
     * Metódo responsavel por retonar o erro para o cliente
     *
     * @param objetc $validate
     * @return void
     */
    private static function responseError($validate, $objRACS){

        $objRACS->insertAttempt();
        $arrResponse=[
            "retorno" => "erro",
            "erros"   => $validate->getErro(),
            //"tentativas" => $objRACS->countAttempt()
        ];
        return json_encode($arrResponse);
    }
    /**
     * Método resposavel por definir o login do usuario
     *
     * @param Request $request
     * @return void
     */
    public static function setLogin($request){
       

        $dadosLogin = [];
        $postVars = $request->getPostVars();
        $dadosLogin[0] = $email               = $postVars['email'] ?? '';
        $dadosLogin[1] = $password            = $postVars['password'] ?? '';
        $dadosLogin[2] = $gRecaptchaResponse  = $postVars['g-recaptcha-response'] ?? '';

    
        $validate = new Validate();
       
        $objRACS = new EntityRACS();
       

        if(!$validate->validateFields($dadosLogin))
        {
            return self:: responseError($validate, $objRACS);
        }
        if(!$validate->validateEmail($email)){

            return self:: responseError($validate, $objRACS);
        }
        if(!$validate->validateIssetEmail($email,"login")){

            return self:: responseError($validate, $objRACS);
        }
        if(!$validate->validateSenha($email,$password)){

            return self:: responseError($validate, $objRACS);
        }
        
        if(!$validate->validateCaptcha($gRecaptchaResponse)){

            return self:: responseError($validate, $objRACS);
        }

        if(!$validate->validateAttemptLogin($objRACS)){

            return self:: responseError($validate, $objRACS);
        }
        
        
        if(count($validate->getErro()) >0){
            $objRACS->insertAttempt();
            $arrResponse=[
               "retorno" => "erro",
               "erros"   => $validate->getErro(),
               //"tentativas" => $validate->tentativas
           ];

        }else{
            $objRACS->deleteAttempt();
            //Busca cliente pelo email
            $objRacs = EntityRACS::getRACSByEmail($email);
            SessionRACS::login($objRacs);
        
            $arrResponse=[
               "retorno" => 'success',
               "page" => 'home',
               //"tentativas"   => $validate->tentativas
           ];
         
        }
        return json_encode($arrResponse);
    }
    /**
     * Método responsável por retornar a rederização da paǵina de login
     *
     * @param Request $request
     * @param string $errorMessager
     * @return string
     */
    public static function getLogin($request) {

        $queryParams = $request->getQueryParams();
        
        //Status
        if(isset($queryParams['status'])){

            $content = View::render('racs/login',[
            
            ]);
        }else{

            $content = View::render('racs/login',[
                'status' => ''
            ]);

        }
        
        //Retona a página completa
        return parent::getPage('RACS - Login',$content);
       
    }
    /**
     * Método reponsável por deslogar o cliente
     *
     * @param Request $request
     * @return void
     */
    public static function setLogout($request){

        //Destroi a sessão de login
        SessionRACS::logout();

        //Redireciona o usuário para a página de login
        $request->getRouter()->redirect('/racs/login');
    }

}