<?php

namespace App\Controller\Srv;

use \App\Utils\View;
use \App\Help\Help;
use \App\Model\Entity\Aplication\App as EntityApp;


class ScreenSrv extends PageSrv{


    public static function apptype(){


    }
    /**
    * Renderiza o conteúdo da pagina de depoimentos
    *
    * @param Request $request
    * @return string
    */
    public static function getScreen(){

        // $session = new PageSrv();
        // $idApp =  $session->idSession;


        // $app = EntityApp::getAppById($idApp);

        if(Help::helpApp() instanceof EntityApp){
            $content = View::render('srv/modules/tela/index',[
                'preview'=> self::getView(),
                'form'   => self::getForm()
            ]);   
        }else{
            $content = View::render('srv/modules/tela/index',[
                'preview'=> self::getBlockView(),
            ]);
        }
       return parent::getPanel('Tela - SRV', $content,'tela');

    }
      /**
     * Metódo respónsavel por retornar a view do botão de cadastrar
     *
     * @return string
     */
    private static function getView(){

        return View::render('srv/modules/tela/preview/index',[
            'display'=> self::getDisplay(),
            'header'=> self::getHeader(),
            'nome'=> self::getNome(),
        ]);
       
    }
      /**
     * Metódo respónsavel por retornar a view do botão de atualizar e deletar
     *
     * @return string
     */
    private static function getBlockView(){
        return View::render('srv/modules/tela/block/index',[]);
    }

    /**
    * Metódo respónsavel por retornar a view do botão de atualizar e deletar
    *
    * @return string
    */
   private static function getForm(){
       return View::render('srv/modules/tela/form/form',[]);
   }

   /**
    * Metódo que retorna o display 
    *
    * @return string
    */
    private static function getDisplay(){
        return View::render('srv/modules/tela/preview/components/display',[
            'hora' => date('h:i'),
        ]);
    }
       /**
    * Metódo que retorna o display 
    *
    * @return string
    */
    private static function getHeader(){

       
       
        $header = Help::helpGetTypeHeader(Help::helpApp());
      
        return View::render('srv/modules/tela/preview/components/header',[
            'icon' => $header[1],
            'tipo' => $header[0],
        ]);
    }
    /** 
    * Metódo que retorna o display 
    *
    * @return string
    */
    private static function getNome(){

       
       
        $header = Help::helpApp();
      
        return View::render('srv/modules/tela/preview/components/nome',[
            'nome'=> $header->nomeFantasia,
        ]);
    }


    
   

}