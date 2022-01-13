<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Customer\Customer as EntityCustomer;
use \App\Validate\Validate as Validate;
use \App\Password\Password as PasswordHash;


class Cadastro extends Page{
    /**
     * Metódo responsavel por inserir um novo cliente;
     *
     * @param Request $request
     * @return Response
     */
    public static function insertRegistration($request){ 
    
        //Recebe as variavei do request
        $postVars = $request->getPostVars();
        //Intancia um novo cliente
        $objCadastro = new EntityCustomer;
        $validate = new Validate();

        $cadastro = []; 
        $cadastro[0] = $objCadastro->name = $postVars['name']; 
        $cadastro[1] = $objCadastro->cpf = $postVars['cpf']; 
        $cadastro[2] = $objCadastro->email = $postVars['email']; 
        $cadastro[3] = $objCadastro->phone = $postVars['phone']; 
        $cadastro[4] = $objCadastro->birthDate = $postVars['birthDate']; 
        $cadastro[5] = $postVars['password']; 
        $cadastro[6] = $postVars['passwordConf'];
        $cadastro[7] = $postVars['g-recaptcha-response']; 
        $cadastro[8] = $objCadastro->token = bin2hex(random_bytes(64));
        $objCadastro->createDate = date('Y-m-d H:i:s');
        $objCadastro->permission = "user";
        $objCadastro->status = "confirmation";
        //VALIDAÇÂO DO FORMULARIO
        $validate->validateFields($cadastro);
        $validate->validateConfSenha($cadastro[5],$cadastro[6]);
        $validate->validateStrongSenha($cadastro[5]);
        $validate->validateIssetEmail($cadastro[2]);
        $validate->validateEmail($cadastro[2]);
        $validate->validateCPF($cadastro[1]);
        $validate->validateData($cadastro[4]);
        $validate->validateCaptcha($cadastro[7]);

        
        //ENVIA O EMAIL SE NÃO HOUVER ERROS
        if(count($validate->getErro()) >= 0){
            $address = $objCadastro->email;
            $subject = 'Confirmação de cadastro';
            $body = "<b>Sejá bem vindo ao São Roque e Vocẽ {$objCadastro->name}.<b><br><br>
            <b>Para finalizar seu cadastro</b><a href='http://www.racsstudios.com/srv/confirmation?email={$objCadastro->email}&token={$objCadastro->token}'> click aqui</a><br><br>
            <img src='http://www.racsstudios.com/img/assinatura-400.png' alt='Logomarca da WEF'>";
           
            $validate->ValidateSendEmail($address,$subject,$body);
        }

        //Instacia a classe de senha para criptografala
        $hashPassword = new PasswordHash();
        $objCadastro->password = $hashPassword->passwordHash($cadastro[5]);

       //VERIFICA SE A ERROS OU NÂO
        if(count($validate->getErro()) > 0){
            $arrResponse=[
                "retorno" => "erro",
                "erros"   => $validate->getErro()
            ];
            
        }else{
            $arrResponse=[
                "retorno" => "success",
                "page"    => "srv/login",
                "success" => ["Cadastro realizado com sucesso.","Você recebera um email de confimação no email cadastro.","Verifique na caixa de span ou lixo eletronico."]
            ];   
          
            $objCadastro->insertNewCustomer();

        }
        echo json_encode($arrResponse);
   
    }
    /**
    * Método respónsavel por retornar a view de cadastro de um novo cliente
    *
    * @param Request $request
    * @return string
    */
    public static function getCadastro($request){

        $content = View::render('pages/cadastro',[
         //Pode coloca itens dinamicos no cadastro
         
        ]);

        return parent::getPage('Cadastro - RACS',$content );
    }
        

 
}