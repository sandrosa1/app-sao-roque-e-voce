<?php

namespace App\Controller\RACS;

use \App\Utils\View;
use \App\Controller\Password\Password as PasswordHash;
use \app\Controller\Validate\Validate as Validate;
use \app\Model\Entity\RACS\RACS as EntityRACS;
use \app\Session\RACS\LoginRACS as SessionRACS;


class Login extends Page{
    /**
     * Guardo os erro da validação
     *
     * @var array
     */
    private $erro=[];
 
    /**
     * Metódo responsável por retonar o erro para o front-end
     *
     * @param objetc $validate
     * @return void
     */
    private static function responseError($validate, $objRACS){

        $objRACS->insertAttempt();
        $arrResponse=[
            "retorno" => "erro",
            "erros"   => $validate->getErro(),
            "tentativas" => $objRACS->countAttempt()
        ];

        return json_encode($arrResponse);
    }
    /**
     * Método responsável por definir o login do usuário
     *
     * @param Request $request
     * @return void
     */
    public static function setLogin($request){

        $dados = [];
        $postVars = $request->getPostVars();
        $dados[0] = $email               = $postVars['email'] ?? '';
        $dados[1] = $password            = $postVars['password'] ?? '';
        $dados[2] = $gRecaptchaResponse  = $postVars['g-recaptcha-response'] ?? '';

        $validate = new Validate();
        $objRACS = new EntityRACS();

        if(!$validate->validateFields($dados))
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

        if(!$validate->validateUserActive($email)){

            return self:: responseError($validate, $objRACS);
        }
        if(!$validate->validateAttemptLogin()){

            return self:: responseError($validate, $objRACS);
        }
       
        if(count($validate->getErro()) >0){
            $validate->objCustomer->insertAttempt();
            $arrResponse=[
               "retorno" => "erro",
               "erros"   => $validate->getErro(),
               "tentativas" => $validate->tentativas
           ];

        }else{
            $validate->objCustomer->deleteAttempt();
            //Busca usuário pelo email
            $customer = EntityRACS::getRACSByEmail($email);
            SessionRACS::login($customer);
        
            $arrResponse=[
               "retorno" => 'success',
               "page" => 'home',
               "tentativas"   => $validate->tentativas
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
     * Método reponsável por deslogar o usuário
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