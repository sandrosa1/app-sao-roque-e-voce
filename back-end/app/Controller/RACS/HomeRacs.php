<?php

namespace App\Controller\RACS;

use \App\Utils\View;

use \App\Model\Entity\Aplication\App as EntityApp;
use \App\Model\Entity\Customer\Customer as EntityCustomer;
use \App\Model\Entity\User\User as EntityUser;

class HomeRacs extends PageRacs{

    /**
     * Renderiza o conteúdo da Home Administradora 
     * Metódo respónsavel por retornar a view do painel 
     *
     * @param Request $request
     * @return String
     */
    public static function getHome(){

        $dashbord   = "<script>";
        $dashbord  .= self::dashbordNewCustumer();
        $dashbord  .= self::dashbordNewUser();
        $dashbord  .= self::dashbordMostLikes();
        $dashbord  .= self::dashbordMostViewed();
        $dashbord  .= self::dashbordPageMostViewed();
        $dashbord  .= self::dashbordPageMostLikes();
        $dashbord .= self::dashbordMostComments();
        $dashbord .= "</script>";

     
       $content = View::render('racs/modules/home/index',[

        'dashbord'=> $dashbord
       ]);

       return parent::getPanel('HOME - RACS', $content,'home');

    }

    private static function dashbordNewCustumer(){

        //$where = null, $order = null, $limit = null, $fields = '*'
        $customers = EntityCustomer::getCustomerAll();
        $mes01 = 0; $mes02 = 0; $mes03 = 0; $mes04 = 0; $mes05 = 0; $mes06 = 0;
        $mes07 = 0; $mes08 = 0; $mes09 = 0; $mes10 = 0; $mes11 = 0; $mes12 = 0; 
        $total = 0;
        foreach ($customers as $key => $value) {
            $padrao01 = '/2022-01-/';
            $padrao02 = '/2022-02-/';
            $padrao03 = '/2022-03-/';
            $padrao04 = '/2022-04-/';
            $padrao05 = '/2022-05-/';
            $padrao06 = '/2022-06-/';
            $padrao07 = '/2022-07-/';
            $padrao08 = '/2022-08-/';
            $padrao09 = '/2022-09-/';
            $padrao10 = '/2022-10-/';
            $padrao11 = '/2022-11-/';
            $padrao12 = '/2022-12-/';
            $source = $value['createDate'];
            if(preg_match($padrao01,$source)) $mes01 ++ ;
            if(preg_match($padrao02,$source)) $mes02 ++ ;
            if(preg_match($padrao03,$source)) $mes03 ++ ;
            if(preg_match($padrao04,$source)) $mes04 ++ ;
            if(preg_match($padrao05,$source)) $mes05 ++ ;
            if(preg_match($padrao06,$source)) $mes06 ++ ;
            if(preg_match($padrao07,$source)) $mes07 ++ ;
            if(preg_match($padrao08,$source)) $mes08 ++ ;
            if(preg_match($padrao09,$source)) $mes09 ++ ;
            if(preg_match($padrao10,$source)) $mes10 ++ ;
            if(preg_match($padrao11,$source)) $mes11 ++ ;
            if(preg_match($padrao12,$source)) $mes12 ++ ;
         
        }
          
        $dashbord = "const ctx = document.getElementsByClassName('line-chart');
        const chartGraph = new Chart(ctx,{
            type:'line',
            data:{
                labels:['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
                datasets:[
                    {
                        label: 'Novos Clientes',
                        data: [".$mes01.",".$mes02.",".$mes03.",".$mes04.",".$mes05.",".$mes06.",
                        ".$mes07.",".$mes08.",".$mes09.",".$mes10.",".$mes11.",".$mes12."],
                        borderWidth:3,
                        borderColor:'rgba(77,166,253,0.85)',
                        backgroundColor: 'transparent'
                    },
                   
                ]
            },
            options: {
                title: {
                    display: true,
                    fontSize: 20,
                    text: 'Relatorio'
                },
                labels:{
                    fontStyle:'bold'
                }
            }
        });";

        return $dashbord;
    }
    private static function dashbordNewUser(){

        $user = EntityUser::getUserAll();
        $mes01 = 0; $mes02 = 0; $mes03 = 0; $mes04 = 0; $mes05 = 0; $mes06 = 0;
        $mes07 = 0; $mes08 = 0; $mes09 = 0; $mes10 = 0; $mes11 = 0; $mes12 = 0; 
  

        foreach ($user as $key => $value) {
            $padrao01 = '/2022-01-/';
            $padrao02 = '/2022-02-/';
            $padrao03 = '/2022-03-/';
            $padrao04 = '/2022-04-/';
            $padrao05 = '/2022-05-/';
            $padrao06 = '/2022-06-/';
            $padrao07 = '/2022-07-/';
            $padrao08 = '/2022-08-/';
            $padrao09 = '/2022-09-/';
            $padrao10 = '/2022-10-/';
            $padrao11 = '/2022-11-/';
            $padrao12 = '/2022-12-/';
            $source = $value['createDate'];
            if(preg_match($padrao01,$source)) $mes01 ++ ;
            if(preg_match($padrao02,$source)) $mes02 ++ ;
            if(preg_match($padrao03,$source)) $mes03 ++ ;
            if(preg_match($padrao04,$source)) $mes04 ++ ;
            if(preg_match($padrao05,$source)) $mes05 ++ ;
            if(preg_match($padrao06,$source)) $mes06 ++ ;
            if(preg_match($padrao07,$source)) $mes07 ++ ;
            if(preg_match($padrao08,$source)) $mes08 ++ ;
            if(preg_match($padrao09,$source)) $mes09 ++ ;
            if(preg_match($padrao10,$source)) $mes10 ++ ;
            if(preg_match($padrao11,$source)) $mes11 ++ ;
            if(preg_match($padrao12,$source)) $mes12 ++ ;
         
        }
        $dashbord = "const labels =['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];
        
          const data = {
            labels: labels,
            datasets: [{
              label: 'Adesão de Usúario do App',
              backgroundColor: 'transparent',
              borderColor: 'rgb(255, 99, 132)',
              borderWidth:3,
              data: [".$mes01.",".$mes02.",".$mes03.",".$mes04.",".$mes05.",".$mes06.",
              ".$mes07.",".$mes08.",".$mes09.",".$mes10.",".$mes11.",".$mes12."],
            }]
          };
        
          const config = {
            type: 'line',
            data: data,
            options: {}
          };
        
          const myChart1 = new Chart(
            document.getElementById('myChart1'),
            config
          );";

        return $dashbord;
    }

    private static function dashbordMostLikes(){ 

        $apps = EntityApp::getAppAll();
        $turismo         = 0;
        $turismoCont     = 0; 
        $evento          = 0;
        $eventoCont      = 0; 
        $gastronomia     = 0;
        $gastronomiaCont = 0; 
        $hospedagem      = 0;
        $hospedagemCont  = 0; 
        $comercio        = 0;
        $comercioCont    = 0; 
        $servico         = 0;
        $servicoCont     = 0;

        foreach ($apps as $key => $value) {
         
            $totalAvaliacao = (int)$value['totalAvaliacao'];
            if($value['segmento'] == 'turismo')    {
                $turismo    += $totalAvaliacao;
                $totalAvaliacao = 0;
                $turismoCont ++;
               
            }
            if($value['segmento'] == 'hospedagem') {
                $hospedagem   += $totalAvaliacao;
                $totalAvaliacao = 0;
                $hospedagemCont ++;
            }
            if($value['segmento'] == 'servicos')   {

                $servico         += $totalAvaliacao;
                $totalAvaliacao  = 0;
                $servicoCont     ++;
            }
            if($value['segmento'] == 'gastronomia'){
                $gastronomia     += $totalAvaliacao;
                $totalAvaliacao  = 0;
                $gastronomiaCont ++;
                
            }
            if($value['segmento'] == 'comercio')   {
                $comercio   += $totalAvaliacao;
                $totalAvaliacao = 0;
                $comercioCont ++;
            }
            if($value['segmento'] == 'evento')     {
                $evento   += $totalAvaliacao;
                $totalAvaliacao = 0;
                $eventoCont ++;
            }
        }

       

        $turismoAvgLikes     = $turismo / $turismoCont;
        $eventosAvgLikes     = $evento / $eventoCont;
        $gastronomiaAvgLikes = $gastronomia / $gastronomiaCont ;
        $hospedagemAvgLikes  = $hospedagem / $hospedagemCont;
        $servicoAvgLikes     = $servico / $servicoCont; 
        $comercioAvgLikes    = $comercio / $comercioCont; 

        $dashbord = "  const labels5 = [ 'Turismo','Eventos','Gastronomia','Hospedagens','Comércio','Serviços'];
         const data5 = {
            labels: labels5,
          datasets: [{
            axis: 'y',
            label: 'Segmentos Melhores Avalidos',
            data: [".$turismoAvgLikes.",
                   ".$eventosAvgLikes.",
                   ".$gastronomiaAvgLikes.",
                   ".$hospedagemAvgLikes.",
                   ".$comercioAvgLikes.",
                   ".$servicoAvgLikes."],
            fill: false,
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(255, 159, 64, 0.2)',
              'rgba(255, 205, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(153, 102, 255, 0.2)',
              'rgba(201, 203, 207, 0.2)'
            ],
            borderColor: [
              'rgb(255, 99, 132)',
              'rgb(255, 159, 64)',
              'rgb(255, 205, 86)',
              'rgb(75, 192, 192)',
              'rgb(54, 162, 235)',
              'rgb(153, 102, 255)',
              'rgb(201, 203, 207)'
            ],
            borderWidth: 1,
            minBarLength: 100,
        
          }]
        
        
        };
        
        const config5 = {
          type: 'bar',
          data: data5,
          options: {
            indexAxis: 'y',
          }
        };
        
        const myChart5 = new Chart(
            document.getElementById('myChart5'),
            config5
        );";
        return $dashbord;
    }

    private static function dashbordMostViewed(){ 


          $apps = EntityApp::getAppAll();
          $turismo     = 0; 
          $hospedagem  = 0; 
          $servicos    = 0; 
          $gastronomia = 0; 
          $comercio    = 0; 
          $evento      = 0;
        
       
          foreach ($apps as $key => $value) {
           
              $visualizacao = (int)$value['visualizacao'];
              if($value['segmento'] == 'turismo')     $turismo     += $visualizacao;
              if($value['segmento'] == 'hospedagem')  $hospedagem  += $visualizacao;
              if($value['segmento'] == 'servicos')    $servicos    += $visualizacao;
              if($value['segmento'] == 'gastronomia') $gastronomia += $visualizacao;
              if($value['segmento'] == 'comercio')    $comercio    += $visualizacao;
              if($value['segmento'] == 'evento')      $evento      += $visualizacao;
             
              $visualizacao = 0;
          }

         
        $dashbord = " const labels2 = [ 'Turismo','Eventos','Gastronomia','Hospedagens','Comércio','Serviços'];
         const data2 = {
            labels: labels2,
             datasets: [{
            label: 'Segmentos mais Visualizados',
            data: [".$turismo.",".$evento.",".$gastronomia.",". $hospedagem.",".$comercio.",".$servicos."],
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(255, 159, 64, 0.2)',
              'rgba(255, 205, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(153, 102, 255, 0.2)',
              'rgba(201, 203, 207, 0.2)'
            ],
            borderColor: [
              'rgb(255, 99, 132)',
              'rgb(255, 159, 64)',
              'rgb(255, 205, 86)',
              'rgb(75, 192, 192)',
              'rgb(54, 162, 235)',
              'rgb(153, 102, 255)',
              'rgb(201, 203, 207)'
            ],
            borderWidth: 1
          }]
        
        };
        
        const config2 = {
          type: 'bar',
          data: data2,
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          },
        };
        
        const myChart2 = new Chart(
            document.getElementById('myChart2'),
            config2
        );";

        return $dashbord;
        
    }

    private static function dashbordPageMostViewed(){ 

        //$where = null, $order = null, $limit = null, $fields = '*'
        $apps = EntityApp::getAppAll( null,'visualizacao DESC',5);
        $prim     = '';
        $primCont = 0; 
        $seg      = '';
        $segCont  = 0; 
        $ter      = '';
        $terCont  = 0; 
        $qua      = '';
        $quaCont  = 0; 
        $qui      = '';
        $quiCont  = 0; 
    
    

        $aux = 1;
        foreach ($apps as $key => $value) {

           
            if($aux == 1){
                $prim     = $value['nomeFantasia'];
                $primCont = (int)$value['visualizacao'];
            }
            if($aux == 2){ 
                $seg     = $value['nomeFantasia'];
                $segCont = (int)$value['visualizacao'];
            }
            if($aux == 3){
                $ter     = $value['nomeFantasia'];
                $terCont = (int)$value['visualizacao'];
            }
            if($aux == 4){
                $qua     = $value['nomeFantasia'];
                $quaCont = (int)$value['visualizacao'];
            }
            if($aux == 5){
                $qui     = $value['nomeFantasia'];
                $quiCont = (int)$value['visualizacao'];
            }

            $aux ++;
        }
       
        $dashbord = "  
        const data3 = {
              labels: ['".$prim."','".$seg."','".$ter."','". $qua."','".$qui."'],
          datasets: [{
            label: 'Paginas mais visualizadas',
            data: [".$primCont.",".$segCont.",".$terCont.",". $quaCont.",".$quiCont."],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)'
            ],
            hoverOffset: 4
          }]
        };
        
        const config3 = {
          type: 'doughnut',
          data: data3,
        };
        
        const myChart3 = new Chart(
            document.getElementById('myChart3'),
            config3
        );
        ";
        return $dashbord;
    }
    private static function dashbordPageMostLikes(){ 


        //$where = null, $order = null, $limit = null, $fields = '*'
        $apps = EntityApp::getAppAll( null,'estrelas DESC, totalAvaliacao  DESC',5);
        $prim     = '';
        $primCont = 0; 
        $seg      = '';
        $segCont  = 0; 
        $ter      = '';
        $terCont  = 0; 
        $qua      = '';
        $quaCont  = 0; 
        $qui      = '';
        $quiCont  = 0; 
    
        $aux = 1;
        foreach ($apps as $key => $value) {

           
            if($aux == 1){
                $prim     = $value['nomeFantasia']." Nota = ".$value['estrelas']  ;
                $primCont = (int)$value['totalAvaliacao'];
            }
            if($aux == 2){ 
                $seg     = $value['nomeFantasia']." Nota = ".$value['estrelas']  ;
                $segCont = (int)$value['totalAvaliacao'];
            }
            if($aux == 3){
                $ter     = $value['nomeFantasia']." Nota = ".$value['estrelas']  ;
                $terCont = (int)$value['totalAvaliacao'];
            }
            if($aux == 4){
                $qua     = $value['nomeFantasia']." Nota = ".$value['estrelas']  ;
                $quaCont = (int)$value['totalAvaliacao'];
            }
            if($aux == 5){
                $qui     = $value['nomeFantasia']." Nota = ".$value['estrelas']  ;
                $quiCont = (int)$value['totalAvaliacao'];
            }

            $aux ++;
        }
        $dashbord = "const data4 = {
            labels: ['".$prim."','".$seg."','".$ter."','". $qua."','".$qui."'],
            datasets: [{
              label: 'Quantidade por segmento',
              data:  [".$primCont.",".$segCont.",".$terCont.",". $quaCont.",".$quiCont."],
              backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)'
          
              ],
              hoverOffset: 4,
            }]
          };
          
          const config4 = {
            type: 'pie',
            data: data4,
          };
          
          const myChart4 = new Chart(
              document.getElementById('myChart4'),
              config4
          );";
        return $dashbord;
    }
    
    private static function dashbordMostComments(){ 

                //$where = null, $order = null, $limit = null, $fields = '*'
                $apps = EntityApp::getAppAll( null,'totalAvaliacao DESC',5);
                $prim     = '';
                $primCont = ''; 
                $seg      = '';
                $segCont  = ''; 
                $ter      = '';
                $terCont  = ''; 
                $qua      = '';
                $quaCont  = ''; 
                $qui      = '';
                $quiCont  = ''; 
            

                $aux = 1;
                foreach ($apps as $key => $value) {
        
                    if($aux == 1){
                        $prim     = $value['nomeFantasia']." Nota = ".$value['estrelas']  ;
                        $primCont = (int)$value['totalAvaliacao'];
                    }
                    if($aux == 2){ 
                        $seg     = $value['nomeFantasia']." Nota = ".$value['estrelas']  ;
                        $segCont = (int)$value['totalAvaliacao'];
                    }
                    if($aux == 3){
                        $ter     = $value['nomeFantasia']." Nota = ".$value['estrelas']  ;
                        $terCont = (int)$value['totalAvaliacao'];
                    }
                    if($aux == 4){
                        $qua     = $value['nomeFantasia']." Nota = ".$value['estrelas']  ;
                        $quaCont = (int)$value['totalAvaliacao'];
                    }
                    if($aux == 5){
                        $qui     = $value['nomeFantasia']." Nota = ".$value['estrelas']  ;
                        $quiCont = (int)$value['totalAvaliacao'];
                    }


                    $aux ++;
                }

                $dashbord = " const labels6 = ['".$prim."','".$seg."','".$ter."','". $qua."','".$qui."'];
                const data6 = {
                   labels: labels6,
                    datasets: [{
                   label: 'Segmentos mais Visualizados',
                   data: [".$primCont.",".$segCont.",".$terCont.",". $quaCont.",".$quiCont."],
                   backgroundColor: [
                     'rgba(255, 99, 132, 0.2)',
                     'rgba(255, 159, 64, 0.2)',
                     'rgba(255, 205, 86, 0.2)',
                     'rgba(75, 192, 192, 0.2)',
                     'rgba(54, 162, 235, 0.2)',
                     'rgba(153, 102, 255, 0.2)',
                     'rgba(201, 203, 207, 0.2)'
                   ],
                   borderColor: [
                     'rgb(255, 99, 132)',
                     'rgb(255, 159, 64)',
                     'rgb(255, 205, 86)',
                     'rgb(75, 192, 192)',
                     'rgb(54, 162, 235)',
                     'rgb(153, 102, 255)',
                     'rgb(201, 203, 207)'
                   ],
                   borderWidth: 1
                 }]
               
               };
               
               const config6 = {
                 type: 'bar',
                 data: data6,
                 options: {
                   scales: {
                     y: {
                       beginAtZero: true
                     }
                   }
                 },
               };
               
               const myChart6 = new Chart(
                   document.getElementById('myChart6'),
                   config6
               );";
        return $dashbord;
    }
}