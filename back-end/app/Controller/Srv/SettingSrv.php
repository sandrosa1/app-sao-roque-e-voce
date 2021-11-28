<?php

namespace App\Controller\Srv;

use \App\Utils\View;

class Setting extends PageSrv{

    /**
    * Renderiza o conteúdo de configurações
    * @param Request $request
    * @return String
    */
    public static function getSetting(){

       $content = View::render('srv/modules/detalhes/index',[]);

       return parent::getPanel('Detalhes - SRV', $content,'detalhes');

    }
}