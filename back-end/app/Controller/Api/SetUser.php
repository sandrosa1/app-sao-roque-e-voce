<?php

namespace App\Controller\Api;

use \App\Model\Entity\User\User as EntityUser;
use \App\Validate\Validate;

class SetUser extends Api {

    /**
     * Inserí um novo comentário a um estabelecimento
     *
     * @param Request $request
     * @return array
     */
    public static function setUserApp($request){


        $validate = new validate();

        $postVars = $request->getPostVars();

        if(isset($postVars['newToken'])){

           
            if(!$validate->validateEmail($postVars['newToken'])){
                throw new \Exception("O email ". $postVars['email']." é inválido.", 404);
            }
    
            $objUser = EntityUser::getUserByEmail($postVars['newToken']);
    
            if(!$objUser instanceof EntityUser){
                throw new \Exception("Usuario: ".$postVars['newToken']." não encontrado.", 404);
            }

            $token = "";
            $min = 1000;
            $max = 9999;
            $token = (string)rand($min,$max);

            $objUser->token     = password_hash($token, PASSWORD_DEFAULT);
            $objUser->status    = "confirmacao";

            $address = $objUser->email;

            $subjet = "Reenvio do codígo de validação São Roque e Você.";
    
            $body = "<h5>Novo codígo de validação São Roque e Você.</h5>
            <p>Olá $objUser->nomeUsuario</p>
            <p>Este e seu novo codígo de validação</p>
            <p>CODIGO: $token</p>
            <br><br><br>
            <img src='http://www.racsstudios.com/img/logo-srv-300.png' alt='Logotipo do aplicativo São roque e vocẽ'>";
    
            if(!$validate->validateSendEmail($address, $subjet, $body, $objUser->nomeUsuario)){
                throw new \Exception("Ocorreu um problema na confirmação. Refazer o cadastro.", 404);
            }

            if(!$objUser->updateUser()){

                throw new \Exception("Ops. Algo deu errado na inserção dos dados no banco. Tente novamente mais tarde.", 404);
    
            }


            return [

                'retorno'                => 'success',
                'success'                => 'Codígo reenvido, Aguardado confirmação',
                "nomeUsuario"            => $objUser->nomeUsuario, 
                "sobreNome"              => $objUser->sobreNome, 
                "dataNascimento"         => $objUser->dataNascimento, 
                "email"                  => $objUser->email, 
                "alertaNovidade"         => (int)$objUser->alertaNovidade, 
                "dicasPontosTuristicos"  => (int)$objUser->dicasPontosTuristicos, 
                "dicasRestaurantes"      => (int)$objUser->dicasRestaurantes, 
                "dicasHospedagens"       => (int)$objUser->dicasHospedagens, 
                "alertaEventos"          => (int)$objUser->alertaEventos, 
                "ativaLocalizacao"       => (int)$objUser->ativaLocalizacao, 
                "status"                 => $objUser->status,      

            ];
    
        }elseif(isset($postVars['redefinirSenha'])){



            if(!$validate->validateEmail($postVars['redefinirSenha'])){
                throw new \Exception("O email ". $postVars['email']." é inválido.", 404);
            }
    
            $objUser = EntityUser::getUserByEmail($postVars['redefinirSenha']);
    
            if(!$objUser instanceof EntityUser){

                throw new \Exception("Usuario: ".$postVars['redefinirSenha']." não encontrado.", 404);
            }

            $token ='';
            $min = 1000;
            $max = 9999;
            $token = (string)rand($min,$max);

            $objUser->token  = password_hash($token, PASSWORD_DEFAULT);
            
            $address = $objUser->email;

            $subjet = "Redefinir senha São Roque e Você.";
    
            $body = "<h4>Redefinir senha São Roque e Você.</h4>
            <p>Olá $objUser->nomeUsuario</p>
            <p>Este é seu codígo de validação para redefir a senha.</p>
            <p>CODIGO: $token</p>
            <br><br><br>
            <img src='http://www.racsstudios.com/img/logo-srv-300.png' alt='Logotipo do aplicativo São roque e vocẽ'>";
    
            if(!$validate->validateSendEmail($address, $subjet, $body, $objUser->nomeUsuario)){
                throw new \Exception("Ocorreu um problema na confirmação do email. Tente novamente mais tarde.", 404);
            }

            if(!$objUser->updateUser()){

                throw new \Exception("Ops. Algo deu errado na atualização dos dados. Tente novamente mais tarde.", 404);
    
            }


            return [

                'retorno'                => 'success',
                'success'                => 'Codígo reenvido, Aguardado confirmação',
                "nomeUsuario"            => $objUser->nomeUsuario, 
                "sobreNome"              => $objUser->sobreNome, 
                "dataNascimento"         => $objUser->dataNascimento, 
                "email"                  => $objUser->email, 
                "alertaNovidade"         => (int)$objUser->alertaNovidade, 
                "dicasPontosTuristicos"  => (int)$objUser->dicasPontosTuristicos, 
                "dicasRestaurantes"      => (int)$objUser->dicasRestaurantes, 
                "dicasHospedagens"       => (int)$objUser->dicasHospedagens, 
                "alertaEventos"          => (int)$objUser->alertaEventos, 
                "ativaLocalizacao"       => (int)$objUser->ativaLocalizacao, 
                "status"                 => $objUser->status,      

            ];


        }

    }

    /**
     * Atualiza configurações de usuario a um app
     *
     * @param Request $request
     * @return array
     */
    public static function setEditUserApp($request){

        $postVars = $request->getPostVars();

        if(isset($postVars['novaSenha'])){
           
            if(!isset($postVars['novaSenha']) || !isset($postVars['token']) || !isset($postVars['email']) ){

                throw new \Exception("Todos os campos são obrigatorios", 400);
                
            }

            $objUser = EntityUser::getUserByEmail($postVars['email']);

            if(!$objUser instanceof EntityUser){
                throw new \Exception("Não há usuário para o email ".$postVars['email'].".", 404);
            }
        

            if(password_verify($postVars['token'], $objUser->token)){

                $objUser->status    = 'ativo';
                $objUser->senha     = password_hash($postVars['novaSenha'], PASSWORD_DEFAULT);


                if(!$objUser->updateUser()){

                    throw new \Exception("Ops. Algo deu errado na atualização da senha.  Tente novamente mais tarde", 404);
    
                }

                $msg = "Senha atualizada com sucesso.";

            }else{

                throw new \Exception("Ops. Codigo inválido.", 404);

            }

            return [

                'retorno'                => 'success',
                'success'                => $msg,
                'nomeUsuario'            => $objUser->nomeUsuario,           
                'sobreNome'              => $objUser->sobreNome,             
                'dataNascimento'         => $objUser->dataNascimento,        
                'email'                  => $objUser->email,                                
                "alertaNovidade"         => (int)$objUser->alertaNovidade, 
                "dicasPontosTuristicos"  => (int)$objUser->dicasPontosTuristicos, 
                "dicasRestaurantes"      => (int)$objUser->dicasRestaurantes, 
                "dicasHospedagens"       => (int)$objUser->dicasHospedagens, 
                "alertaEventos"          => (int)$objUser->alertaEventos, 
                "ativaLocalizacao"       => (int)$objUser->ativaLocalizacao,      
                "status"                 => $objUser->status,      
            ];

        }else{

            throw new \Exception("Ops. Algo deu errado na rota setUser POST.", 404);
        }
       
    }
   
}