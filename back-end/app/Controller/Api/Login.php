<?php

namespace App\Controller\Api;

use \App\Model\Entity\User\User as EntityUser;


class Login extends Api {

  
    /**
     *Login de usuario do App
     *
     * @param Request $request
     * @return array
     */
    public static function existUser($request){

      
        $postVars =  $request->getPostVars();

        $email = $postVars['email'];
        $senha = $postVars['senha']; 

        $objUser = EntityUser::getUserByEmail($email);

        if(!$objUser instanceof EntityUser){
            
            return  [
                "retorno" => 'error',
                "error"  => "Email ou senha inválido!"
            ];

        }

        if(!password_verify($senha,$objUser->senha)){
            return  [

                "retorno" => 'error',
                "error"   => "Senha ou Email inválido!"
            ];
        }

        if($objUser->status == "confirmacao"){

           
            return  [

                "retorno" => 'error',
                "error"   => "Precizar confirmar token"
            ];
        }
        
        
        $token = "";
        $min = 1000;
        $max = 9999;
        $token = (string)rand($min,$max);

        $objUser->token  = password_hash($token, PASSWORD_DEFAULT);

        if(!$objUser->updateUser()){

            throw new \Exception("Ops. Algo deu errado na atualização dos dados. Tente novamente mais tarde.", 404);

        }
       
        return [

            "retorne"=> true,
            'token'                  => $token,
            'idUsuario'              => $objUser->idUsuario,
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
            
        ];

       
    }

}