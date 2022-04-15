<?php
namespace App\Validate;

use \App\Model\Entity\Customer\Customer as EntityCustomer;
use \App\Model\Entity\Aplication\App as EntityApp;
use \App\Model\Entity\Aplication\Help\Help as EntiityHelp;
use \App\Help\Help;
use \App\Password\Password as PasswordHash;
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
     * @param Post $parameters
     * @return boolean
     */
    public function validateFields($parameters)
    {
        $i = 0;
        foreach ($parameters as $key => $value){
            if(empty($value)){
                $i++;
            }
        }
        if($i == 0){
            return true;
        }else{
            $this->setErro("Preencha todos os dados!");
            return false;
        }
    }

     /**
     *  Validação se o dado é um email
     *
     * @param string $email
     * @return boolean
     */
    public function validateEmail($email)
    {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
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
    public function validateSendEmail($address,$subject,$body, $name){

        

        $objEmail = new Email;
        $success = $objEmail->sendEmail($address,$subject,$body,$name);
     
        if(!$success){

            $this->setErro($objEmail->getError());
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
    public function validateSenhaCustomer($email,$password)
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
     * Verificação da password digitada com o hash no banco de dados
     *
     * @param string $email
     * @param string $password
     * @return boolean
     */
    public function validateSenhaRacs($email,$password)
    {
        $hash = new PasswordHash();

        if($hash->verifyHashRacs($email,$password)){
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
     * @param entity $entity
     * @return boolean
     */
    public function validateUserActive($email,$entity)
    {
        $IsActive = $entity->getDataUser($email);

        if($IsActive ["data"]["status"] == "confirmation"){

            if(strtotime($IsActive ["data"]["dataCriacao"])<= strtotime(date("Y-m-d H:i:s"))-432000){

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
    public function validateAttemptLogin($entity)
    {
        if($entity->countAttempt() >= 5){
            $this->setErro("Você realizou mais de 5 tentativas!");
            $this->tentativas = true;
            return false;
        }else{
            $this->tentativas = false;
            return true;
        }
    }

     //https://gist.github.com/rafael-neri/ab3e58803a08cb4def059fce4e3c0e40
    /**
     * Validação se é um cpf real
     *
     * @param string $cpf
     * @return boolean
     */
    function validateCPF($cpf) {
    
        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
        
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            $this->setErro("Cpf Inválido!");
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            $this->setErro("Cpf Inválido!");
            return false;
        }

        // Faz o calculo para validar o CPF
        //https://campuscode.com.br/conteudos/o-calculo-do-digito-verificador-do-cpf-e-do-cnpj
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                $this->setErro("Cpf Inválido!");
                return false;
            }
        }
        return true;

    }

      /**
     * #Validação se o dado é uma data
     *
     * @param date $par
     * @return boolean
     */
    public function validateData($date)
    {
        $dateFormat = \DateTime::createFromFormat("d/m/Y",$date);
        if(($dateFormat) && ($dateFormat->format("d/m/Y") === $date)){
            return true;
        }else{
            $this->setErro("Data inválida!");
            return false;
        }
    }

    /**
     * Method reponsável por validar o cep
     *
     * @param string $cep
     * @return boolean
     */
    public function validadeCep($cep){
         $result = preg_replace('/\D/','',$cep);
        
        if(strlen(strval($result)) == 8){
            return true;
     
        }else{
            $this->setErro('CEP invalido!');
            return false;
        }
    }

    /**
     * Method reponsável por validar o cep
     *
     * @param string $celular
     * @return boolean
     */
    public function validadeCelular($celular){
        $result = preg_replace('/\D/','',$celular);
       
       if(strlen(strval($result)) == 11){
           return true;
    
       }else{
           $this->setErro('Número do celular invalido!');
           return false;
       }
   }

   /**
     * Method reponsável por validar o cep
     *
     * @param string $telefone
     * @return boolean
     */
    public function validadeTelefone($telefone){
        $result = preg_replace('/\D/','',$telefone);
       
       if(strlen(strval($result)) == 10){
           return true;
    
       }else{
           $this->setErro('Número de telefone invalido!');
           return false;
       }
   }

    public static function validateHoraAux($input) 
    {
        $format = 'H:i';

        $date = \DateTime::createFromFormat('!'. $format, $input);

        return $date && $date->format($format) === $input;
    }

   public function validateHora($text){

        if($text == 'Fechado'){

            return true;
        }
        $result = preg_replace('/\D/','',$text);

        if(strlen(strval($result)) != 8){

            $this->setErro('Formato de data inválido!');
            return false;

        }
        $datas = explode(" - ", $text);
        
        foreach ($datas as $data) {

            if(self::validateHoraAux($data)){

                return true;
            }else{

                $this->setErro('Formato de data inválido!');
                return false;
            }
        }
   }

   /**
     * Metódo responsável por retornar uma string separada por virgúlo
     *
     * @param array $array
     * @return string
     */
    public function validateBlockedWord($words){

        $result = [];
        foreach($words as $word){
            
            $entityBlockedWord = EntiityHelp::getHelpBlockedWord($word);
            if($entityBlockedWord){
                array_push($result, $entityBlockedWord->blockedWord);
               
            }
        }

        if(count($result) <= 0){

            return true;

         }else{
            $blockedWords = Help::helpArrayForString($result);
            $this->setErro('Não foi possível atualizar!');
            $this->setErro('Palavra(s) "'.$blockedWords.'" são imprópria(s)!');
            return false;

         }

    }

    /**
     * Método responsável por verificar se existe celular, email ou telefone já cadastrado
     *
     * @param string $email
     * @param string $celular
     * @param string $telefone
     * @return boolean
     */
    public function validateIssetAppFields($idApp, $email, $celular, $telefone )
    {
        $appEmail = EntityApp::getAppByEmail($email);
        $appCelular = EntityApp::getAppByCelular($celular);
        $appTelefone = EntityApp::getAppByTelefone($telefone);
        $app = EntityApp::getAppById($idApp);
        $erro = 0;
        if(!$app instanceof EntityApp){
            if( $appEmail instanceof EntityApp){
                $this->setErro('Email já cadastrado!');
                $erro ++;
            }
            if($telefone){
                
                if( $appTelefone instanceof EntityApp){
                    $this->setErro('Número de telefone já cadastrado!');
                    $erro ++;
                }
               
            }
        
            if( $appCelular instanceof EntityApp){
                $this->setErro('Número de celular já cadastrado!');
                $erro ++;
            }
            
        }else{
            if( $appEmail instanceof EntityApp && $appEmail->idApp != $app->idApp){
                $this->setErro('Email já cadastrado!');
                $erro ++;
            }
            if($telefone){
                
                if( $appTelefone instanceof EntityApp && $appTelefone->idApp != $app->idApp){
                    $this->setErro('Número de telefone já cadastrado!');
                    $erro ++;
                }
               
            }
        
            if( $appCelular instanceof EntityApp && $appCelular->idApp != $app->idApp){
                $this->setErro('Número de celular já cadastrado!');
                $erro ++;
            }
        }
        
       
        if($erro > 0){

            return false;
        }
        return true;

    }
     
}

