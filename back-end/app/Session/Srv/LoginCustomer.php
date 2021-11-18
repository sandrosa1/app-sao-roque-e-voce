<?php

namespace App\Session\Srv;

class LoginCustomer{

    /**
     * Método responsável por iniciar a sessão
     *
     * @return void
     */
    private static function init(){

        //Verifica se a sessão não está ativa
        if(session_status() != PHP_SESSION_ACTIVE){
            session_start();
        }
    }

    /**
     * Método responsável por criar o login 
     *
     * @param customer $objCustomer
     * @return Boolean
     */
    public static function login($objCustomer){


        //Inicia a sessão
        self::init();
        
        //Define a sessão do usuário
        $_SESSION['admin']['customer'] = [
          'idUser' =>$objCustomer->idUser,
          'name' => $objCustomer->name,
          'email' => $objCustomer->email,  
          'permission' => $objCustomer->permission  
        ];

        //Sucesso
        return true;

    }

    public static function isLogged(){

        //Inicia a sessão
        self::init();

        return isset($_SESSION['admin']['customer']['idUser']);
    } 


    /**
     * Método responsável por executar o logout do adminitrador
     *
     * @return boolean
     */
    public static function logout(){

        //Inicia a sessão
        self::init();

        //Destroi a sessão
       unset( $_SESSION['admin']['customer']);

       return true;

    }

}