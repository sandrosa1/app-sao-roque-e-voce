<?php

namespace App\Help;

use \App\Controller\Srv\PageSrv;
use \App\Model\Entity\Customer\Customer as EntityCustomer;
use \App\Model\Entity\Aplication\App as EntityApp;
use \App\Model\Entity\Aplication\Hospedagem\Hospedagem as EntityHospedagem;
use \App\Model\Entity\Aplication\Comercio\Comercio as EntityComercio;
use \App\Model\Entity\Aplication\Evento\Evento as EntityEvento;
use \App\Model\Entity\Aplication\Turismo\Turismo as EntityTurismo;
use \App\Model\Entity\Aplication\Servico\Servico as EntityServico;
use \App\Model\Entity\Aplication\Gastronomia\Gastronomia as EntityGastronomia;


class HelpEntity{


    public static function helpApp(){

        $session = new PageSrv();
        $idApp =  $session->idSession;
        return EntityApp::getAppById($idApp);

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
                return EntityTurismo::getTurismoById($app->idApp);
           
        }
    }
    /**
     * Metódo responsável por criar uma nova hospedagem
     *
     * @param [type] $idCustomer
     * @return void
     */
    public static function helpHospedagem($idApp, $postVars){

      
        $objHospedagem = EntityHospedagem::getHospedagemById($idApp);

        if (!$objHospedagem instanceof EntityHospedagem){
       
            $objHospedagem = new EntityHospedagem();

        }
        

        $objHospedagem->idApp            = $idApp;
        $objHospedagem->idAppHospedagem  = $objHospedagem->idAppHospedagem;
        $objHospedagem->semana           = !$postVars["semana"]  || $postVars["semana"]   == "00:00 - 00:00"  ? "Fechado" : $postVars["semana"];
        $objHospedagem->sabado           = !$postVars["sabado"]  || $postVars["sabado"]   == "00:00 - 00:00"  ? "Fechado" : $postVars["sabado"];
        $objHospedagem->domingo          = !$postVars["domingo"] || $postVars["domingo"]  == "00:00 - 00:00"  ? "Fechado" : $postVars["domingo"];
        $objHospedagem->feriado          = !$postVars["feriado"] || $postVars["feriado"]  == "00:00 - 00:00"  ? "Fechado" : $postVars["feriado"];
        $objHospedagem->estacionamento   = $postVars["estacionamento"] ? -2 : -1;
        $objHospedagem->brinquedos       = $postVars["brinquedos"]     ? -2 : -1;
        $objHospedagem->restaurante      = $postVars["restaurante"]    ? -2 : -1;
        $objHospedagem->arCondicionado   = $postVars["arCondicionado"] ? -2 : -1;
        $objHospedagem->wiFi             = $postVars["wiFi"]           ? -2 : -1;
        $objHospedagem->academia         = $postVars["academia"]       ? -2 : -1;
        $objHospedagem->piscina          = $postVars["piscina"]        ? -2 : -1;
        $objHospedagem->refeicao         = $postVars["refeicao"]       ? -2 : -1;
        $objHospedagem->emporio          = $postVars["emporio"]        ? -2 : -1;
        $objHospedagem->adega            = $postVars["adega"]          ? -2 : -1;
        $objHospedagem->bebidas          = $postVars["bebidas"]        ? -2 : -1;
        $objHospedagem->sorveteria       = $postVars["sorveteria"]     ? -2 : -1;
        $objHospedagem->whatsapp         = $postVars["whatsapp"]       ? -2 : -1;
        $objHospedagem->descricao        = $postVars["descricao"]      ? $postVars["descricao"]      : ""; 

        if($postVars["action"] == "atualizar" ){

            $objHospedagem->updateHospedagem();
            
        }else{
            $objHospedagem->img2             = "dois.jpg";
            $objHospedagem->img3             = "tres.jpg";
            $objHospedagem->insertNewHospedagem();
        
        }

        return true;
        
    }
      /**
     * Metódo responsável por criar uma nova opção gastronomica
     *
     * @param [type] $idApp
     * @return void
     */
    public static function helpGastronomia($idApp,  $postVars){

        $objGastronomia = EntityGastronomia::getGastronomiaById($idApp);

        if (!$objGastronomia instanceof EntityGastronomia){
       
            $objGastronomia = new EntityGastronomia();

        }


        $objGastronomia->idApp             = $idApp;
        $objGastronomia->idAppGastronomia  = $objGastronomia->idAppGastronomia;
        $objGastronomia->semana            = !$postVars["semana"]  || $postVars["semana"]   == "00:00 - 00:00"  ? "Fechado" : $postVars["semana"];
        $objGastronomia->sabado            = !$postVars["sabado"]  || $postVars["sabado"]   == "00:00 - 00:00"  ? "Fechado" : $postVars["sabado"];
        $objGastronomia->domingo           = !$postVars["domingo"] || $postVars["domingo"]  == "00:00 - 00:00"  ? "Fechado" : $postVars["domingo"];
        $objGastronomia->feriado           = !$postVars["feriado"] || $postVars["feriado"]  == "00:00 - 00:00"  ? "Fechado" : $postVars["feriado"];
        $objGastronomia->estacionamento    = $postVars["estacionamento"]   ? -2 : -1;
        $objGastronomia->acessibilidade    = $postVars["acessibilidade"]   ? -2 : -1;
        $objGastronomia->wiFi              = $postVars["wiFi"]             ? -2 : -1;
        $objGastronomia->brinquedos        = $postVars["brinquedos"]       ? -2 : -1;
        $objGastronomia->restaurante       = $postVars["restaurante"]      ? -2 : -1;
        $objGastronomia->emporio           = $postVars["emporio"]          ? -2 : -1;
        $objGastronomia->adega             = $postVars["adega"]            ? -2 : -1;
        $objGastronomia->bebidas           = $postVars["bebidas"]          ? -2 : -1;
        $objGastronomia->sorveteria        = $postVars["sorveteria"]       ? -2 : -1;
        $objGastronomia->entregaDomicilio  = $postVars["entregaDomicilio"] ? -2 : -1;
        $objGastronomia->whatsapp          = $postVars["whatsapp"]         ? -2 : -1;
        $objGastronomia->descricao         = $postVars["descricao"]        ? $postVars["descricao"]        : ""; 

        if($postVars["action"] == "atualizar" ){
          $objGastronomia->updateGastronomia();
            
        }else{
            $objGastronomia->img2              = "dois.jpg";
            $objGastronomia->img3              = "tres.jpg";
            $objGastronomia->insertNewGastronomia();

        }
        
        
    }
    /**
     * Metódo responsável por criar um novo Evento
     *
     * @param [type] $idApp
     * @return void
     */
    public static function helpEvento($idApp,  $postVars){

        $objEvento = EntityEvento::getEventoById($idApp);

        if (!$objEvento instanceof EntityEvento){
            $objEvento = new EntityEvento();

        }

        $objEvento->idApp          = $idApp;
        $objEvento->idEvento       = $objEvento->idEvento;
        $objEvento->semana         = !$postVars["semana"]  || $postVars["semana"]   == "00:00 - 00:00"  ? "Fechado" : $postVars["semana"];
        $objEvento->sabado         = !$postVars["sabado"]  || $postVars["sabado"]   == "00:00 - 00:00"  ? "Fechado" : $postVars["sabado"];
        $objEvento->domingo        = !$postVars["domingo"] || $postVars["domingo"]  == "00:00 - 00:00"  ? "Fechado" : $postVars["domingo"];
        $objEvento->feriado        = !$postVars["feriado"] || $postVars["feriado"]  == "00:00 - 00:00"  ? "Fechado" : $postVars["feriado"];
        $objEvento->estacionamento = $postVars["estacionamento"] ? -2 : -1;
        $objEvento->acessibilidade = $postVars["acessibilidade"] ? -2 : -1;
        $objEvento->wiFi           = $postVars["wiFi"]           ? -2 : -1;
        $objEvento->trilhas        = $postVars["trilhas"]        ? -2 : -1;
        $objEvento->refeicao       = $postVars["refeicao"]       ? -2 : -1;
        $objEvento->emporio        = $postVars["emporio"]        ? -2 : -1;
        $objEvento->adega          = $postVars["adega"]          ? -2 : -1;
        $objEvento->bebidas        = $postVars["bebidas"]        ? -2 : -1;
        $objEvento->sorveteria     = $postVars["sorveteria"]     ? -2 : -1;
        $objEvento->musica         = $postVars["musica"]         ? -2 : -1;
        $objEvento->whatsapp       = $postVars["whatsapp"]       ? -2 : -1;
        $objEvento->descricao      = $postVars["descricao"]      ? $postVars["descricao"]      : ""; 

        if($postVars["action"] == "atualizar" ){
            $objEvento->updateEvento();

        }else{
            $objEvento->img2           = 'dois.jpg';
            $objEvento->img3           = 'tres.jpg';
            $objEvento->insertNewEvento();
        }
    }
    /**
     * Metódo responsável por criar um novo Serviço
     *
     * @param [type] $idApp
     * @return void
     */
    public static function helpServico($idApp,  $postVars){

        $objServico = EntityServico::getServicoById($idApp);
        
         if (!$objServico instanceof EntityServico){
            $objServico = new EntityServico();

        }
        
        $objServico->idApp                = $idApp;
        $objServico->idAppServico         = $objServico->idAppServico;
        $objServico->semana               = !$postVars["semana"]  || $postVars["semana"]   == "00:00 - 00:00"  ? "Fechado" : $postVars["semana"];
        $objServico->sabado               = !$postVars["sabado"]  || $postVars["sabado"]   == "00:00 - 00:00"  ? "Fechado" : $postVars["sabado"];
        $objServico->domingo              = !$postVars["domingo"] || $postVars["domingo"]  == "00:00 - 00:00"  ? "Fechado" : $postVars["domingo"];
        $objServico->feriado              = !$postVars["feriado"] || $postVars["feriado"]  == "00:00 - 00:00"  ? "Fechado" : $postVars["feriado"];
        $objServico->estacionamento       = $postVars["estacionamento"]   ? -2 : -1;
        $objServico->acessibilidade       = $postVars["acessibilidade"]   ? -2 : -1;
        $objServico->entregaDomicilio     = $postVars["entregaDomicilio"] ? -2 : -1;
        $objServico->whatsapp             = $postVars["whatsapp"]         ? -2 : -1;
        $objServico->descricao            = $postVars["descricao"]        ? $postVars["descricao"]        : ""; 

        
        if($postVars["action"] == "atualizar" ){
          $objServico->updateServico();
            
        }else{

            $objServico->logo                 = "um.jpg";
            $objServico->img2                 = "dois.jpg";
            $objServico->img3                 = "tres.jpg";
            $objServico->insertNewServico();
        }
    }
    /**
     * Metódo responsável por criar um novo Comércio
     *
     * @param [type] $idCustomer
     * @return void
     */
    public static function helpComercio($idApp,  $postVars){

        $objComercio = EntityComercio::getComercioById($idApp);

    
        if (!$objComercio instanceof EntityComercio){
            $objComercio = new EntityComercio();

        }

        $objComercio->idApp            = $idApp;
        $objComercio->idAppComercio    = $objComercio->idAppComercio;
        $objComercio->semana           = !$postVars["semana"]  || $postVars["semana"]   == "00:00 - 00:00"  ? "Fechado" : $postVars["semana"];
        $objComercio->sabado           = !$postVars["sabado"]  || $postVars["sabado"]   == "00:00 - 00:00"  ? "Fechado" : $postVars["sabado"];
        $objComercio->domingo          = !$postVars["domingo"] || $postVars["domingo"]  == "00:00 - 00:00"  ? "Fechado" : $postVars["domingo"];
        $objComercio->feriado          = !$postVars["feriado"] || $postVars["feriado"]  == "00:00 - 00:00"  ? "Fechado" : $postVars["feriado"];
        $objComercio->estacionamento   = $postVars["estacionamento"]   ? -2 : -1;
        $objComercio->acessibilidade   = $postVars["acessibilidade"]   ? -2 : -1;
        $objComercio->entregaDomicilio = $postVars["entregaDomicilio"] ? -2 : -1;
        $objComercio->whatsapp         = $postVars["whatsapp"]         ? -2 : -1;
        $objComercio->descricao        = $postVars["descricao"]        ? $postVars["descricao"]        : "";

        if($postVars["action"] == "atualizar" ){
          $objComercio->updateComercio();
            
        }else{ 
            $objComercio->img2             = "dois.jpg";
            $objComercio->img3             = "tres.jpg";
            $objComercio->insertNewComercio();
    
        }
    }

     /**
     * Metódo responsável por criar um novo Evento
     *
     * @param [type] $idApp
     * @return void
     */
    public static function helpTurismo($idApp,  $postVars){


        $objTurismo = EntityTurismo::getTurismoById($idApp);

        if (!$objTurismo instanceof EntityTurismo){
            $objTurismo = new EntityTurismo();

        }

        $objTurismo->idApp          = $idApp;
        $objTurismo->idTurismo       = $objTurismo->idTurismo;
        $objTurismo->semana         = !$postVars["semana"]  || $postVars["semana"]   == "00:00 - 00:00"  ? "Fechado" : $postVars["semana"];
        $objTurismo->sabado         = !$postVars["sabado"]  || $postVars["sabado"]   == "00:00 - 00:00"  ? "Fechado" : $postVars["sabado"];
        $objTurismo->domingo        = !$postVars["domingo"] || $postVars["domingo"]  == "00:00 - 00:00"  ? "Fechado" : $postVars["domingo"];
        $objTurismo->feriado        = !$postVars["feriado"] || $postVars["feriado"]  == "00:00 - 00:00"  ? "Fechado" : $postVars["feriado"];
        $objTurismo->estacionamento = $postVars["estacionamento"] ? -2 : -1;
        $objTurismo->acessibilidade = $postVars["acessibilidade"] ? -2 : -1;
        $objTurismo->fe             = $postVars["fe"]             ? -2 : -1;
        $objTurismo->trilhas        = $postVars["trilhas"]        ? -2 : -1;
        $objTurismo->refeicao       = $postVars["refeicao"]       ? -2 : -1;
        $objTurismo->natureza       = $postVars["natureza"]       ? -2 : -1;
        $objTurismo->cachoeira      = $postVars["cachoeira"]      ? -2 : -1;
        $objTurismo->parque         = $postVars["parque"]         ? -2 : -1;
        $objTurismo->descricao      = $postVars["descricao"]      ? $postVars["descricao"]      : ""; 


        if($postVars["action"] == "atualizar" ){
            $objTurismo->updateTurismo();
            

        }else{

            $objTurismo->img2           = 'dois.jpg';
            $objTurismo->img3           = 'tres.jpg';
            $objTurismo->insertNewTurismo();

        }


        return true;
    }


    /**
     * Metódo responsável por criar uma nova hospedagem
     *
     * @param [type] $idCustomer
     * @return void
     */
    public static function helpImgHospedagem($app, $appSegmento, $pathImages){

      
        
        $app->img1          = $pathImages[0];
        $appSegmento->img2  = $pathImages[1];
        $appSegmento->img3  = $pathImages[2];

        
        $app->updateApp();
        $appSegmento->updateHospedagem();
            
        return true;
    }
      /**
     * Metódo responsável por criar uma nova opção gastronomica
     *
     * @param [type] $idApp
     * @return void
     */
    public static function helpImgGastronomia($app, $appSegmento, $pathImages){

      
        $app->img1          = $pathImages[0];
        $appSegmento->img2  = $pathImages[1];
        $appSegmento->img3  = $pathImages[2];

        
        $app->updateApp();
        $appSegmento->updateGastronomia();
            
        return true;
        
        
    }
    /**
     * Metódo responsável por criar um novo Evento
     *
     * @param [type] $idApp
     * @return void
     */
    public static function helpImgEvento($app, $appSegmento, $pathImages){

        $app->img1          = $pathImages[0];
        $appSegmento->img2  = $pathImages[1];
        $appSegmento->img3  = $pathImages[2];
        
        $app->updateApp();
        $appSegmento->updateEvento();
            
        return true;
    }
    /**
     * Metódo responsável por criar um novo Serviço
     *
     * @param [type] $idApp
     * @return void
     */
    public static function helpImgServico($app, $appSegmento, $pathImages){

        $app->img1          = $pathImages[0];
        $appSegmento->img2  = $pathImages[0];
        $appSegmento->img3  = $pathImages[0];
        
        $app->updateApp();
        $appSegmento->updateServico();
            
        return true;
            
        
    }
   
    public static function helpImgComercio($app, $appSegmento, $pathImages){

     
        $app->img1          = $pathImages[0];
        $appSegmento->img2  = $pathImages[1];
        $appSegmento->img3  = $pathImages[2];

        $app->updateApp();
        $appSegmento->updateComercio();
            
        return true;
    }

    public static function helpImgTurismo($app, $appSegmento, $pathImages){

     
        $app->img1          = $pathImages[0];
        $appSegmento->img2  = $pathImages[1];
        $appSegmento->img3  = $pathImages[2];

        $app->updateApp();
        $appSegmento->updateTurismo();
            
        return true;
    }

    public static function hellGetAllsApps(){

      
       return EntityApp::getAppAll();

    }
    public static function hellGetAllsCustomers(){

      
        return EntityCustomer::getCustomerAll();
 
     }

     public static function hellGetAllsTourism(){

      
        return EntityTurismo::getTurismoAll();
 
     }



}