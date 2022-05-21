<?php

namespace App\Controller\Api;

class Api{

    /**
     * Retorna as informações da api
     *
     * @param Request $request
     * @return array
     */
    public static function getDetails($request){

        return [
            'nome' => 'API- SRV',
            'versao' => 'v1.0.0',
            'autor' => 'RACS studios',
            'facebook' => 'saoroqueevoce',
            'instagran' => '@saoroqueevoce',
            'whatsapp' => '(11)9 9999-999 ',
            'email' => 'contato@racsstudios.com',
            'site' => 'www.racsstudios.com',
            'descricao' => 'Empresa instalada em São Roque desde 2021, a racs foi fundada dentro do curso de sistemas para internet da Fatec de São Roque, com intuito desenvolver um portal no qual reúnam as informações turísticas da cidade de São Roque,conectando e facilitando a comunicação entre os usuários finais e o comércio local. Mas o caminho não foi fácil antes a racs era conhecida com pixels, e era composta por 5 estudantes onde desenvolveram um portal falando sobre tudo que acontece no mundo das  artes digitais. Mas com a pandemia de COVID-19 tudo ficou mais difícil, diversos colegas tiveram dificuldades em se adaptar com ensino remoto e acabaram trancando suas matrículas, assim a pixels perdeu dois de seus fundadores.Com a chegada do trabalho de graduação e a necessidade de fazer algo que traga benefício a sociedade a PIXELS se une a REINCIDENTES outra equipe formada no início do curso, onde desenvolveram um portal falando sobre música, dessa fusão nasceu a RACS studios.',
            'missao' => 'Proporcionar aos nossos clientes momentos de lazer, descompressão, aprendizado e entretenimento familiar melhorando a qualidade de vida.',
            'visao' => 'Ser referência em desenvolvimento de sistemas e jogos digitais, cuidando da saúde mental das pessoas, inovando e educando.',
            'valores' => 'Ética e Transparência, Criatividade, Colaboção, Cuidado, Comprometimento e Respeito.'
                
        ];
    }

    protected static function getPagination($request,$objPagination){


        $queryParams = $request->getQueryParams();

        $pages = $objPagination->getPages();


        return [
            'paginaAtual'            => isset($queryParams['page']) ? (int)$queryParams['page'] : 1,
            'quantidadeTotalPaginas' => !empty($pages) ? count($pages) : 1
        ];
       
    }
}