<?php
namespace App\Http\Middleware;

use \App\Session\RACS\LoginRACS as SessionRACS;

class RequireLogoutRACS{


     /**
     * Método resposável por executar o middleware
     *
     * @param  Request $request
     * @param  Closure $next
     * @return Response
     */
    public function handle($request, $next){

        //Verifica se o cliente está logado
        if(SessionRACS::isLogged()){     
            $request->getRouter()->redirect('/racs');
        }
        //Continua a execução
        return $next($request);
        
    }

}