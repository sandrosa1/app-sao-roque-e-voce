<?php

namespace App\Controller\Srv;

use \App\Utils\View;
use \App\Model\Entity\Customer\Customer as EntityCustomer;
use \App\Validate\Validate as Validate;
use \App\Session\Srv\LoginCustomer as SessionCustomer;

class LoginSrv extends PageSrv{
    /**
     * Guardo os erro da validaçao
     *
     * @var array
     */
    private $erro=[];
    /**
     * Instancia de login
     *
     * @var object
     */
    private $objCustomer;
    /**
     * Guarda a quantidade de tentativas de login
     *
     * @var integer
     */
    private $tentativas;
    /**
     * Construtor que inicia as Instancias
     */
    public function __construct()
    {
        $this->objCustomer = new EntityCustomer();
        
    }
    /**
     * Retorna o erro
     *
     * @return array
     */
    public function getErro()
    {
        return $this->erro;
    }
    /**
     * Guardo 0 erro no array
     *
     * @param array $erro
     * @return void
     */
    public function setErro($erro)
    {
        array_push($this->erro,$erro);
    }
    
    /**
     * Metódo responsavel por retonar o erro para o cliente
     *
     * @param objetc $validate
     * @return void
     */
    private static function responseError($validate, $objCustomer){

        $objCustomer->insertAttempt();
        $arrResponse=[
            "retorno" => "erro",
            "erros"   => $validate->getErro(),
            "tentativas" => $objCustomer->countAttempt()
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
        $objCustomer = new EntityCustomer();

        if(!$validate->validateFields($dadosLogin))
        {
          
            return self:: responseError($validate, $objCustomer);
        }
        if(!$validate->validateEmail($email)){

            return self:: responseError($validate, $objCustomer);
        }
        if(!$validate->validateIssetEmail($email,"login")){

            return self:: responseError($validate, $objCustomer);
        }
        if(!$validate->validateSenhaCustomer($email,$password)){

            return self:: responseError($validate, $objCustomer);
        }
        
        if(!$validate->validateCaptcha($gRecaptchaResponse)){

            return self:: responseError($validate, $objCustomer);
        }

        if(!$validate->validateUserActive($email,$objCustomer)){

            return self:: responseError($validate, $objCustomer);
        }
        if(!$validate->validateAttemptLogin($objCustomer)){

            return self:: responseError($validate, $objCustomer);
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
            //Busca cliente pelo email
            $customer = EntityCustomer::getCustomerByEmail($email);
            SessionCustomer::login($customer);
        
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

            $content = View::render('srv/login',[
            
            ]);
        }else{

            $content = View::render('srv/login',[
                'status' => ''
            ]);

        }
        
        //Retona a página completa
        return parent::getPage('SRV - Login',$content);
       
    }
    /**
     * Método reponsável por deslogar o cliente
     *
     * @param Request $request
     * @return void
     */
    public static function setLogout($request){

        //Destroi a sessão de login
        SessionCustomer::logout();

        //Redireciona o usuário para a página de login
        $request->getRouter()->redirect('/srv/login');
    }

}