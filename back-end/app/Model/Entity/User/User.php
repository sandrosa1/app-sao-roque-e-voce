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
    public $dataNascimento;
    /**
     * 5)
     * Email do usuário
     *
     * @var string
     */
    public $email;
    /**
     * 6)
     * Senha do usuário
     *
     * @var string
     */
    public $senha;
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
    /**
     * 13)
     * Token
     *
     * @var string
     */
    public $token;
     /**
     * 14)
     * Status
     *
     * @var string
     */
    public $status;
    


    public function insertNewUser(){
        
       
        //Inserio os dados do cliete no banco de dados
        $this->idUsuario = (new Database('usuario'))->insert([
            
            'nomeUsuario'              => $this->nomeUsuario, 
            'sobreNome'                => $this->sobreNome, 
            'dataNascimento'           => $this->dataNascimento, 
            'email'                    => $this->email,
            'senha'                    => $this->senha,   
            'alertaNovidade'           => $this->alertaNovidade,
            'dicasPontosTuristicos'    => $this->dicasPontosTuristicos,
            'dicasRestaurantes'        => $this->dicasRestaurantes,
            'dicasHospedagens'         => $this->dicasHospedagens,
            'alertaEventos'            => $this->alertaEventos,
            'ativaLocalizacao'         => $this->ativaLocalizacao,
            'token'                    => $this->token,
            'status'                   => $this->status,
        ]);

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
            'email'                    => $this->email,
            'senha'                    => $this->senha,   
            'alertaNovidade'           => $this->alertaNovidade,
            'dicasPontosTuristicos'    => $this->dicasPontosTuristicos,
            'dicasRestaurantes'        => $this->dicasRestaurantes,
            'dicasHospedagens'         => $this->dicasHospedagens,
            'alertaEventos'            => $this->alertaEventos,
            'ativaLocalizacao'         => $this->ativaLocalizacao,
            'token'                    => $this->token,
            'status'                   => $this->status,
    
               
        ]);
        
        //Sucesso
        return true;
    }

    /**
     * Método reponsável por atualizar o senha
     *
     * @return void
     */
    public function updatePassword(){

        //Inserio os dados do cliete no banco de dados
        return (new Database('usuario'))->update('idUsuario = '.$this->idUsuario,[

            'senha'     => $this->senha,
          
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
     * Método responsável por retotornar um usuário com base em seu email
     *
     * @param string $email
     * @return User
     */
    public static function getUserByEmail($email){

      
        return (new Database('usuario'))->select('email = "'.$email.'"')->fetchObject(self::class);
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