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

            $mensagen = "<p>Nome: $dadosContato[0]<p><p>Telefone: $dadosContato[2]</p><p>Telefone: $dadosContato[4]</p><p>Mensagem: $dadosContato[3]</p>";

           $validate->validateSendEmail('racsstudios@gmail.com',$dadosContato[1],$mensagen);

           if(count($validate->getErro()) == 0){
            
                echo "sucesso";
           }else{

                echo '<pre>';
                print_r($validate->getErro());
                echo '</pre>';
                exit;
           }
           
        }else{
            echo '<pre>';
            print_r($validate->getErro());
            echo '</pre>';
            exit;

        }

       
    }
    

}