<?php

namespace App\Controller\Srv;

use \App\Utils\View;
use \App\Model\Entity\Customer\Customer as EntityCustomer;

class Confirmation extends Page {

    /**
    * Metodo que verifica a validação do cadastro e retorna para pagina view de login
    *
    * @param Request $request
    * @return String
    */
    public static function getConfirmation($request){

    //Recebe os parametros do GET
    $getVars = $request->getQueryParams();
    $email = $getVars['email'];
    $validateToken = $getVars['token'];
    $status ="active";

    $confirmation = new EntityCustomer;

    //Verifica se existe o cadastro
    $objCustomer = $confirmation->getCustomerByEmail($email);
    $objCustomerToken = $confirmation->getCustomerToken($email);
        
    if(!$objCustomer instanceof EntityCustomer){
        $content = View::render('srv/login',[

            'status' => '<span class="srv-c-4 m-3">Email não encontrado</span>'

        ]);

        return parent::getPage('SRV - Login',$content);
    }

    if($objCustomerToken->token !=  $validateToken ||  $validateToken == ''){

        $content = View::render('srv/login',[

            'status' => '<span class="srv-c-4 m-3">Token invalido</span>'

        ]);

        return parent::getPage('SRV - Login',$content);
    }

    //Confima o cadastro
    $confirmation->confirmationCad($objCustomer->idUser, $status );

    //Conteúde da pagina de login
    $content = View::render('srv/login',[

        'status' => '<span class="srv-c-4 m-3">Validado com sucesso</span>'

    ]);
        return parent::getPage('SRV - Login',$content);

    }

}