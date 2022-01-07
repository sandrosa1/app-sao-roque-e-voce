<?php

namespace App\Model\Entity\Aplication\Comercio;

use \SandroAmancio\DatabaseManager\Database;

use \App\Model\Entity\Aplication\App as dbApp;

class Comercio extends dbApp{


    public $idComercio;
    public $idApp;
    public $estacionamento;
    public $acessibilidade;
    public $entrega_domicilio;
    public $whatsapp;
    public $semana;
    public $sabado;
    public $domigo;
    public $logo;
    public $img1;
    public $img2;
    public $img3;
    public $descricao;
    public $feriado;
    public $complementos;

  

    /**
     * Metódo responsável por inserir um novo comercio
     *
     * @return void
     */
    public function insertNewComercio(){

        $this->idComercio = (new Database('comercio'))->insert([
            'idApp'             => $this->idApp,
            'estacionamento'    => $this->estacionamento,
            'acessibilidade'    => $this->acessibilidade,
            'entrega_domicilio' => $this->entrega_domicilio,
            'whatsapp'          => $this->whatsapp,
            'semana'            => $this->semana,
            'sabado'            => $this->sabado,
            'domigo'            => $this->domigo,
            'logo'              => $this->logo,
            'img1'              => $this->img1,
            'img2'              => $this->img2,
            'img3'              => $this->img3,
            'descricao'         => $this->descricao,
            'feriado'           => $this->feriado,
            'complementos'      => $this->complementos, 
        ]);

        return true;

    }
    /**
     * Método reponsável por atualizar os dados de um comercio
     *
     * @return void
     */
    public function updateComercio(){

  
        return (new Database('comercio'))->update('idApp = '.$this->idApp,[

            'idApp'             => $this->idApp,
            'estacionamento'    => $this->estacionamento,
            'acessibilidade'    => $this->acessibilidade,
            'entrega_domicilio' => $this->entrega_domicilio,
            'whatsapp'          => $this->whatsapp,
            'semana'            => $this->semana,
            'sabado'            => $this->sabado,
            'domigo'            => $this->domigo,
            'logo'              => $this->logo,
            'img1'              => $this->img1,
            'img2'              => $this->img2,
            'img3'              => $this->img3,
            'descricao'         => $this->descricao,
            'feriado'           => $this->feriado,
            'complementos'      => $this->complementos, 
        ]);
        
        return true;

    }
     /**
     * Método reponsável por deletar um comercio
     *
     * @return void
     */
    public function deleteHos(){

        return (new Database('comercio'))->delete('idApp = '.$this->idApp);
        
        return true;

    }
    /**
     * Método responsável por retornar um comercio peço idApp
     *
     * @param Intenger $idAdd
     * @return Comercio
     */
    public static function getComercioById($idApp){

        return self::getComercio('idApp = '.$idApp)->fetchObject(self::class);
    }
    /**
     * Método responsavel por retornar todos comercios
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getComercio($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('comercio'))->select($where, $order, $limit, $fields);
    }

}

