<?php
namespace App\Http\Middleware;

class Api {

    /**
     * Método resposável por executar o middleware
     *
     * @param  Request $request
     * @param  Closure $next
     * @return Response
     */
    public function handle($request, $next){
        
        //Altera o content type para json
        $request->getRouter()->setContentType('application/json');
        //Executa o proximo nivel do middleware
        return  $next($request);
    }
}