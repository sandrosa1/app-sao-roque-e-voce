<?php

namespace App\Model\Entity\Aplication\Gastronomia;

use \SandroAmancio\DatabaseManager\Database;

class Gastronomia {

    public $idApp;
    public $idAppGastronomia;
    public $estacionamento;
    public $acessibilidade;
    public $wiFi;
    public $brinquedos;
    public $restaurante;
    public $emporio;
    public $adega;
    public $bebidas;
    public $sorveteria;
    public $entregaDomicilio;
    public $whatsapp;
    public $semana;
    public $sabado;
    public $domingo;
    public $feriado;
    public $img2;
    public $img3;
    public $descricao;



    /**
     * Metódo responsável por inserir um novo servico gastronomico
     *
     * @return void
     */
    public function insertNewGastronomia(){

        
        $this->idAppGastronomia = (new Database('appGastronomia'))->insert([

            'idApp'             => $this->idApp,
            'estacionamento'    => $this->estacionamento,
            'acessibilidade'    => $this->acessibilidade,
            'wiFi'              => $this->wiFi,
            'brinquedos'        => $this->brinquedos,
            'restaurante'       => $this->restaurante,
            'emporio'           => $this->emporio,
            'adega'             => $this->adega,
            'bebidas'           => $this->bebidas,
            'sorveteria'        => $this->sorveteria,
            'entregaDomicilio'  => $this->entregaDomicilio,
            'whatsapp'          => $this->whatsapp,
            'semana'            => $this->semana,
            'sabado'            => $this->sabado,
            'domingo'           => $this->domingo,
            'feriado'           => $this->feriado, 
            'img2'              => $this->img2,
            'img3'              => $this->img3,
            'descricao'         => $this->descricao,
        ]);

        return true;
    }

    /**
     * Método reponsável por atualizar os dados de um serviço gastronomico
     *
     * @return void
     */
    public function updateGastronomia(){

  
        return (new Database('appGastronomia'))->update('idApp = '.$this->idApp,[

            'estacionamento'    => $this->estacionamento,
            'acessibilidade'    => $this->acessibilidade,
            'wiFi'              => $this->wiFi,
            'brinquedos'        => $this->brinquedos,
            'restaurante'       => $this->restaurante,
            'emporio'           => $this->emporio,
            'adega'             => $this->adega,
            'bebidas'           => $this->bebidas,
            'sorveteria'        => $this->sorveteria,
            'entregaDomicilio'  => $this->entregaDomicilio,
            'whatsapp'          => $this->whatsapp,
            'semana'            => $this->semana,
            'sabado'            => $this->sabado,
            'domingo'           => $this->domingo,
            'img2'              => $this->img2,
            'img3'              => $this->img3,
            'descricao'         => $this->descricao,
            'feriado'           => $this->feriado,

            
        ]);
        
        //Sucesso
        return true;

    }

     /**
     * Método reponsável por deletar uma hospedagem
     *
     * @return void
     */
    public static function deleteGastronomia($idApp){

        return (new Database('appGastronomia'))->delete('idApp = '.$idApp);
        
        //Sucesso
        return true;

    }

    /**
    * Método responsável por retornar um serviço gastronomico pelo idApp
    *
    * @param Intenger $idApp
    * @return Hospedagem
    */
    public static function getGastronomiaById($idApp){

    return self::getGastronomia('idApp = '.$idApp)->fetchObject(self::class);
    }

    /**
    * Método responsavel por retornar todos serviços gastronomicos
    *
    * @param string $where
    * @param string $order
    * @param string $limit
    * @param string $fields
    * @return PDOStatement
    */
    public static function getGastronomia($where = null, $order = null, $limit = null, $fields = '*'){

    return(new Database('appGastronomia'))->select($where, $order, $limit, $fields);
    }

}

