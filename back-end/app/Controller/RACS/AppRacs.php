<?php

namespace App\Controller\RACS;

use \App\Utils\View;

class AppRacs extends PageRacs{

    /**
     * Renderiza o conteúdo da view de apps
     * 
     *
     * @param Request $request
     * @return String
     */
    public static function getApps(){

       $content = View::render('racs/modules/app/index',[]);

       return parent::getPanel('Apps - RACS', $content,'apps');

    }

}