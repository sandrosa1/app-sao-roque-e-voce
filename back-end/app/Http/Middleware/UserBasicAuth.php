<?php
namespace App\Http\Middleware;

use \App\Model\Entity\User\User;

class UserBasicAuth {



    /**
     * Retorna uma instacia de usuário autenticado
     *
     * @return User
     */
    private function getBAsicAuthUser(){
        
        if (!isset($_SERVER['PHP_AUTH_USER']) or !isset($_SERVER['PHP_AUTH_PW'])) {
            return false;
        }

        //Busca uma usuario pelo email
        $objUser = User::getUserByEmail($_SERVER['PHP_AUTH_USER']);

        //Verifica se o usuário existe
       if(!$objUser instanceof User){

            return false;
       }


       //Valida a senha we retorna o usuário
        return password_verify($_SERVER['PHP_AUTH_PW'],$objUser->token) ? $objUser : false;
    }

    /**
     * Valida ao acesso via basic Auth
     *
     * @param Request $request
     * @return void
     */
    private function basicAuth($request){
        
        //Verifica o usuário recebido
        if($objUser = $this->getBasicAuthUser()){
            $request->user = $objUser;
            return true;
        }

        //Emite o erro de senha inválida
        throw new \Exception("Usuario inválido", 403);
        
    }
    /**
     * Método resposável por executar o middleware
     *
     * @param  Request $request
     * @param  Closure $next
     * @return Response
     */
    public function handle($request, $next){
        
        //Altera o content type para json
        $this->basicAuth($request);
        //Executa o proximo nivel do middleware
        return  $next($request);
    }


}