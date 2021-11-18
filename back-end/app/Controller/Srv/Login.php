<?php

namespace App\Controller\Srv;

use \App\Utils\View;
use \App\Model\Entity\Customer\Customer as EntityCustomer;
use \App\Controller\Password\Password as PasswordHash;
use \App\Session\Srv\LoginCustomer as SessionCustomer;

class Login extends Page{
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
     * Validar se os campos desejados foram preenchidos
     *
     * @param Post $par
     * @return boolean
     */
    public function validateFields($par)
    {
        $i=0;
        foreach ($par as $key => $value){
            if(empty($value)){
                $i++;
            }
        }
        if($i==0){
            return true;
        }else{
            $this->setErro("Preencha todos os dados!");
            return false;
        }
    }

     /**
     *  Validação se o dado é um email
     *
     * @param string $par
     * @return boolean
     */
    public function validateEmail($par)
    {
        if(filter_var($par, FILTER_VALIDATE_EMAIL)){
            return true;
        }else{
            $this->setErro("Email inválido!");
            return false;
        }
    }
    /**
     * #Validar se o email existe no banco de dados (action null para cadastro)
     *
     * @param string $email
     * @param string $action
     * @return boolean
     */
    public function validateIssetEmail($email,$action=null)
    {
        $userEmail = EntityCustomer::getCustomerByEmail($email);

        if($action==null){
            if($userEmail > 0){
                $this->setErro("Email já cadastrado!");
                return false;
            }else{
                return true;
            }
        }else{
            if($userEmail > 0){
                return true;
            }else{
                $this->setErro("Email não cadastrado!");
                return false;
            }
        }
    }
    /**
     * Validação das tentativas
     *
     * @return boolean
     */
    public function validateAttemptLogin()
    {
        if($this->objCustomer->countAttempt() >= 5){
            $this->setErro("Você realizou mais de 5 tentativas!");
            $this->tentativas = true;
            return false;
        }else{
            $this->tentativas = false;
            return true;
        }
    }
    /**
     *Método de validação de confirmação de email
     *
     * @param string $email
     * @return boolean
     */
    public function validateUserActive($email)
    {
        $IsCustomerActive = $this->objCustomer->getDataUser($email);

        if($IsCustomerActive ["data"]["status"] == "confirmation"){

            if(strtotime($IsCustomerActive ["data"]["dataCriacao"])<= strtotime(date("Y-m-d H:i:s"))-432000){

                $this->setErro("Ative seu cadastro pelo link do email");

                return false;
            }else{

                return true;
            }
        }else{

            return true;
        }
    }
    /**
     * #Verificar se o captcha está correto
     *
     * @param string $captcha
     * @param float $score
     * @return void
     */
    public function validateCaptcha($captcha,$score=0.5)
    {
        $secretkey = getenv('SECRETKEY');
      
        $return=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretkey}&response={$captcha}");
        $response = json_decode($return);
        if($response->success == true && $response->score >= $score){
            return true;
        }else{
            $this->setErro("Captcha Inválido! Atualize a página e tente novamente.");
            return false;
        }
    }
    /**
     * Verificação da password digitada com o hash no banco de dados
     *
     * @param string $email
     * @param string $password
     * @return boolean
     */
    public function validateSenha($email,$password)
    {
        $hash = new PasswordHash();

        if($hash->verifyHashCustomer($email,$password)){
            return true;

        }else{

            $this->setErro("Usuário ou Senha Inválidos!");
            return false;
        }
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

        $validate = new Login();
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
        if(!$validate->validateSenha($email,$password)){

            return self:: responseError($validate, $objCustomer);
        }
        
        if(!$validate->validateCaptcha($gRecaptchaResponse)){

            return self:: responseError($validate, $objCustomer);
        }

        if(!$validate->validateUserActive($email)){

            return self:: responseError($validate, $objCustomer);
        }
        if(!$validate->validateAttemptLogin()){

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