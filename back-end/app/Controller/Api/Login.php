<?php

namespace App\Controller\Api;

use \App\Model\Entity\User\User as EntityUser;



class Login extends Api {


    /**
     * Inserí um novo comentário a um estabelecimento
     *
     * @param Request $request
     * @return array
     */
    public static function setNewPassword($request){

        //Code
       
    }

      /**
     * Atualiza um comentário a um app
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
       
        return [

            "retorne"=> true,
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


    public static function resetPassword(){

        //code
    }
   
   
   
}