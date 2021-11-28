<?php

namespace App\Controller\Srv;

use \App\Utils\View;

class TestimonySrv extends PageSrv{

    /**
    * Renderiza o conteúdo da pagina de depoimentos
    *
    * @param Request $request
    * @return String
    */
    public static function getTestimonials(){

       $content = View::render('srv/modules/depoimentos/index',[]);

       return parent::getPanel('Depoimentos - SRV', $content,'depoimentos');

    }
}