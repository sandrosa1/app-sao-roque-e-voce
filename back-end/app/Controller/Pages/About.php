<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class About extends Page{

    /**
     * Metódo respónsavel por retornar view da pagina sobre
     *
     * @return string
     */
    public static function getAbout(){

        $objOrganization = new Organization;

        $content = View::render('pages/about',[
            'name' =>   $objOrganization->name,
            'description' =>  $objOrganization->description,
            'endereco' => $objOrganization->address,
            'mission' => $objOrganization->mission,
            'vision' => $objOrganization->vision,
            'values' => $objOrganization->values,
            'site' => $objOrganization->site,
        ]);
        return parent::getPage('SOBRE - RACS',$content);
    }
}