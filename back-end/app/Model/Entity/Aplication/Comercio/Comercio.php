<?php

namespace App\Model\Entity\Aplication\Comercio;

use \SandroAmancio\DatabaseManager\Database;

use \App\Model\Entity\Aplication\App as dbApp;

class Comercio extends dbApp{


    public $idAppComercio;
    public $idApp;
    public $estacionamento;
    public $acessibilidade;
    public $entregaDomicilio;
    public $whatsapp;
    public $semana;
    public $sabado;
    public $domigo;
    public $feriado;
    public $img2;
    public $img3;
    public $descricao;

  

    /**
     * Metódo responsável por inserir um novo appComercio
     *
     * @return void
     */
    public function insertNewComercio(){

        $this->idAppComercio = (new Database('appComercio'))->insert([
            'idApp'             => $this->idApp,
            'estacionamento'    => $this->estacionamento,
            'acessibilidade'    => $this->acessibilidade,
            'entregaDomicilio'  => $this->entregaDomicilio,
            'whatsapp'          => $this->whatsapp,
            'semana'            => $this->semana,
            'sabado'            => $this->sabado,
            'domigo'            => $this->domigo,
            'feriado'           => $this->feriado,
            'img2'              => $this->img2,
            'img3'              => $this->img3,
            'descricao'         => $this->descricao,
        ]);

        return true;

    }
    /**
     * Método reponsável por atualizar os dados de um appComercio
     *
     * @return void
     */
    public function updateComercio(){

  
        return (new Database('appComercio'))->update('idApp = '.$this->idApp,[

            'estacionamento'    => $this->estacionamento,
            'acessibilidade'    => $this->acessibilidade,
            'entregaDomicilio'  => $this->entregaDomicilio,
            'whatsapp'          => $this->whatsapp,
            'semana'            => $this->semana,
            'sabado'            => $this->sabado,
            'domigo'            => $this->domigo,
            'feriado'           => $this->feriado,
            'img2'              => $this->img2,
            'img3'              => $this->img3,
            'descricao'         => $this->descricao, 
        ]);
        
        return true;

    }
     /**
     * Método reponsável por deletar um appComercio
     *
     * @return void
     */
    public static function deleteComercio($idApp){

        return (new Database('appComercio'))->delete('idApp = '.$idApp);
        
        return true;

    }
    /**
     * Método responsável por retornar um appComercio peço idApp
     *
     * @param Intenger $idAdd
     * @return Comercio
     */
    public static function getComercioById($idApp){

        return self::getComercio('idApp = '.$idApp)->fetchObject(self::class);
    }
    /**
     * Método responsavel por retornar todos appComercios
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getComercio($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('appComercio'))->select($where, $order, $limit, $fields);
    }

}

