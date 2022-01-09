<?php
namespace App\Model\Entity\Aplication\Servico;

use \SandroAmancio\DatabaseManager\Database;
use \App\Model\Entity\Aplication\App as dbApp;

class Servico extends dbApp{

        public $idServico;
        public $idApp;
        public $estacionamento;
        public $acessibilidade;
        public $entregaDomicilio;
        public $whatsapp;
        public $semana;
        public $sabado;
        public $domigo;
        public $feriado;
        public $logo;
        public $img2;
        public $img3;
        public $descricao;



    /**
     * Metódo responsável por inserir novo serviço
     *
     * @return void
     */    
    public function insertNewServico(){
    
        $this->idServico = (new Database('servico'))->insert([
    
            'idApp'             => $this->idApp,
            'estacionamento'    => $this->estacionamento,
            'acessibilidade'    => $this->acessibilidade,
            'entregaDomicilio'  => $this->entregaDomicilio,
            'whatsapp'          => $this->whatsapp,
            'semana'            => $this->semana,
            'sabado'            => $this->sabado,
            'domigo'            => $this->domigo,
            'feriado'           => $this->feriado,
            'logo'              => $this->logo,
            'img2'              => $this->img2,
            'img3'              => $this->img3,
            'descricao'         => $this->descricao,

        ]);

        return true;
        
    }


    /**
     * Método reponsável por atualizar os dados de serviço
     *
     * @return void
     */
    public function updateServico(){

        //Atualiza os dados gerais do app
        return (new Database('servico'))->update('idApp = '.$this->idApp,[

            'idApp'             => $this->idApp,
            'estacionamento'    => $this->estacionamento,
            'acessibilidade'    => $this->acessibilidade,
            'entregaDomicilio'  => $this->entregaDomicilio,
            'whatsapp'          => $this->whatsapp,
            'semana'            => $this->semana,
            'sabado'            => $this->sabado,
            'domigo'            => $this->domigo,
            'feriado'           => $this->feriado,
            'logo'              => $this->logo,
            'img2'              => $this->img2,
            'img3'              => $this->img3,
            'descricao'         => $this->descricao,
                
             
        ]);
        
        //Sucesso
        return true;

    }

     /**
     * Método reponsável por deletar um serviço
     *
     * @return void
     */
    public function deleteServico(){

        //Deleta os dados App
        return (new Database('servico'))->delete('idApp = '.$this->idApp);
        
        //Sucesso
        return true;

    }


    /**
    * Método responsável por retornar um cliente pelo idUser
    *
    * @param Intenger $idApp
    * @return Servico
    */
    public static function getServicoById($idApp){

        return self::getServico('idApp = '.$idApp)->fetchObject(self::class);
    }

    /**
    * Método responsavel por retornar todos serviços
    *
    * @param string $where
    * @param string $order
    * @param string $limit
    * @param string $fields
    * @return PDOStatement
    */
    public static function getServico($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('servico'))->select($where, $order, $limit, $fields);
    }




}