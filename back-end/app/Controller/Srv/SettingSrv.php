<?php

namespace App\Controller\Srv;
use \App\Controller\Srv\Config;
use \App\Validate\Validate;
use \App\Help\HelpEntity;
use \App\Help\Help;
use \App\Model\Entity\Aplication\App as EntityApp;
use \App\Model\Entity\Aplication\Hospedagem\Hospedagem as EntityHospedagem;
use \App\Model\Entity\Aplication\Comercio\Comercio as EntityComercio;
use \App\Model\Entity\Aplication\Evento\Evento as EntityEvento;
use \App\Model\Entity\Aplication\Servico\Servico as EntityServico;
use \App\Model\Entity\Aplication\Gastronomia\Gastronomia as EntityGastronomia;


use \App\Utils\View;

class SettingSrv extends PageSrv{


    /**
    * Renderiza o conteúdo de configurações
    * @param Request $request
    * @return string
    */
    public static function getSetting(){


        $session = new PageSrv();
        $idApp =  $session->idSession;


        $app = EntityApp::getAppById($idApp);

        if($app instanceof EntityApp) {

            $content = View::render('srv/modules/detalhes/index',[
                'boxSeletor'=> self::getSeltor(),
            ]);   
        }else{
            $content = View::render('srv/modules/detalhes/index',[
                'boxSeletor'=> self::getBlock(),
            ]);
        }
       
       return Config::getPanel('Detalhes - SRV', $content,'detalhes');

    }
    /**
     * Metódo respónsavel por retornar a view do botão de cadastrar
     *
     * @return string
     */
    private static function getSeltor(){


        $session = new PageSrv();
        $idApp =  $session->idSession;

        $app =  EntityApp::getAppById($idApp);
      

        switch($app->segmento){

            case 'gastronomia':
                $appSettings = (array)EntityGastronomia::getGastronomiaById($idApp);
                break;
            case 'comercio':
                $appSettings = (array)EntityComercio::getComercioById($idApp);
                break;
            case 'evento':
                $appSettings = (array)EntityEvento::getEventoById($idApp);
                break;
            case 'servicos':
                $appSettings = (array)EntityServico::getServicoById($idApp);
                break;   
            case 'hospedagem':
                $appSettings = (array)EntityHospedagem::getHospedagemById($idApp);
                break; 
        
        }

        $seletores = '';
        foreach ($appSettings as $key => $value) {
                if ($value == -1 ){
                    $seletores .= View::render('srv/modules/detalhes/seletores/seletores',[
                        'item' => $key,
                        'nomeItem' =>  mb_strtoupper(self::converteString($key)),
                        'active' => ''
                    ]);
                }
          
                if ($value == -2 ){
                    $seletores .= View::render('srv/modules/detalhes/seletores/seletores',[
                        'item' => $key,
                        'nomeItem' =>  mb_strtoupper(self::converteString($key)),
                        'active' => 'checked'
                       
                    ]);
                }
             
            }
        
        return View::render('srv/modules/detalhes/seletores/boxSeletor',[
            'seletores' => $seletores,
            'semana'=> $appSettings['semana'],
            'sabado'=> $appSettings['sabado'],
            'domingo'=> $appSettings['domingo'],
            'feriado'=> $appSettings['feriado'],
            'descricao' => $appSettings['descricao']
        ]);

    }
      /**
     * Metódo respónsavel por retornar a view do botão de atualizar e deletar
     *
     * @return string
     */
    private static function getBlock(){
        return View::render('srv/modules/detalhes/seletores/bloqueado',[
            ''
        ]);
    }
   

    private static function converteString($var){

        switch($var){
            case 'entregaDomicilio';
                return 'Entrega Domicilio';
            case 'estacionamento':
                return 'Estacionamento';
            case 'acessibilidade':
                return 'Acessibilidade';
            case 'whatsapp':
                return 'whatsapp';
            case 'wiFi':
                return 'Wi-Fi';
            case 'trilhas':
                return 'Trilha';
            case 'refeicao':
                return 'Refeição';
            case 'emporio':
                return 'Empório';
            case 'adega':
                return 'Adega';
            case 'bebidas':
                return 'Bebidas';
            case 'sorveteria':
                return 'Sorveteria';
            case 'show':
                return 'Shows';
            case 'brinquedos':
                return 'Brinquedos';
            case 'restaurante':
                return 'Restaurante';
            case 'arCondicionado':
                return 'Ar Condi.';
            case 'academia':
                return 'Academia';
            case 'piscina':
                return 'Piscina';
            case 'refeicao':
                return 'Refeição';
            case 'musica':
                return 'Música';
             
         
        }
    }
  
    /**
     * Método responsável pela atualização da pagian de detallhes
     *
     * @param Request $request
     * @return void
     */
    public static function update($request){

        $session = new PageSrv();
        $conf = new Config();
        $validate = new Validate();

        $postVars = $request->getPostVars();
        $idApp =  $session->idSession;
        $app =  EntityApp::getAppById($idApp);
        $validate->validateHora($postVars['semana']);
        $validate->validateHora($postVars['sabado']);
        $validate->validateHora($postVars['domingo']);
        $validate->validateHora($postVars['feriado']);
        $words = Help::helpTextForArray($postVars['descricao']);
        $validate->validateBlockedWord($words);


        if(count($validate->getErro()) > 0){
          
            return self::statusUpdate($validate);
        }

        switch($app->segmento){
            
            case 'hospedagem':
                HelpEntity::helpHospedagem($idApp, $postVars);
                    return self::statusUpdate($validate );

            case 'evento':
                HelpEntity::helpEvento($idApp, $postVars);
                return self::statusUpdate($validate );
                  
            case 'comercio':
                HelpEntity::helpComercio($idApp, $postVars);
                return self::statusUpdate($validate);

            case 'servicos':
               
                HelpEntity::helpServico($idApp, $postVars);
                return self::statusUpdate($validate );

            case 'gastronomia':
                HelpEntity::helpGastronomia($idApp, $postVars);
                return self::statusUpdate($validate);     
        }

    }

    private static function statusUpdate($validate){

        if (count($validate->getErro()) <= 0) {

            $arrResponse = [
                "retorno"  => 'success',
                "success"  => ['Atualizado com sucesso.'],
                "page"     => 'detalhes',
            ];
        }else{

            $arrResponse = [
                "retorno" => 'erro',
                "erros"   => $validate->getErro()
            ];
        }
        return json_encode($arrResponse);
    }

  

}