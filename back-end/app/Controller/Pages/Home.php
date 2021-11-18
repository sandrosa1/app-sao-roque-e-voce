<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class Home extends Page{

    /**
     * Metodo respónsavel por retornar a view home
     *
     * @return void
     */
    public static function getHome(){

        $obOrganization = new Organization;

        $content = View::render('pages/home',[
            'name' =>   $obOrganization->name
           
        ]);

        return parent::getPage('HOME - RACS',$content, null);
    }
}