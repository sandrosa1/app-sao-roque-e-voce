<?php

namespace App\Controller\RACS;

use \App\Utils\View;

class Admin extends Page{

    /**
     * Renderiza o conteúdo da view de apps
     * 
     *
     * @param Request $request
     * @return String
     */
    public static function getAdmins(){

       $content = View::render('racs/modules/admin/index',[]);

       return parent::getPanel('Admin - RACS', $content,'admin');

    }

}