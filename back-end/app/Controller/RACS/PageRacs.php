<?php

namespace App\Controller\RACS;

use \App\Utils\View;

class PageRacs{

    private static $modules = [
        'home'  =>[
            'label' => 'Home',
            'link'  => URL.'/racs/home',
            'icon'  => 'home'
        ],
        'clientes'  =>[
            'label' => 'Clientes',
            'link'  => URL.'/racs/customer',
            'icon'  => 'build'
        ],
        'apps' =>[
            'label' => 'APPs',
            'link'  => URL.'/racs/apps',
            'icon'  => 'stay_current_portrait'
        ],
        'admin' =>[
            'label'   => 'Administradores',
            'link'    => URL.'/racs/admin',
            'icon'    => 'comment'
        ],
    ];
    /**
     * Método resposável por retornar o conteúdo (view) da estrutura genérica de página do painel
     *
     * @param  string $title
     * @param  string $content
     * @return string
     */
    public static function getPage($title, $content ){
       
        return View::render('racs/page',[

            'title'   => $title,
            'content' => $content,
          
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
            $links .= View::render('racs/menu/link',[
                'label'   => $module['label'],
                'link'    => $module['link'],
                'current' => $hash == $currentModule ? 'active-racs' : '',
                'icon'    => $module['icon']
            ]);
        }
        //Retorna a view do menu
        return View::render('racs/menu/box',[
            'links' => $links
        ]);
    }
    /**
     * Método resposável por renderiza a view do paineil com conteúdos dinâmicos
     *
     * @param  string $title
     * @param  string $content
     * @param  string $currentModule 
     * @return string
     */
    public static function getPanel($title, $content, $currentModule ){
       
        //Renderiza a view do painel
        $contentPanel = View::render('racs/panel' ,[
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
     * @return string
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
            
            $links .= View::render('racs/pagination/link',[
                'page' => $pagina['page'],
                'link' => $link,
                // 'active' => $pagina['current'] ? 'active' : ''
            ]);

        }
        //Renderiza box de paginação quando for necessario
        return View::render('racs/pagination/box',[
            'links' => $links,
           
        ]);
    }

}