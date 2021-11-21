<?php

namespace App\Controller\RACS;

use \App\Utils\View;

class App extends Page{

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