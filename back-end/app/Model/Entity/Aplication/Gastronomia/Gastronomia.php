<?php

namespace App\Model\Entity\Aplication\Gastronomia;

use \SandroAmancio\DatabaseManager\Database;
use \App\Model\Entity\Aplication\App as dbApp;

class Gastronomia extends dbApp{

    public $id_app;
    public $estacionamento;
    public $acessibilidade;
    public $wi_fi;
    public $briquedos;
    public $restaurante;
    public $emporio;
    public $adega;
    public $bebidas;
    public $sorveteria;
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


    public function insertNewGastronomia(){

        
        $this->id_gastronomia = (new Database('gastronomia'))->insert([

            'id_app'            => $this->id_app,
            'estacionamento'    => $this->estacionamento,
            'acessibilidade'    => $this->acessibilidade,
            'wi_fi'             => $this->wi_fi,
            'briquedos'         => $this->briquedos,
            'restaurante'       => $this->restaurante,
            'emporio'           => $this->emporio,
            'adega'             => $this->adega,
            'bebidas'           => $this->bebidas,
            'sorveteria'        => $this->sorveteria,
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
    * Método responsável por retornar um cliente pelo idUser
    *
    * @param Intenger $id_customer
    * @return Hospedagem
    */
    public static function getGastronomiaById($id_app){

    return self::getGastronomia('id_app = '.$id_app)->fetchObject(self::class);
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
    public static function getGastronomia($where = null, $order = null, $limit = null, $fields = '*'){

    return(new Database('gastronomia'))->select($where, $order, $limit, $fields);
    }

}

