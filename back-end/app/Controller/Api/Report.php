<?php

namespace App\Controller\Api;


use \App\Model\Entity\RACS\Report as EntityReport;

use \App\Validate\Validate;

class Report extends Api {

    /**
     * 
     * Inserí um novo comentário a um estabelecimento
     *
     * @param Request $request
     * @return array
     */
    public static function setNewUserReport($request){


        $postVars = $request->getPostVars();


        if( !isset($postVars['typeReport']) || !isset($postVars['message']) || !isset($postVars['nome']) || !isset($postVars['email']) ){

            throw new \Exception("Todos os campos são obrigatórios", 400);
        }

        $validate = new validate();

        if(!$validate->validateBlockedWord($postVars['message'])){
            throw new \Exception("Existem palavas improprias", 404);
        }

        if(!$validate->validateEmail($postVars['email'])){
            throw new \Exception("Existem palavas improprias", 404);
        }

      
        $saudacao = '';
        $mensagem = '';

        if($postVars['typeReport'] == 'erro'){
            $saudacao = "Erro reportado com sucesso";
            $mensagem = "Obrigado por nós ajudar relatando um problema, se necessário entraremos em contato para mais informações.";
        }

        if($postVars['typeReport'] == 'elogio'){
            $saudacao = "Elogio reportado com sucesso";
            $mensagem = "A satisfação de nossos clientes e o combustível que move nosso trabalho. Muito obrigado por elogiar o App São Roque e Você.";
        }

        if($postVars['typeReport'] == 'denuncia'){
            $saudacao = "Denúncia reportada com sucesso";
            $mensagem = "Obrigado por nós informar sobre o conteúdo malicioso, vamos analisar a página e comunicar ao responsável.";
        }
        if($postVars['typeReport'] == 'outros'){
            $saudacao = "Messagem reportada com sucesso";
            $mensagem = "A equipe São Roque e Você ira analisar sua mensagem, aguarde retorno se necessário.";
        }


        

        //Novo usuário
        $objUser = new EntityReport();
        if(!$postVars['idUser']){
            $objUser->idUser = 0;
        }

        $objUser->idUser                = $postVars['idUser'];
        $objUser->typeReport            = $postVars['typeReport'];
        $objUser->message               = $postVars['message'];
        $objUser->email                 = $postVars['email'];
        $objUser->nome                  = $postVars['nome'];
        $objUser->status                = "pendente";


        $address = $postVars['email'];

        $subjet = "São Roque e Você.";

        $body = "<h5>$saudacao</h5>
        <p>Olá $objUser->nomeUsuario</p>
        <p>$mensagem</p>
        <p>Atenciosamente:/p>
        <br><br><br>
        <img src='http://www.racsstudios.com/img/logo-srv-300.png' alt='Logotipo do aplicativo São roque e vocẽ'>";

        if(!$validate->validateSendEmail($address, $subjet, $body, $objUser->nomeUsuario)){
            throw new \Exception("Ocorreu um problema no evio da mensagem.", 404);
        }


        if(!$objUser->insertNewReport()){

            throw new \Exception("Ops. Algo deu errado na inserção dos dados no banco. Tente novamente mais tarde.", 404);

        }

        return [

            'retorno'  => 'success',
            'success'  => 'Mensagem envida com sucesso.',
        ];
    }

   
   
}