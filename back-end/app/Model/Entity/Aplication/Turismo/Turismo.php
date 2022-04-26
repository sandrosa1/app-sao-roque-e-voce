<?php
namespace App\Model\Entity\Aplication\Turismo;

use \SandroAmancio\DatabaseManager\Database;

class Turismo {

        public $idAppTurismo;
        public $idApp;
        public $estacionamento;
        public $acessibilidade;
        public $fe;
        public $trilhas;
        public $refeicao;
        public $natureza;
        public $cachoeira;
        public $parque;
        public $semana;
        public $sabado;
        public $domingo;
        public $feriado;
        public $img2;
        public $img3;
        public $descricao;
 


    /**
     * Metódo responsável por inserir dados de um appTurismo
     *
     * @return void
     */    
    public function insertNewTurismo(){
    
        return $this->idAppTurismo = (new Database('appTurismo'))->insert([
            'idApp'             => $this->idApp,
            'estacionamento'    => $this->estacionamento,
            'acessibilidade'    => $this->acessibilidade,
            'fe'                => $this->fe,
            'trilhas'           => $this->trilhas,
            'refeicao'          => $this->refeicao,
            'natureza'          => $this->natureza,
            'cachoeira'         => $this->cachoeira,
            'parque'            => $this->parque,
            'semana'            => $this->semana,
            'sabado'            => $this->sabado,
            'domingo'           => $this->domingo,
            'feriado'           => $this->feriado,
            'img2'              => $this->img2,
            'img3'              => $this->img3,
            'descricao'         => $this->descricao,
        ]);

        
    }
   /**
     * Método reponsável por atualizar os dados de um appTurismo
     *
     * @return void
     */
    public function updateTurismo(){

  
        return (new Database('appTurismo'))->update('idApp = '.$this->idApp,[

            'estacionamento'    => $this->estacionamento,
            'acessibilidade'    => $this->acessibilidade,
            'fe'                => $this->fe,
            'trilhas'           => $this->trilhas,
            'refeicao'          => $this->refeicao,
            'natureza'          => $this->natureza,
            'cachoeira'         => $this->cachoeira,
            'parque'            => $this->parque,
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
     * Método reponsável por deletar um appTurismo
     *
     * @return void
     */
    public static function deleteTurismo($idApp){

        return (new Database('appTurismo'))->delete('idApp = '.$idApp);
        
        return true;

    }

    /**
    * Método responsável por retornar um envento
    *
    * @param Intenger $idApp
    * @return Turismo
    */
    public static function getTurismoById($idApp){

        return self::getTurismo('idApp = '.$idApp)->fetchObject(self::class);
    }

    /**
    * Método responsavel por retornar todos os appTurismos
    *
    * @param string $where
    * @param string $order
    * @param string $limit
    * @param string $fields
    * @return PDOStatement
    */
    public static function getTurismo($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('appTurismo'))->select($where, $order, $limit, $fields);
    }


      /**
     * Método responsavel por retornar todos clientes
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getTurismoAll($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('appTurismo'))->select($where, $order, $limit, $fields)->fetchAll();
    }

}