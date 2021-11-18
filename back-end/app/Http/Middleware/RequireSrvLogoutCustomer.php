<?php
namespace App\Http\Middleware;

use \App\Session\Srv\LoginCustomer as SessionCustomer;

class RequireSrvLogoutCustomer{


     /**
     * Método resposável por executar o middleware
     *
     * @param  Request $request
     * @param  Closure $next
     * @return Response
     */
    public function handle($request, $next){

        //Verifica se o cliente está logado
        if(SessionCustomer::isLogged()){     
            $request->getRouter()->redirect('/srv');
        }
        //Continua a execução
        return $next($request);
        
    }

}