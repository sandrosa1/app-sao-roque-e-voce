<?php

namespace App\Controller\Api;

use \App\Model\Entity\User\User as EntityUser;
use \App\Model\Entity\User\Comment as EntityComment;
use \App\Validate\Validate;

class User extends Api {

    /**
     * Inserí um novo comentário a um estabelecimento
     *
     * @param Request $request
     * @return array
     */
    public static function setNewUserApp($request){

        $postVars = $request->getPostVars();

        if(!isset($postVars['nomeUsuario']) || !isset($postVars['sobreNome']) || !isset($postVars['dataNascimento']) || !isset($postVars['email']) || !isset($postVars['senha']) ){

            throw new \Exception("Todos os campos são obrigatorios", 400);
            
        }

        $validate = new validate();

        if(!$validate->validateEmail($postVars['email'])){
            throw new \Exception("O email ". $postVars['email']." é inválido.", 404);
        }

        $objUser = EntityUser::getUserByEmail($postVars['email']);

        if($objUser instanceof EntityUser){
            throw new \Exception("Há um usuário utilizado esse email: ".$postVars['email'].".", 404);
        }


        $min = 1000;
        $max = 9999;
        $token = rand($min,$max);

        //Novo usuário
        $objUser = new EntityUser();
        $objUser->nomeUsuario           = $postVars['nomeUsuario'];
        $objUser->sobreNome             = $postVars['sobreNome'];
        $objUser->dataNascimento        = $postVars['dataNascimento'];
        $objUser->email                 = $postVars['email'];
        $objUser->senha                 = password_hash($postVars['senha'], PASSWORD_DEFAULT);
        $objUser->alertaNovidade        = 0;
        $objUser->dicasPontosTuristicos = 0;
        $objUser->dicasRestaurantes     = 0;
        $objUser->dicasHospedagens      = 0;
        $objUser->alertaEventos         = 0;
        $objUser->ativaLocalizacao      = 0;
        $objUser->token                 = password_hash($token, PASSWORD_DEFAULT);
        $objUser->status                = "confirmacao";


        $address = $postVars['email'];

        $subjet = "Codigo de validação São Roque e Você.";

        $body = "<h5>Codigo de validação São Roque e Você.</h5>
        <p>Olá $objUser->nomeUsuario</p>
        <p>Este e seu Codigo de validação</p>
        <p>CODIGO: $token</p>
        <br><br><br>
        <img src='http://www.racsstudios.com/img/logo-srv-300.png' alt='Logotipo do aplicativo São roque e vocẽ'>";

        if(!$validate->validateSendEmail($address, $subjet, $body, $objUser->nomeUsuario)){
            throw new \Exception("Ocorreu um problema na confirmação. Refazer o cadastro.", 404);
        }


        if(!$objUser->insertNewUser()){

            throw new \Exception("Ops. Algo deu errado na inserção dos dados no banco. Tente novamente mais tarde.", 404);

        }

        return [

            'retorno'                => 'success',
            'success'                => 'Aguardado confirmação',
            "nomeUsuario"            => $objUser->nomeUsuario, 
            "sobreNome"              => $objUser->sobreNome, 
            "dataNascimento"         => $objUser->dataNascimento, 
            "email"                  => $objUser->email, 
            "alertaNovidade"         => (int)$objUser->alertaNovidade, 
            "dicasPontosTuristicos"  => (int)$objUser->dicasPontosTuristicos, 
            "dicasRestaurantes"      => (int)$objUser->dicasRestaurantes, 
            "dicasHospedagens"       => (int)$objUser->dicasHospedagens, 
            "alertaEventos"          => (int)$objUser->alertaEventos, 
            "ativaLocalizacao"       => (int)$objUser->ativaLocalizacao, 
            "status"                 => $objUser->status,      

        ];
    }

    /**
     * Atualiza configurações de usuario a um app
     *
     * @param Request $request
     * @return array
     */
    public static function setEditUserApp($request){

        $postVars = $request->getPostVars();

        if(isset($postVars['token'])){
           
            $objUser = EntityUser::getUserById($request->user->idUsuario);

            if(!$objUser instanceof EntityUser){
                throw new \Exception("Não há usuário para o id: ".$request->user->idUsuario.".", 404);
            }
            
            if($objUser->idUsuario != $request->user->idUsuario){
        
                throw new \Exception("As configurções não podem ser alteradas por outro usuário", 404);
    
            }

            if(password_verify($postVars['token'], $objUser->token)){

                $objUser->status    = 'ativo';

                if(!$objUser->updateUser()){

                    throw new \Exception("Ops. Algo deu errado na validação do email.", 404);
    
                }

                $msg = "Validado com sucesso.";

            }else{

                throw new \Exception("Ops. Codigo inválido.", 404);

            }

            return [

                'retorno'                => 'success',
                'success'                => $msg,
                'nomeUsuario'            => $objUser->nomeUsuario,           
                'sobreNome'              => $objUser->sobreNome,             
                'dataNascimento'         => $objUser->dataNascimento,        
                'email'                  => $objUser->email,                                
                "alertaNovidade"         => (int)$objUser->alertaNovidade, 
                "dicasPontosTuristicos"  => (int)$objUser->dicasPontosTuristicos, 
                "dicasRestaurantes"      => (int)$objUser->dicasRestaurantes, 
                "dicasHospedagens"       => (int)$objUser->dicasHospedagens, 
                "alertaEventos"          => (int)$objUser->alertaEventos, 
                "ativaLocalizacao"       => (int)$objUser->ativaLocalizacao,      
                "status"                 => $objUser->status,      
            ];

        }else{

            $objUser = EntityUser::getUserById($request->user->idUsuario);
    
            if(!$objUser instanceof EntityUser){
                throw new \Exception("Não há usuário para o id: ".$request->user->idUsuario.".", 404);
            }
            
            if($objUser->idUsuario != $request->user->idUsuario){
        
                throw new \Exception("As configurções não podem ser alteradas por outro usuário", 404);
    
            }

            if($objUser->status != 'ativo'){

                throw new \Exception("Ops.Aguardado validação pelo email do usuário", 404);

            }
    
            $objUser->alertaNovidade        = $postVars['alertaNovidade'];
            $objUser->dicasPontosTuristicos = $postVars['dicasPontosTuristicos'];
            $objUser->dicasRestaurantes     = $postVars['dicasRestaurantes'];
            $objUser->dicasHospedagens      = $postVars['dicasHospedagens'];
            $objUser->alertaEventos         = $postVars['alertaEventos'];
            $objUser->ativaLocalizacao      = $postVars['ativaLocalizacao'];
           
    
            if(!$objUser->updateUser()){

                throw new \Exception("Ops. Algo na atualização. Tente novamente mais tarde.", 404);

            }
            
    
            //Retorna o commentario atualizado
            return [
                    
                'nomeUsuario'            => $objUser->nomeUsuario,           
                'sobreNome'              => $objUser->sobreNome,             
                'dataNascimento'         => $objUser->dataNascimento,        
                'email'                  => $objUser->email,                                
                "alertaNovidade"         => (int)$objUser->alertaNovidade, 
                "dicasPontosTuristicos"  => (int)$objUser->dicasPontosTuristicos, 
                "dicasRestaurantes"      => (int)$objUser->dicasRestaurantes, 
                "dicasHospedagens"       => (int)$objUser->dicasHospedagens, 
                "alertaEventos"          => (int)$objUser->alertaEventos, 
                "ativaLocalizacao"       => (int)$objUser->ativaLocalizacao,      
            ];

        }
    }
   
    /**
     * Excuir um comentário a um app
     *
     * @param Request $request
     * @return array
     */
    public static function setDeleteUserApp($request){



       $objUser = EntityUser::getUserById($request->user->idUsuario);

        if(!$objUser instanceof EntityUser){
            throw new \Exception("Não há usuário para o idUsuario: ".$request->user->idUsuario.".", 404);
        }
        
        if($objUser->idUsuario != $request->user->idUsuario){
    
            throw new \Exception("O usuário não pode ser excluído por outro usuário", 404);
        }


        $objComment = EntityComment::getCommentByIdUser($objUser->idUsuari);

        if($objComment instanceof EntityComment){ 
            //Exclui todos os comentários
            EntityComment::deleteAllCommentUser($objUser->idUsuario);

        }
        
        //deleta o comentário
        $objUser->deleteUser();

        //Retorna o sucesso da exclusão
        return [
            'success'  => true,  
        ];

    }
   
}