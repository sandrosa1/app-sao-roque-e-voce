<?php

namespace App\Controller\Srv;

use \App\Utils\View;
use \App\Model\Entity\Customer\Customer as EntityCustomer;
use \App\Validate\Validate as Validate;

class RedefinePasswordSrv extends PageSrv{

    /**
     * Metódo responsavel por retonar o erro para o cliente
     *
     * @param Validate $validate
     * @return Response
     */
    private static function responseError($validate, $objCustomer){

        $objCustomer->insertAttempt();
        $arrResponse=[
            "retorno" => "erro",
            "erros"   => $validate->getErro(),
            "tentativas" => $validate->tentativas
        ];
        return json_encode($arrResponse);
    }
    /**
     * Metódo respósavel por validar e enviar email de renomear a senha
     *
     * @param Request $request
     * @return Response
     */
    public static function setRedefinePassword($request){


        $dados = [];
        $postVars = $request->getPostVars();
        $dados[0] = $email               = $postVars['email'] ?? '';
        $dados[1] = $gRecaptchaResponse  = $postVars['g-recaptcha-response'] ?? '';

      

        $validate = new Validate();
        $objCustomer = new EntityCustomer();

        if(!$validate->validateFields($dados))
        {
            return self:: responseError($validate, $objCustomer);
        }
        if(!$validate->validateEmail($dados[0])){

            return self:: responseError($validate, $objCustomer);
        }
        if(!$validate->validateIssetEmail($email,"redefine_password")){

            return self:: responseError($validate, $objCustomer);
        }
        if(!$validate->validateCaptcha($gRecaptchaResponse)){

            return self:: responseError($validate, $objCustomer);
        }

        $customer = EntityCustomer::getCustomerToken($email);
        $address = $customer->email;
        $token = $customer->token;
        $name = $customer->name;
        $subject = "Redefinir senha";
        $body ="<h1>Redefinir senha<h1>
        <br>
        <p>Olá {$customer->name}.</p>
        <p>Para criar uma nova senha <a href='http://www.racsstudios.com/srv/nova_senha?email={$email}&token={$token}'>Clique Aqui</a>.</p>
        <br><br><br>
        <img src='http://www.racsstudios.com/img/logo-srv-300.png' alt='Logotipo do aplicativo São roque e vocẽ'>";
       
        if(!$validate->validateSendEmail($address,$subject,$body,$name)){

            return self:: responseError($validate, $objCustomer);
        }
       
        if(count($validate->getErro()) > 0){
            $objCustomer->insertAttempt();
            $arrResponse=[
               "retorno" => "erro",
               "erros"   => $validate->getErro(),
               "tentativas" => $validate->tentativas
           ];

        }else{
            $objCustomer->deleteAttempt();
            $arrResponse=[
               "retorno" => 'success',
               "tentativas"   => $validate->tentativas,
               "page"   => 'login',
               "success" => ["Email enviado com sucesso.","Você recebera um email para redefinir sua senha.","Verifique na caixa de span ou lixo eletronico."]
           ];
         
        }
       
        return json_encode($arrResponse);
    }
    /**
     * Método responsável por retornar a rederização da paǵina de redefinição de senha
     *
     * @param Request $request
     * @param string $errorMessager
     * @return string
     */
    public static function getRedefinePassword($request) {

        $queryParams = $request->getQueryParams();

        //Status
        if(isset($queryParams['status'])){

            $content = View::render('srv/redefinir_senha',[
            
            ]);
        }else{

            $content = View::render('srv/redefinir_senha',[
                'status' => ''
            ]);

        }
        //Retona a página completa
        return parent::getPage('SRV - Redefinir Senha',$content);
       
    }

}