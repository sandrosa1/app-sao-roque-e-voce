<?php

namespace App\Session\RACS;

class LoginRACS{

    /**
     * Método responsável por iniciar a sessão RACS
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
     * Método responsável por criar a sessão de login RACS
     *
     * @param racs $objRACS
     * @return Boolean
     */
    public static function login($objRACS){


        //Inicia a sessão
        self::init();
        
        //Define a sessão do usuário
        $_SESSION['root']['racs'] = [
          'idRoot'     => $objRACS->idRoot,
          'name'       => $objRACS->name,
          'email'      => $objRACS->email,  
          'permission' => $objRACS->permission  
        ];

        //Sucesso
        return true;

    }

    /**
     * Verifica se esta logado
     *
     * @return boolean
     */
    public static function isLogged(){

        //Inicia a sessão
        self::init();

        return isset($_SESSION['root']['racs']['idRoot']);
    } 


    /**
     * Método responsável por executar o logout 
     *
     * @return boolean
     */
    public static function logout(){

        //Inicia a sessão
        self::init();

        //Destroi a sessão
       unset( $_SESSION['root']['racs']);

       return true;

    }

}