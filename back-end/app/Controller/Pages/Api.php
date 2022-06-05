<?php

namespace App\Controller\Pages;

use App\Utils\View;
use App\Validate\Validate;

class Api extends Page{

    public static function getApi(){

        $content = View::render('pages/api',[]);

        return parent::getPage('API RACS',$content, null);
    
    }

  
    

}