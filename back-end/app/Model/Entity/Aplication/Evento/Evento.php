<?php
namespace App\Model\Entity\Aplication\Evento;

use \SandroAmancio\DatabaseManager\Database;
use \App\Model\Entity\Aplication\App as dbApp;

class Evento extends dbApp{

        public $id_app;
        public $estacionamento;
        public $acessibilidade;
        public $wi_fi;
        public $trilhas;
        public $refeicao;
        public $emporio;
        public $adega;
        public $bebidas;
        public $sorveteria;
        public $show;
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


    public function insertNewEvento(){
    
        $this->id_evento = (new Database('evento'))->insert([
            'id_app'            => $this->id_app,
            'estacionamento'    => $this->estacionamento,
            'acessibilidade'    => $this->acessibilidade,
            'wi_fi'             => $this->wi_fi,
            'trilhas'           => $this->trilhas,
            'refeicao'          => $this->refeicao,
            'emporio'           => $this->emporio,
            'adega'             => $this->adega,
            'bebidas'           => $this->bebidas,
            'sorveteria'        => $this->sorveteria,
            'musica'            => $this->musica,
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
    * @return Evento
    */
    public static function getEventoById($id_app){

        return self::getEvento('id_app = '.$id_app)->fetchObject(self::class);
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
    public static function getEvento($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('evento'))->select($where, $order, $limit, $fields);
    }




}