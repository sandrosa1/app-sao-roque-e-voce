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

        $user = EntityUser::getUserByEmail($email);

        if(!$user instanceof EntityUser){
            return  [
                "retorno" => 'error',
                "error"  => "Email ou senha inválido!"
            ];

        }

        if(!password_verify($senha,$user->senha)){
            return  [

                "retorno" => 'error',
                "error"   => "Senha ou Email inválido!"
            ];
        }
       
        return [

            "retorne"=> true,
            
        ];

       
    }


    public static function resetPassword(){

        //code
    }
   
   
   
}