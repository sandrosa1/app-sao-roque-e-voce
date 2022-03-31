<?php
namespace App\Model\Entity\User;

use SandroAmancio\DatabaseManager\Database;

class Forum {


    /**
     * ID do formulário
     *
     * @var int
     */
    public $idForum;
    /**
     * ID do App
     *
     * @var int
     */
    public $idApp;
    /**
     * ID do usuário
     *
     * @var integer
     */
    public $idUsuario;
    /**
     * First name
     *
     * @var string
     */
    public $nome;
    /**
     * Comentario
     *
     * @var string
     */
    public $comentario;
    /**
     * Comentario foi util
     *
     * @var integer
     */
    public $utilSim;
    /**
     * Comentário não foi utíl
     *
     * @var string
     */
    public $utilNao;
    /**
     * Date
     *
     * @var [type]
     */
    public $data;
    /**
     * Avaliação
     *
     * @var integer
     */
    public $avaliacao;

    /**
     * Método responsável por inserir um comentário
     *
     * @return void
     */
    public function insertNewForum(){

        $this->idForum = ( new Database('forum'))->insert([

            
            'idApp'      => $this->idApp,
            'idUsuario'  => $this->idUsuario,
            'nome'       => $this->nome,
            'comentario' => $this->comentario,
            'utilSim'    => $this->utilSim,
            'utilNao'    => $this->utilNao,
            'data'       => $this->data,
            'avaliacao'  => $this->avaliacao,

        ]);

        return true;

    }
    /**
     * Método responsável por atualizar um comentário
     *
     * @return void
     */
    public function updateForum(){

        $this->Forum = ( new Database('forum'))->update('idForum ='.$this->idForum,[
            
            'idApp'      => $this->idApp,
            'idUsuario'  => $this->idUsuario,
            'nome'       => $this->nome,
            'comentario' => $this->comentario,
            'utilSim'    => $this->utilSim,
            'utilNao'    => $this->utilNao,
            'data'       => $this->data,
            'avaliacao'  => $this->avaliacao,
        ]); 

        return true;
    }
    /**
     * Método responsável por deletar um comentário
     *
     * @return void
     */
    public function deleteForum(){

        $this->idForum = (new Database('forum'))->delete('idForum ='.$this->idForum);

        return true;
    }
    /**
     * Método responsável por pegar um comentário pelo id do usuário
     *
     * @return void
     */
    public static function getForumByIdUser($idUser){

        return (new Database('forum'))->select('idUser = "'.$idUser.'"')->fetchObject(self::class);

    }
    /**
     * Método responsável por pegar um comentário pelo id do App
     *
     * @return void
     */
    public static function getForumByIdApp($idApp){

        return (new Database('forum'))->select('idApp = "'.$idApp.'"')->fetchObject(self::class);

    }
    /**
     * Método responsavel por retornar todos App
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public function getForum($where = null, $order = null, $limit = null, $fields = '*'){
        
        return(new Database('forum'))->select($where, $order, $limit, $fields);

    }

}