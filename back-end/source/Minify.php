<?php

use MatthiasMullie\Minify;
//Minimisa o css e o javascript em dois arquivos 
//Quando esta local ele atualiza a cada refresh
//Quando esta on line inserir um GET (?minify=1) na URL para atualizar
$minify = filter_input(INPUT_GET, "minify", FILTER_VALIDATE_BOOLEAN);

if($_SERVER['SERVER_NAME'] == 'localhost' || $minify){

    $minCSS = new Minify\CSS();

    $cssDir = scandir(dirname(__DIR__, 1)."/app/assets/css/");

   
    foreach($cssDir as $cssItem){
        $cssFile = dirname(__DIR__, 1)."/app/assets/css/${cssItem}";
       
        if(is_file($cssFile) && pathinfo($cssFile)["extension"] == "css"){
           
            $minCSS->add($cssFile);
        }
    }

    $minCSS->minify(dirname(__DIR__, 1)."/app/assets/styles.min.css");

    $minJS = new Minify\JS();
    $jsDir = scandir(dirname(__DIR__, 1)."/app/assets/js/");
    foreach($jsDir as $jsItem){
        $jsFile = dirname(__DIR__, 1)."/app/assets/js/${jsItem}";
        if(is_file($jsFile) && pathinfo($jsFile)["extension"] == "js"){
            $minJS->add($jsFile);
        }
        
    }
    $minJS->minify(dirname(__DIR__, 1)."/app/assets/javascripts.min.js");

}
