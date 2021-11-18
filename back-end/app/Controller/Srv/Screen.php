<?php

namespace App\Controller\Srv;

use \App\Utils\View;

class Screen extends Page{

    /**
    * Renderiza o conteúdo da pagina de depoimentos
    *
    * @param Request $request
    * @return String
    */
    public static function getScreen(){

       $content = View::render('srv/modules/tela/index',[]);

       return parent::getPanel('Tela - SRV', $content,'tela');

    }
}