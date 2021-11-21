<?php
namespace App\Controller\Validate;

use \App\Model\Entity\Customer\Customer as EntityCustomer;
use \App\Controller\Password\Password as PasswordHash;
use ZxcvbnPhp\Zxcvbn;
use \App\Communication\Email;

class Validate{

    /**
     * Guardo os erro da validaçao
     *
     * @var array
     */
    private $erro=[];

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
     * Metódo responsavel por enviar o email 
     *
     * @param string $address
     * @param string $subject
     * @param string $body
     * @return boolean
     */ 
    public function validateSendEmail($address,$subject,$body){

        $objEmail = new Email;
        $sucess = $objEmail->sendEmail($address,$subject,$body);

        if(!$sucess){

            $this->setErro("Problemas no envio de email de confirmação.");
            return false;

        }
        return true;

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
     * Verificar se a senha é igual a confirmação de senha
     *
     * @param string $senha
     * @param string $senhaConf
     * @return boolean
     */
    public function validateConfSenha($senha,$senhaConf)
    {
        if($senha === $senhaConf){
            return true;
        }else{
            $this->setErro("Senha diferente de confirmação de senha!");
            return false;
        }
    }

     /**
     *  Verificar a força da senha(par==null para cadastro)
     *
     * @param string $senha
     * @param string $par
     * @return boolean
     */
    public function validateStrongSenha($senha)
    {
        $zxcvbn=new Zxcvbn();
        $strength = $zxcvbn->passwordStrength($senha);
        // echo $strength['score'].'<br>';
        if($strength['score'] >= 3){

            return true;

        }else{

            $this->setErro("Utilize uma senha mais forte!");

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
        $IsCustomerActive = $this->objRacs->getDataUser($email);

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
     * Validação das tentativas
     *
     * @return boolean
     */
    public function validateAttemptLogin()
    {
        if($this->objRacs->countAttempt() >= 5){
            $this->setErro("Você realizou mais de 5 tentativas!");
            $this->tentativas = true;
            return false;
        }else{
            $this->tentativas = false;
            return true;
        }
    }



}