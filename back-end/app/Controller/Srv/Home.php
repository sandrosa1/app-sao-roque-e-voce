<?php

namespace App\Controller\Srv;

use \App\Utils\View;

class Home extends Page{

    /**
     * Renderiza o conteúdo da Home Administradora do cliente
     * Metódo respónsavel por retornar a view do painel do cliente
     *
     * @param Request $request
     * @return String
     */
    public static function getHome(){

       $content = View::render('srv/modules/home/index',[]);

       return parent::getPanel('HOME - SRV', $content,'home');

    }
}