<?php

namespace App\Controller\Srv;

use \App\Utils\View;
use \App\Model\Entity\User\Forum;
use \SandroAmancio\PaginationManager\Pagination;

class ForumSrv extends PageSrv{



    /**
    * Renderiza o conteúdo da pagina de forum
    *
    * @param Request $request
    * @return String
    */
    public static function getForum($request){

       $content = View::render('srv/modules/forum/index',[
           'foruns'     => self::getForumAlls($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination),

       ]);

       return parent::getPanel('Forum - SRV', $content,'forum');

    }

     /**
     * Método responsável por obter a renderização  dos itens do forum para a página
     * @param Request $request
     *  @param Pagination $$obPagination
     * @return string
     */
    private static function getForumAlls($request, &$obPagination){
        //Comentarios
        $itens = '';

        //QUANTIDADE TOTAL DE REGISTROS
        $quatidadeTotal = Forum::getForum('null','null','null','COUNT(*) as qtd')->fetchObject()->qtd;

        //PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $pagianaAtual = $queryParams['page'] ?? 1;
        
        //INSTANCIA DE PAGINAÇÃO
         $obPagination = new Pagination($quatidadeTotal,$pagianaAtual, 2);

        //RESULTADOS DA PÁGINA
        $results = Forum::getForum(null,'id DESC',$obPagination->getLimit());

        //RENDERIZA ITEM
        while($objForum = $results->fetchObject(Forum::class)){
            $itens   .= View::render('srv/modules/forum/components/item',[
            'idForum'  => $objForum->idForum,
            'idApp'    => $objForum->idApp,
            'idUser'   => $objForum->idUser,
            'nome'     => $objForum->nome,
            'mensagem' => $objForum->comentario,
            'data'     => date('d/m/Y H:i:s',strtotime($objForum->data)),
            'utilSim'  => $objForum->utilSim,
            'utilNao'  => $objForum->utilNao,
            'avaliacao'=> $objForum->avaliacao,
            ]);
            
        }

        //RETORNA OS DEPOIMENTOS
        return $itens;
    }
}