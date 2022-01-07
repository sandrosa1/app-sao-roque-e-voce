<?php

namespace App\Controller\Srv;

use \App\Utils\View;
use \App\Model\Entity\Customer\Customer as EntityCustomer;
use \App\Validate\Validate as Validate;
use \App\Password\Password as PasswordHash;

class NewPasswordSrv extends PageSrv {

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
            // "tentativas" => $objCustomer->countAttempt()
        ];
        
        return json_encode($arrResponse);
    }

    /**
    * Metodo que verifica a validação do cadastro
    *
    * @param Request $request
    * @return string
    */
    public static function getNewPassword($request){

    $getVars = $request->getQueryParams();

    $email = $getVars['email'];
    $validateToken = $getVars['token'];

    $newPassword = new EntityCustomer;

    //Verifica se existe o cadastro
    $objCustomer = $newPassword->getCustomerByEmail($email);
    $objCustomerToken = $newPassword->getCustomerToken($email);
    $objCustomerId = $objCustomer->idUser;

    if(!$objCustomer instanceof EntityCustomer){
        $content = View::render('srv/redefinr_senha',[

            'status' => '<span class="srv-c-4 m-3">Email não encontrado</span>'
    
        ]);
        return parent::getPage('SRV - Login',$content);

    }

    if($objCustomerToken->token !=  $validateToken ||  $validateToken == ''){

        $content = View::render('srv/redefinir_senha',[

            'status' => '<span class="srv-c-4 m-3">Token invalido</span>'
    
        ]);
        return parent::getPage('SRV - Login',$content);

    }

    //Conteúde da pagina de login
    $content = View::render('srv/nova_senha',[

        'status' => $objCustomerId 
    ]);

        return parent::getPage('SRV - Login',$content);

    }

    /**
     * Método resposavel por definir o login do usuario
     *
     * @param Request $request
     * @return void
     */
    public static function setNewPassword($request){


        $dadosPost = [];
        $postVars = $request->getPostVars();
        $dadosPost[0] = $idUser               = $postVars['iduser'] ?? '';
        $dadosPost[1] = $password            = $postVars['password'] ?? '';
        $dadosPost[2] = $passwordConf            = $postVars['passwordconf'] ?? '';
        $dadosPost[3] = $gRecaptchaResponse  = $postVars['g-recaptcha-response'] ?? '';

        $validate = new Validate();

        $objCustomer = new EntityCustomer();

        if(!$validate->validateFields($dadosPost))
        {
            return self:: responseError($validate,$objCustomer);
        }
        if(!$validate->validateConfSenha($password, $passwordConf)){

            return self:: responseError($validate,$objCustomer);
        }
        if(!$validate->validateStrongSenha($password)){

            return self:: responseError($validate,$objCustomer);
        }
       
        if(!$validate->validateCaptcha($gRecaptchaResponse)){

            return self:: responseError($validate,$objCustomer);
        }

        $hashPassword = new PasswordHash();
        $objCustomer->password = $hashPassword->passwordHash($password);
        $objCustomer->idUser = $idUser ;

        $objCustomer->updatePassword();
       

        if(count($validate->getErro()) >0){
            $objCustomer->insertAttempt();
            $arrResponse = [
               "retorno" => "erro",
               "erros"   => $validate->getErro(),
            //    "tentativas" => $validate->tentativas
           ];

        }else{
            $objCustomer->deleteAttempt();
            
            $arrResponse = [
               "retorno" => "success",
               "page"    => "login",
               "success" => ["Nova senha cadastrada"]
            //    "tentativas"   => $validate->tentativas
           ];
         
        }
        return json_encode($arrResponse);
    }
    

}