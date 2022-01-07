<?php

namespace App\Controller\Srv;
use \App\Model\Entity\Aplication\App as EntityApp;
use \App\Model\Entity\Aplication\Hospedagem\Hospedagem as EntityHospedagem;

use \App\Utils\View;

class SettingSrv extends PageSrv{

    
    /**
     * Metódo respónsavel por retornar a view do botão de cadastrar
     *
     * @return string
     */
    private static function getSeltor(){


        $id_customer = $_SESSION['admin']['customer']['idUser'];

        $appHopedagem = (array)EntityHospedagem::getHospedagemById($id_customer);


        $seletores = '';
        foreach ($appHopedagem as $key => $value) {
                if ($value == -1  ){
                    $seletores .= View::render('srv/modules/detalhes/seletores/seletores',[
                        'item' => $key,
                        'nomeItem' => $key,
                        'active' => ''

                       
                    ]);
                }
          
                if ($value == -2 ){
                    $seletores .= View::render('srv/modules/detalhes/seletores/seletores',[
                        'item' => $key,
                        'nomeItem' => $key,
                        'active' => 'checked'
                       
                    ]);
                }
                // echo '<pre>';
                // var_dump($seletores);
                // echo '</pre>';
                // exit;
            }
        
        return View::render('srv/modules/detalhes/seletores/boxSeletor',[
            'seletores' => $seletores,
        ]);

    }
     /**
     * Metódo respónsavel por retornar a view do botão de atualizar e deletar
     *
     * @return string
     */
    private static function getBlock(){
        return View::render('srv/modules/detalhes/seletores/bloqueado');
    }
    /**
    * Renderiza o conteúdo de configurações
    * @param Request $request
    * @return string
    */
    public static function getSetting(){


        $id_customer = $_SESSION['admin']['customer']['idUser'];

        $app = EntityApp::getAppById($id_customer);

        if($app instanceof EntityApp) {

            $content = View::render('srv/modules/detalhes/index',[
                'boxSeletor'=> self::getSeltor(),
            ]);   
        }else{
            $content = View::render('srv/modules/detalhes/index',[
                'seletores'=> self::getBlock(),
            ]);
        }
       
       return parent::getPanel('Detalhes - SRV', $content,'detalhes');

    }

    public static function update($request){

        $postVars = $request->getPostVars();
        echo '<pre>';
        print_r($postVars);
        echo '</pre>';
        exit;
       

    }

  
  
}