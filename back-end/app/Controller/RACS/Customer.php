<?php

namespace App\Controller\RACS;

use \App\Utils\View;

class Customer extends Page{

    /**
     * Renderiza o conteúdo da view de clientes 
     * 
     *
     * @param Request $request
     * @return String
     */
    public static function getCustomers(){

       $content = View::render('racs/modules/customer/index',[]);

       return parent::getPanel('Customer - RACS', $content,'customer');

    }

}