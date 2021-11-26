<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class Product extends Page{
    /**
     * Metódo respónsavel por retornar a view de produtos
     *
     * @return string
     */
    public static function getProducts(){

        $objOrganization = new Organization;

        $content = View::render('pages/products',[

        ]);
        return parent::getPage('Produtos - RACS',$content);
    }
}