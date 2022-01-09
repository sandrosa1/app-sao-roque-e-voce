<?php
namespace App\Model\Entity\Aplication\Evento;

use \SandroAmancio\DatabaseManager\Database;
use \App\Model\Entity\Aplication\App as dbApp;

class Evento extends dbApp{

        public $idEvento;
        public $idApp;
        public $estacionamento;
        public $acessibilidade;
        public $wiFi;
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
        public $feriado;
        public $img2;
        public $img3;
        public $descricao;
 


    /**
     * Metódo responsável por inserir dados de um evento
     *
     * @return void
     */    
    public function insertNewEvento(){
    
        $this->idEvento = (new Database('evento'))->insert([
            'idApp'             => $this->idApp,
            'estacionamento'    => $this->estacionamento,
            'acessibilidade'    => $this->acessibilidade,
            'wiFi'              => $this->wiFi,
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
            'feriado'           => $this->feriado,
            'img2'              => $this->img2,
            'img3'              => $this->img3,
            'descricao'         => $this->descricao,
        ]);

        return true;
    }
   /**
     * Método reponsável por atualizar os dados de um evento
     *
     * @return void
     */
    public function updateEvento(){

  
        return (new Database('evento'))->update('idApp = '.$this->idApp,[

            'idApp'            => $this->idApp,
            'estacionamento'    => $this->estacionamento,
            'acessibilidade'    => $this->acessibilidade,
            'wiFi'              => $this->wiFi,
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
            'feriado'           => $this->feriado,
            'img2'              => $this->img2,
            'img3'              => $this->img3,
            'descricao'         => $this->descricao,
        ]);
        
        return true;

    }

     /**
     * Método reponsável por deletar um evento
     *
     * @return void
     */
    public function deleteHospedagem(){

        return (new Database('evento'))->delete('idApp = '.$this->idApp);
        
        return true;

    }

    /**
    * Método responsável por retornar um envento
    *
    * @param Intenger $idApp
    * @return Evento
    */
    public static function getEventoById($idApp){

        return self::getEvento('idApp = '.$idApp)->fetchObject(self::class);
    }

    /**
    * Método responsavel por retornar todos os eventos
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