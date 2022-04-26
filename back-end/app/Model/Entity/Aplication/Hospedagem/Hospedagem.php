<?php

namespace App\Model\Entity\Aplication\Hospedagem;

use \SandroAmancio\DatabaseManager\Database;

class Hospedagem {


    public $idAppHospedagem;
    public $idApp;
    public $estacionamento;
    public $brinquedos;
    public $restaurante;
    public $arCondicionado;
    public $wiFi;
    public $academia;
    public $piscina;
    public $refeicao;
    public $emporio;
    public $adega;
    public $bebidas;
    public $sorveteria;
    public $whatsapp;
    public $semana;
    public $sabado;
    public $domingo;
    public $feriado;
    public $img2;
    public $img3;
    public $descricao;

  

    public function insertNewHospedagem(){

        $this->idAppHospedagem = (new Database('appHospedagem'))->insert([

            'idApp'             => $this->idApp,
            'estacionamento'    => $this->estacionamento,
            'brinquedos'        => $this->brinquedos,
            'restaurante'       => $this->restaurante,
            'arCondicionado'    => $this->arCondicionado,
            'wiFi'              => $this->wiFi,
            'academia'          => $this->academia,
            'piscina'           => $this->piscina,
            'refeicao'          => $this->refeicao,
            'emporio'           => $this->emporio,
            'adega'             => $this->adega,
            'bebidas'           => $this->bebidas,
            'sorveteria'        => $this->sorveteria,
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
     * Método reponsável por atualizar os dados de uma appHospedagem
     *
     * @return void
     */
    public function updateHospedagem(){

        //Atualiza os dados gerais da appHospedagem
        return (new Database('appHospedagem'))->update('idAppHospedagem = '.$this->idAppHospedagem,[

     
            'estacionamento'    => $this->estacionamento,
            'brinquedos'         => $this->brinquedos,
            'restaurante'       => $this->restaurante,
            'arCondicionado'    => $this->arCondicionado,
            'wiFi'              => $this->wiFi,
            'academia'          => $this->academia,
            'piscina'           => $this->piscina,
            'refeicao'          => $this->refeicao,
            'emporio'           => $this->emporio,
            'adega'             => $this->adega,
            'bebidas'           => $this->bebidas,
            'sorveteria'        => $this->sorveteria,
            'whatsapp'          => $this->whatsapp,
            'semana'            => $this->semana,
            'sabado'            => $this->sabado,
            'domingo'           => $this->domingo,
            'feriado'           => $this->feriado,
            'img2'              => $this->img2,
            'img3'              => $this->img3,
            'descricao'         => $this->descricao,
            
        ]);
        
        //Sucesso
        return true;

    }

     /**
     * Método reponsável por deletar uma appHospedagem
     *
     * @return void
     */
    public static function deleteHospedagem($idApp){

        return (new Database('appHospedagem'))->delete('idApp = '.$idApp);
        
        //Sucesso
        return true;

    }

     /**
     * Método responsável por retornar uma appHospedagem pelo idApp
     *
     * @param Intenger $id_customer
     * @return Hospedagem
     */
    public static function getHospedagemById($idApp){

        return self::getHospedagem('idApp = '.$idApp)->fetchObject(self::class);
    }

     /**
     * Método responsavel por retornar todas as appHospedagem
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getHospedagem($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('appHospedagem'))->select($where, $order, $limit, $fields);
    }

}


