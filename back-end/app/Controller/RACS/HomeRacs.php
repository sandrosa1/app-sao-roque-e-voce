<?php

namespace App\Controller\RACS;

use \App\Utils\View;

class HomeRacs extends PageRacs{

    /**
     * Renderiza o conteúdo da Home Administradora 
     * Metódo respónsavel por retornar a view do painel 
     *
     * @param Request $request
     * @return String
     */
    public static function getHome(){

       $content = View::render('racs/modules/home/index',[]);

       return parent::getPanel('HOME - RACS', $content,'home');

    }
}