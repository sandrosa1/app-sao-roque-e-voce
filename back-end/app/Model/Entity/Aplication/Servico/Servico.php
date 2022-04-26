<?php
namespace App\Model\Entity\Aplication\Servico;

use \SandroAmancio\DatabaseManager\Database;


class Servico {

        public $idAppServico;
        public $idApp;
        public $estacionamento;
        public $acessibilidade;
        public $entregaDomicilio;
        public $whatsapp;
        public $semana;
        public $sabado;
        public $domingo;
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
    
        $this->idAppServico = (new Database('appServico'))->insert([
    
            'idApp'             => $this->idApp,
            'estacionamento'    => $this->estacionamento,
            'acessibilidade'    => $this->acessibilidade,
            'entregaDomicilio'  => $this->entregaDomicilio,
            'whatsapp'          => $this->whatsapp,
            'semana'            => $this->semana,
            'sabado'            => $this->sabado,
            'domingo'           => $this->domingo,
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
        return (new Database('appServico'))->update('idAppServico = '.$this->idAppServico,[

            'idApp'             => $this->idApp,
            'estacionamento'    => $this->estacionamento,
            'acessibilidade'    => $this->acessibilidade,
            'entregaDomicilio'  => $this->entregaDomicilio,
            'whatsapp'          => $this->whatsapp,
            'semana'            => $this->semana,
            'sabado'            => $this->sabado,
            'domingo'           => $this->domingo,
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
    public static function deleteServico($idApp){

        //Deleta os dados App
        return (new Database('appServico'))->delete('idApp = '.$idApp);
        
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

        return(new Database('appServico'))->select($where, $order, $limit, $fields);
    }
}