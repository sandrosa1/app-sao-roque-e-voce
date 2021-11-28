<?php

namespace App\Controller\RACS;

use \App\Utils\View;

class CustomerRacs extends PageRacs{

    /**
     * Renderiza o conteúdo da view de clientes 
     * 
     *
     * @param Request $request
     * @return string
     */
    public static function getCustomers(){

       $content = View::render('racs/modules/customer/index',[]);

       return parent::getPanel('Customer - RACS', $content,'customer');

    }

}