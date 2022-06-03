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
        'customer'  =>[
            'label' => 'Apps',
            'link'  => URL.'/racs/customer',
            'icon'  => 'remove_red_eye'
        ],
        'apps' =>[
            'label' => 'Create',
            'link'  => URL.'/racs/criar-turismo'||URL.'/racs/criar-servico',
            'icon'  => 'stay_current_portrait'
        ],
        'admin' =>[
            'label'   => 'Roots',
            'link'    => URL.'/racs/admin',
            'icon'    => 'settings'
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

            if($module['label'] == 'Create'){

            $links .= View::render('racs/menu/dropdown/botao',[
                'label'   => $module['label'],
                'icon'    => $module['icon'],
                'current' => $hash == $currentModule ? 'activeRacs' : '',
                
            ]);
            }else{

                $links .= View::render('racs/menu/link',[
                    'label'   => $module['label'],
                    'link'    => $module['link'],
                    'current' => $hash == $currentModule ? 'activeRacs' : '',
                    'icon'    => $module['icon']
                ]);
            }


        
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
    public static function getPanel($title, $content, $currentModule, $mensagem = '' ){
       
        //Renderiza a view do painel
        $contentPanel = View::render('racs/panel' ,[
            'menu'    => self::getMenu($currentModule),
            'content' => $content,
            'mensagem' => $mensagem
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