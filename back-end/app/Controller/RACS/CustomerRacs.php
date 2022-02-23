<?php

namespace App\Controller\RACS;

use \App\Utils\View;
use \App\Help\Help;

class CustomerRacs extends PageRacs{

    /**
     * Renderiza o conteúdo da view de clientes 
     * 
     *
     * @param Request $request
     * @return string
     */
    public static function getCustomers(){

         $content = View::render('racs/modules/customer/index',[
            'tabelaClientes'    => self::getTabelaClientes(),
            'tabelaApps'        => self::getTabelaApps('app'),
            'tabelaHospedagens' => self::getTabelaApps('hospedagem'),
            'tabelaTurismo'     => self::getTabelaApps('turismo'),
            'tabelaGastronomia' => self::getTabelaApps('gastronomia'),
            'tabelaEventos'     => self::getTabelaApps('evento'),
            'tabelaComercio'    => self::getTabelaApps('comercio'),
            'tabelaServicos'    => self::getTabelaApps('servicos'),
            'previewClientes'   => '',
            'previewApps'       => '',
            'previewHospedagens' => '',
            'previewTurismo'     => '',
            'previewGastronomia' => '',
            'previewEventos'     => '',
            'previewComercio'    => '',
            'previewServicos'    => '',

        ]) ;
            return parent::getPanel('Customer - RACS', $content,'customer');

    }

    /**
     * Retorna a lista de clientes
     *
     * @return string
     */
    private static function getTabelaClientes(){

       return View::render('racs/modules/customer/components/tabela/theadClientes',[
            'tbodyClientes'=> self::getTbodyClientes(),
       ]);
    }


    private static function getTbodyClientes(){

        $customers = Help::hellGetAllsCustomers();

        $content = '';
 
        foreach ($customers as $key => $value) {
 
            $content .= View::render('racs/modules/customer/components/tabela/tbodyClientes',[

                'nome'       => $value['name'],
                'email'      => $value['email'],
                'phone'      => $value['phone'],
                'createDate' => $value['createDate'],
                'status'     => $value['status'],

            ]);
            
         
        }
         return $content ;
    }

    private static function getTabelaApps($segmento){

        return View::render('racs/modules/customer/components/tabela/theadApps',[
            
            'tbodyApps' => self::getTbodySegmento($segmento),
        ]);
     }


    private static function getTbodySegmento($segmento){

        $apps = Help::hellGetAllsApps();

        $content = '';
 
        foreach ($apps as $key => $value) {
 
            if($segmento == $value['segmento'] || $segmento == 'app'){

                $content .= View::render('racs/modules/customer/components/tabela/tbodyApps',[

                    'nomeFantasia' => $value['nomeFantasia'],
                    'segmento'     => ucwords($value['segmento']),
                    'tipo'         => $value['tipo'],
                    'celular'      => $value['celular'],
                    'email'        => $value['email'],

                ]);
            }
         
        }
         return $content ;
    }
 
}

