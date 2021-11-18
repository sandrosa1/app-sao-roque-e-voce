<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class Page{

    /**
     * Metódo respónsavel por retornar a view do header
     *
     * @return string
     */
    private static function getHeader(){
        return View::render('pages/header');
    }
    /**
     * Metódo respónsavel por retornar a view do footer
     *
     * @return string
     */
    private static function getFooter(){

        $objOrganization = new Organization();
        $footer = View::render('pages/footer',[
            'endereco' => $objOrganization->address,
            'site' => $objOrganization->site,
        ]);
        return View::render('pages/footer',$footer);

    }
    /**
     * Metódo respónsavel por retornar a view da pagina completa
     *
     * @param string $title
     * @param string $content
     * @return string
     */
    public static function getPage($title,$content){

        return View::render('pages/page',[
            'title' => $title,
            'header' => self::getHeader(),
            'content' => $content,
            'footer' => self::getFooter(),

        ]);
    }
}