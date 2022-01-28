<?php

namespace App\Help;

use \App\Controller\Srv\PageSrv;
use \App\Model\Entity\Aplication\App as EntityApp;
use \App\Model\Entity\Aplication\Hospedagem\Hospedagem as EntityHospedagem;
use \App\Model\Entity\Aplication\Comercio\Comercio as EntityComercio;
use \App\Model\Entity\Aplication\Evento\Evento as EntityEvento;
use \App\Model\Entity\Aplication\Servico\Servico as EntityServico;
use \App\Model\Entity\Aplication\Gastronomia\Gastronomia as EntityGastronomia;


class Help{


    /**
     * Método responsável em converter um texto em um array de palavras
     *
     * @param string $text
     * @return array
     */
    public static function helpTextForArray($text){

    
        $chars = [];
        $chars = ['"','!','@','#','$','%','¨','&','*','(',')','-','_','+','-','§','`','[',']','{','}','~','^',':',';','.',',','<','>','|','/','?',"'","\\"];
  
        return array_filter(explode(" ",str_replace($chars,"",mb_strtoupper($text))));
    
    }

    /**
     * Metódo responsável por retornar uma string separada por virgúlo
     *
     * @param array $array
     * @return string
     */
    public static function helpArrayForString($array){

        return mb_strtoupper(implode(", ", $array));

    }

    public static function helpApp(){

        $session = new PageSrv();
        $idApp =  $session->idSession;
        return EntityApp::getAppById($idApp);

    }

    public static function helpGetTypeHeader($app){

        switch ($app->segmento) {
            case 'gastronomia':
                return ['Gastronomia','restaurant_menu'];
            case 'evento':
                return ['Eventos','event'];
            case 'servicos':
                return ['Utilitarios','room_service'];
            case 'comercio':
                return ['Comércios','shopping_basket'];
            case 'hospedagem':
                return ['Hospedagens','hotel'];
            case 'turismo':
                return ['Turísmo','camera_alt'];
            default:
                echo '<pre>';
                print_r('ScreenSrv/getTypeHeader');
                echo '</pre>';
                exit;
                break;
        }
    }

     /**
     * Retorna a entidade
     *
     * @param string $segmento
     * @return Entity
     */
    public static function helpGetEntity($app){

        switch ($app->segmento) {
            case 'gastronomia':
                return EntityGastronomia::getAppById($app->idApp);
            case 'evento':
                return EntityEvento::getAppById($app->idApp);
            case 'servicos':
                return EntityServico::getAppById($app->idApp);
            case 'comercio':
                return EntityComercio::getAppById($app->idApp);
            case 'hospedagem':
                return EntityHospedagem::getAppById($app->idApp);
            case 'turismo':
                return EntityGastronomia::getAppById($app->idApp);
            default:
                echo '<pre>';
                print_r('ScreenSrv/getTypeHeader');
                echo '</pre>';
                exit;
                break;
        }
    }
            
    

}