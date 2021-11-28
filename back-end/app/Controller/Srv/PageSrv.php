<?php

namespace App\Controller\Srv;

use \App\Utils\View;

class PageSrv{

    private static $modules = [
        'home'  =>[
            'label' => 'Home',
            'link'  => URL.'/srv/home',
            'icon'  => 'home'
        ],
        'detalhes'  =>[
            'label' => 'Detalhes',
            'link'  => URL.'/srv/detalhes',
            'icon'  => 'build'
        ],
        'tela' =>[
            'label' => 'Tela',
            'link'  => URL.'/srv/tela',
            'icon'  => 'stay_current_portrait'
        ],
        'depoimentos' =>[
            'label'   => 'Depoimentos',
            'link'    => URL.'/srv/depoimentos',
            'icon'    => 'comment'
        ],
    ];
    /**
     * Método resposável por retornar o conteúdo (view) da estrutura genérica de página do paineil
     *
     * @param  string $title
     * @param  string $content
     * @return string
     */
    public static function getPage($title, $content ){
       
        return View::render('srv/page',[

            'title'   => $title,
            'content' => $content
        ]);
    }

    /**
     *Renderiza a view do menu
     *
     * @param  string $currentModule
     * @return string
     */
    private static function getMenu($currentModule){
        //Links do menu
        $links = '';
        //Itera os links do menu e compara modulo atual
        foreach(self::$modules as $hash=>$module){
            $links .= View::render('srv/menu/link',[
                'label'   => $module['label'],
                'link'    => $module['link'],
                'current' => $hash == $currentModule ? 'active' : '',
                'icon'    => $module['icon']
            ]);
        }
        //Retorna a view do menu
        return View::render('srv/menu/box',[
            'links' => $links
        ]);
    }
    /**
     * Método resposável por renderiza a view do paineil com conteúdos dinâmicos
     *
     * @param  String $title
     * @param  String $content
     * @param  String $currentModule 
     * @return String
     */
    public static function getPanel($title, $content, $currentModule ){
       
        //Renderiza a view do painel
        $contentPanel = View::render('srv/panel' ,[
            'menu'    => self::getMenu($currentModule),
            'content' => $content
        ]);
        //Retorna a pagina renderizada
        return self::getPage($title,$contentPanel);
    }

    /**
     * Metodo de apoia para criar paginação
     *
     * @param Request $request
     * @param Entity $objPagination
     * @return void
     */
    public static function getPagination($request, $objPagination){

        $paginas = $objPagination->getPages();
       
        //Verifica a quantidade de paginas
        if(count($paginas) <= 1) return '';

        $links = '';
        //URL atual (SEM GETS)
        $url = $request->getRouter()->getCurrentUrl();
       
        //Valores de GET
        $queryParams = $request->getQueryParams();
        
        //Renderiza os links
        foreach ($paginas as $pagina) {
            
            //Altera a pagina
            $queryParams['page'] = $pagina['page'];

            //Link 
            $link = $url.'?'.http_build_query($queryParams);
            
            $links .= View::render('srv/pagination/link',[
                'page' => $pagina['page'],
                'link' => $link,
                // 'active' => $pagina['current'] ? 'active' : ''
            ]);

        }
        //Renderiza box de paginação quando for necessario
        return View::render('srv/pagination/box',[
            'links' => $links,
           
        ]);

    }

}