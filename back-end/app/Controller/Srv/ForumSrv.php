<?php

namespace App\Controller\Srv;

use \App\Utils\View;
use \App\Help\HelpEntity;
use \App\Model\Entity\User\Comment;
use \SandroAmancio\PaginationManager\Pagination;
use \App\Model\Entity\Aplication\App as EntityApp;

class ForumSrv extends PageSrv{

    /**
    * Renderiza o conteúdo da pagina de forum
    *
    * @param Request $request
    * @return String
    */
    public static function getForum($request){

        if(HelpEntity::helpApp()->segmento == 'servicos'){

            $content = View::render('srv/modules/forum/components/servicos',[]);

        }elseif(HelpEntity::helpApp() instanceof EntityApp){

            $content = View::render('srv/modules/forum/index',[
                'foruns'     => self::getForumAlls($request, $obPagination),
                 // 'pagination' => parent::getPagination($request, $obPagination),
     
            ]);

        }else{

             $content = View::render('srv/modules/forum/components/bloqueado',[
               
            ]);

        }

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

            $idApp = HelpEntity::helpApp()->idApp;

            //QUANTIDADE TOTAL DE REGISTROS
            $quatidadeTotal = Comment::getComment("idApp = {$idApp}" ,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;

            if($quatidadeTotal){
                //PAGINA ATUAL
                $queryParams = $request->getQueryParams();
                $pagianaAtual = $queryParams['page'] ?? 1;
                
                //INSTANCIA DE PAGINAÇÃO
                $obPagination = new Pagination($quatidadeTotal,$pagianaAtual, 2);

                //RESULTADOS DA PÁGINA
                $results = Comment::getComment("idApp = {$idApp}",'data  DESC',null);

                //RENDERIZA ITEM
                while($objForum = $results->fetchObject(Comment::class)){
                    $custo= '';
                    for ($i=0; $i < (int)$objForum->custo ; $i++) { 
                        $custo .= '<i class=" tiny material-icons c-success">monetization_on</i>';
                    }

                    $avaliacao= '';
                    for ($i=0; $i < (int)$objForum->avaliacao ; $i++) { 
                        $avaliacao .= '<i class="tiny material-icons srv-c-2">stars</i>';
                    }
                    $itens   .= View::render('srv/modules/forum/components/box/item',[

                    'idForum'  => $objForum->idComment,
                    'idApp'    => $objForum->idApp,
                    'idUser'   => $objForum->idUser,
                    'nome'     => $objForum->nome,
                    'mensagem' => $objForum->comentario,
                    'data'     => date('d/m/Y',strtotime($objForum->data)),
                    'utilSim'  => $objForum->utilSim,
                    'utilNao'  => $objForum->utilNao,
                    'avaliacao'=> $avaliacao,
                    'custo'    => $custo,
                    ]);
                    
                }
        }else{

            $itens   = View::render('srv/modules/forum/components/box/index',[]);
        }

        //RETORNA OS DEPOIMENTOS
        return $itens;
    }
}