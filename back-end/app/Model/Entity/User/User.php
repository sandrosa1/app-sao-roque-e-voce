<?php
namespace App\Model\Entity\User;

use \SandroAmancio\DatabaseManager\Database;



class User{
    /**
     * 1)
     * ID do usuário
     *
     * @var integer
     */
    public $idUsuario;
    /**
     * 2)
     * Nome de usuário
     *
     * @var string
     */
    public $nomeUsuario;
    /**
     * 3)
     * Sobrenome do usuário
     *
     * @var string
     */
    public $sobreNome;
    /**
    * 4)
     * Data de nascimento
     *
     * @var string
     */
    public $usuarioDataNascimento;
    /**
     * 5)
     * Email do usuário
     *
     * @var string
     */
    public $usuarioEmail;
    /**
     * 6)
     * Senha do usuário
     *
     * @var string
     */
    public $usuarioSenha;
    /**
     * 7)
     * alerta de novidades
     *
     * @var integer
     */
    public $alertaNovidade;
    /**
     * 8)
     * Dicas de pontos turisticos
     *
     * @var integer
     */
    public $dicasPontosTuristicos;
    /**
     * 9)
     * Dicas de restaurantes
     *
     * @var integer
     */
    public $dicasRestaurantes;
    /**
     * 10)
     * Dicas de hospedagens
     *
     * @var integer
     */
    public $dicasHospedagens;
    /**
     * 11)
     * Alerta de eventos
     *
     * @var integer
     */
    public $alertaEventos;   
    /**
     * 12)
     * Ativa localização
     *
     * @var integer
     */
    public $ativaLocalizacao;
    


    // public static function getUserToken($usuarioEmail){

    //     return (new Database('confirmation'))->select('usuarioEmail = "'.$usuarioEmail.'"')->fetchObject(self::class);
    // }

    // public static function confirmationCad($idUsuario,$dicasRestaurantes){


    //     return (new Database('usuario'))->update('idUsuario = '.$idUsuario,[

    //         'dicasRestaurantes'       => $dicasRestaurantes,
    //     ]);

    //     return true;

    // }


    public function insertNewUser(){
        
       
        //Inserio os dados do cliete no banco de dados
        $this->idUsuario = (new Database('usuario'))->insert([
            
            'nomeUsuario'              => $this->nomeUsuario, 
            'sobreNome'                => $this->sobreNome, 
            'dataNascimento'           => $this->dataNascimento, 
            'usuarioEmail'             => $this->usuarioEmail,
            'usuarioSenha'             => $this->usuarioSenha,   
            'alertaNovidade'           => $this->alertaNovidade,
            'dicasPontosTuristicos'    => $this->dicasPontosTuristicos,
            'dicasRestaurantes'        => $this->dicasRestaurantes,
            'dicasHospedagens'         => $this->dicasHospedagens,
            'alertaEventos'            => $this->alertaEventos,
            'ativaLocalizacao'         => $this->ativaLocalizacao,
        ]);

        // $this->id = (new Database('confirmation'))->insert([
            
        //     'usuarioEmail'  => $this->usuarioEmail,
        //     'dicasHospedagens'  => $this->dicasHospedagens,
           
        // ]);
        //Sucesso
        return true;
    }

    /**
     * Método reponsável por atualizar o usuário
     *
     * @return void
     */
    public function updateUser(){

        //Inserio os dados do cliete no banco de dados
        return (new Database('usuario'))->update('idUsuario = '.$this->idUsuario,[

            'nomeUsuario'              => $this->nomeUsuario, 
            'sobreNome'                => $this->sobreNome, 
            'dataNascimento'           => $this->dataNascimento, 
            'usuarioEmail'             => $this->usuarioEmail,
            'usuarioSenha'             => $this->usuarioSenha,   
            'alertaNovidade'           => $this->alertaNovidade,
            'dicasPontosTuristicos'    => $this->dicasPontosTuristicos,
            'dicasRestaurantes'        => $this->dicasRestaurantes,
            'dicasHospedagens'         => $this->dicasHospedagens,
            'alertaEventos'            => $this->alertaEventos,
            'ativaLocalizacao'         => $this->ativaLocalizacao,
               
        ]);
        
        //Sucesso
        return true;
    }

    /**
     * Método reponsável por atualizar o usuarioSenha
     *
     * @return void
     */
    public function updatePassword(){

        //Inserio os dados do cliete no banco de dados
        return (new Database('usuario'))->update('idUsuario = '.$this->idUsuario,[

            'usuarioSenha'     => $this->usuarioSenha,
          
        ]);
        
        //Sucesso
        return true;

    }

    /**
     * Método reponsável por deletar um usuário
     *
     * @return void
     */
    public function deleteUser(){

        //Inserio os dados do cliete no banco de dados
        return (new Database('usuario'))->delete('idUsuario = '.$this->idUsuario);
        
        //Sucesso
        return true;

    }
   /**
     * Método responsável por retornar um usuário pelo idUsuario
     *
     * @param Intenger $idUsuario
     * @return User
     */
    public static function getUserById($idUsuario){

        return self::getUser('idUsuario = '.$idUsuario)->fetchObject(self::class);
        
    }
   
    /**
     * Método responsável por retotornar um usuário com base em seu usuarioEmail
     *
     * @param string $usuarioEmail
     * @return User
     */
    public static function getUserByEmail($usuarioEmail){

      
        return (new Database('usuario'))->select('usuarioEmail = "'.$usuarioEmail.'"')->fetchObject(self::class);
    }

     /**
     * Método responsavel por retornar depoimentos
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getUser($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('usuario'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método responsavel por retornar todos usuários
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getUserAll($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('usuario'))->select($where, $order, $limit, $fields)->fetchAll();
    }

}