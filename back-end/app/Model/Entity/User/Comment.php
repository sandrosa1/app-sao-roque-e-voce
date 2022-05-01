<?php
namespace App\Model\Entity\User;

use SandroAmancio\DatabaseManager\Database;

class Comment {


    /**
     * ID do formulário
     *
     * @var int
     */
    public $idComment;
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
     * Avaliação
     *
     * @var integer
     */
    public $custo;
    /**
     * Método responsável por inserir um comentário
     *
     * @return void
     */
    public function insertNewComment(){

        $this->data = date("Y-m-d H:i:s");

        $this->idComment = ( new Database('comentario'))->insert([

            
            'idApp'      => $this->idApp,
            'idUsuario'  => $this->idUsuario,
            'nome'       => $this->nome,
            'comentario' => $this->comentario,
            'utilSim'    => $this->utilSim,
            'utilNao'    => $this->utilNao,
            'data'       => $this->data,
            'avaliacao'  => $this->avaliacao,
            'custo'      => $this->custo,

        ]);

        return true;

    }
    /**
     * Método responsável por atualizar um comentário
     *
     * @return void
     */
    public function updateComment(){

        $this->data = date("Y-m-d H:i:s");

        $this->Comment = ( new Database('comentario'))->update('idComment ='.$this->idComment,[
            
            'idApp'      => $this->idApp,
            'idUsuario'  => $this->idUsuario,
            'nome'       => $this->nome,
            'comentario' => $this->comentario,
            'utilSim'    => $this->utilSim,
            'utilNao'    => $this->utilNao,
            'data'       => $this->data,
            'avaliacao'  => $this->avaliacao,
            'custo'      => $this->custo,

        ]); 

        return true;
    }
    /**
     * Método responsável por deletar um comentário
     *
     * @return void
     */
    public function deleteComment(){

        $this->idComment = (new Database('comentario'))->delete('idComment ='.$this->idComment);

        return true;
    }
     /**
     * Método responsável por deletar todos comentarios de um usuario
     *
     * @return void
     */
    public static function deleteAllCommentUser($idUsuario){

        return (new Database('comentario'))->delete('idUsuario ='.$idUsuario);

        
    }
    /**
     * Método responsável por pegar um comentário pelo id do usuário
     *
     * @return void
     */
    public static function getCommentByIdUser($idUsuario){

        return (new Database('comentario'))->select('idUsuario = "'.$idUsuario.'"')->fetchObject(self::class);

    }
    /**
     * Método responsável por pegar um comentário pelo id do App
     *
     * @return void
     */
    public static function getCommentByIdApp($idApp){

        return (new Database('comentario'))->select('idApp = "'.$idApp.'"')->fetchObject(self::class);

    }

    /**
     * Método responsável por pegar um comentário pelo id do App
     *
     * @return void
     */
    public static function getCommentByIdAppComment($idComment){

        return (new Database('comentario'))->select('idComment = "'.$idComment.'"')->fetchObject(self::class);

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
    public static function getComment($where = null, $order = null, $limit = null, $fields = '*'){
        
        return(new Database('comentario'))->select($where, $order, $limit, $fields);

    }

}