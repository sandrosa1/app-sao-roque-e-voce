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

    /**
     * Undocumented function
     *
     * @param string $opcao
     * @return void
     */
    public static function helpOptions($opcao){

        switch ($opcao) {
            case 'entregaDomicilio';
                return ["Dellivery","class='c-pri ml-4 fas fa-truck'"];
            case 'estacionamento':
                return ["Vaga","class='c-pri ml-4 fas fa-car'"];
            case 'acessibilidade':
                return ["Acessibilidade","class='c-pri ml-4 fab fa-accessible-icon'"];
            case "whatsapp":
                return ["whatsapp","class='c-pri ml-4 fab fa-whatsapp'"];
            case "wiFi":
                return ["WiFi","class='c-pri ml-4 fas fa-wifi'"];
            case "trilhas":
                return ["Trilha","class='c-pri ml-4 fas fa-hiking'"];
            case "refeicao":
                return ["Refeição","class='c-pri ml-4 fas fa-utensils'"];
            case "emporio":
                return ["Empório","class='c-pri ml-4 fas fa-store'"];
            case "adega":
                return ["Adega","class='c-pri ml-4 fas fa-wine-bottle'"];
            case "bebidas":
                return ["Bebidas","class='c-pri ml-4 fas fa-glass-cheers'"];
            case "sorveteria":
                return ["Sorveteria","class='c-pri ml-4 fas fa-ice-cream'"];
            case "show":
                return ["Shows","class='c-pri ml-4 far fa-stars'"];
            case "brinquedos":
                return ["Brinquedos","class='c-pri ml-4 fas fa-gamepad'"];
            case "restaurante":
                return ["Restaurante","class='c-pri ml-4 fas fa-utensils'"];
            case "arCondicionado":
                return ["ArCondi","class='c-pri ml-4 fal fa-air-conditioner'"];
            case "academia":
                return ["Academia","class='c-pri ml-4 fas fa-running'"];
            case "piscina":
                return ["Piscina","class='c-pri ml-4 fas fa-swimmer'"];
            case "refeicao":
                return ["Refeição","class='c-pri ml-4 fas fa-cookie-bite'"];
            case "musica":
                return ["Música","class='c-pri ml-4 fas fa-music'"];
            
            default:
                # code...
                break;
        }
    }


    /**
     * Undocumented function
     *
     * @param [type] $app
     * @return void
     */
    public static function helpGetTypeHeader($app){

        switch ($app->segmento) {
            case 'evento':
                return ["Eventos","fas fa-calendar-alt"];

            case 'servicos':
                return ["Serviços","fas fa-tools"];

            case 'comercio':
                return ["Comércios","fas fa-store"];

            case 'hospedagem':
                return ["Hospedagens","fas fa-hotel"];

            case 'turismo':
                return ["Turísmo","fas fa-camera-retro"];

            case 'gastronomia':
            return ["Gastronomia","fas fa-wine-glass-alt"];
            
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
                return EntityGastronomia::getGastronomiaById($app->idApp);
            case 'evento':
                return EntityEvento::getEventoById($app->idApp);
            case 'servicos':
                return EntityServico::getServicoById($app->idApp);
            case 'comercio':
                return EntityComercio::getComercioById($app->idApp);
            case 'hospedagem':
                return EntityHospedagem::getHospedagemById($app->idApp);
            case 'turismo':
                return EntityGastronomia::getGastronomiaById($app->idApp);
           
        }
    }


}