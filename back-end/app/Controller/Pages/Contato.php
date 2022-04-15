<?php

namespace App\Controller\Pages;

use App\Utils\View;
use App\Validate\Validate;

class Contato extends Page{

    public static function getContato(){

        $content = View::render('pages/contato',[]);

        return parent::getPage('Contato RACS',$content, null);
    
    }

    public static function postContato($request){

        $postVars = $request->getPostVars();
        

        $dadosContato = [];
        $dadosContato[0]= $postVars['nome'];
        $dadosContato[1]= $postVars['assunto'];
        $dadosContato[2]= $postVars['email'];
        $dadosContato[3]= $postVars['mensagem'];
        $dadosContato[4]= $postVars['telefone'];
        $dadosContato[5]= $postVars['g-recaptcha-response'];

        $validate = new Validate();

        $validate->validateFields($dadosContato);
        $validate->validateEmail($dadosContato[2]);
        $validate->validateCaptcha($dadosContato[5]);


        if(count($validate->getErro()) == 0){

            $mensagen = "Nome: $dadosContato[0]
                         Assunto: $dadosContato[1]
                         Email: $dadosContato[2]
                         Mensagem: $dadosContato[3]";

           $validate->validateSendEmail('racsstudios@gmail.com',$dadosContato[1],$mensagen, $dadosContato[0]);

           if(count($validate->getErro()) == 0){
            
                $arrResponse=[
                    "retorno" => "success",
                    "page"    => "/",
                    "success" => ["Contato realizado com sucesso.","Em Breve entraremos em contato."]
                ];   
          
            }else{

                $arrResponse=[
                    "retorno" => "erro",
                    "erros"   => $validate->getErro()
                ];
            }
           
        }else{
            $arrResponse=[
                "retorno" => "erro",
                "erros"   => $validate->getErro()
            ];

        }
        
        return json_encode($arrResponse);
       
    }
    

}