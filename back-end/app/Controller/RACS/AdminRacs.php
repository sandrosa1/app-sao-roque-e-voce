<?php

namespace App\Controller\RACS;

use App\Http\Request;
use \App\Utils\View;
use \App\Model\Entity\RACS\Report as EntityReport;

class AdminRacs extends PageRacs{

    /**
     * Renderiza o conteúdo da view de apps
     * 
     *
     * @param Request $request
     * @return String
     */
    public static function getAdmins($request){

        $queryParams = $request->getQueryParams();

        if(isset($queryParams['idReport']) && isset($queryParams['status'])){

            $report = EntityReport::getReportById($queryParams['idReport']);

            $report->status = $queryParams['status'];

            $report->updateReport();
        }

        $content = View::render('racs/modules/admin/index',[
            'tabela' => self::getTableReport(),

        ]);

       return parent::getPanel('Admin - RACS', $content,'admin');

    }

    private static function getTableReport(){

        return View::render('racs/modules/admin/components/tabelaReport/thead',[

           'tbody' => self::getTbodyReport(),
        ]);

    }


    private static function getTbodyReport(){

        $reports = EntityReport::getReportAll();

        $tbody = '';
        foreach ($reports as $key => $value) {

           if($value['typeReport'] == 'erro') $alert = 'c-error';
           if($value['typeReport'] == 'elogio') $alert = 'c-success';
           if($value['typeReport'] == 'denuncia') $alert = 'c-alert2';
           if($value['typeReport'] == 'outros') $alert = 'c-help';


           if($value['status'] == 'pendente')            $status = 'c-error';
           if($value['status'] == 'Em_Andamento')        $status = 'c-help';
           if($value['status'] == 'Aguardando_Solução') $status = 'c-alert2';
           if($value['status'] == 'Finalizado')          $status = 'c-success';

           $data_inicio = $value['reportDate'];
           $dateReport  =  date("d/m/Y", strtotime($data_inicio));

            $tbody .= View::render('racs/modules/admin/components/tabelaReport/tbody',[
                'idReport'    => $value['idReport'],
                'idUser'      => $value['idUser'],
                'typeReport'  => $value['typeReport'],
                'message'     => $value['message'],
                'status'      => $value['status'],
                'reportDate'  => $dateReport,
                'nome'        => $value['nome'],
                'email'       => $value['email'],
                'alertReport' => $alert,
                'statusReport'=> $status,
            ]);
        }

        return $tbody;
        
    }

    

}