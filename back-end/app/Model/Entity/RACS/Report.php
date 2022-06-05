<?php

namespace App\Model\Entity\RACS;

use \SandroAmancio\DatabaseManager\Database;






//RESPONSÁVEL POR UMA INSTÂNCIA DE 
class Report{

    /**
     * 1)
     * ID do colaborador
     *
     * @var integer
     */
    public $idReport;
    /**
     * 2)
     * Nome de usuário
     *
     * @var string
     */
    public $idUser;
     /**
     * 2)
     * Nome de usuário
     *
     * @var string
     */
    public $nome;
     /**
     * 2)
     * Nome de usuário
     *
     * @var string
     */
    public $email;
    /**
     * 3)
     * Apelido
     *
     * @var string
     */
    public $typeReport;
    /**
     * 4)
     * Email do usuário
     *
     * @var string
     */
    public $message;
    /**
     * 5)
     * Senha do usuário
     *
     * @var string
     */
    public $status;
    /**
      * 6)
     * Data de criação
     *
     * @var date
     */
    public $reportDate;
    
   
 
    /**
     * Metódo responsável por inserir um novo report
     *
     * @return void
     */
    public function insertNewReport(){
        
        $this->reportDate = date("Y-m-d H:i:s");

        //Inserio os dados do usuario no banco de dados
        $this->idReport = (new Database('report'))->insert([
            
            'idUser'         => $this->idUser,  
            'typeReport'     => $this->typeReport,  
            'message'        => $this->message,
            'status'         => $this->status,
            'reportDate'     => $this->reportDate, 
            'email'          => $this->email,  
            'nome'           => $this->nome,  
               
        ]);

      
        //Sucesso
        return true;

    }
    /**
     * Método reponsável por atualizar o report
     *
     * @return void
     */
    public function updateReport(){

        //Inserio os dados do cliete no banco de dados
        return (new Database('report'))->update('idReport = '.$this->idReport,[

            'idUser'         => $this->idUser, 
            'typeReport'     => $this->typeReport, 
            'message'        => $this->message,
            'status'         => $this->status,
            'email'          => $this->email,  
            'nome'           => $this->nome,   
     
        ]);
        
        //Sucesso
        return true;

    }

       /**
     * Método reponsável por atualizar o status do report
     *
     * @return void
     */
    public function updateStatus(){

        //Inserio os dados do cliete no banco de dados
        return (new Database('report'))->update('idReport = '.$this->idReport,[

            'status'     => $this->status,
        ]);
        
        //Sucesso
        return true;

    }
    /**
     * Método reponsável por deletar um report
     *
     * @return void
     */
    public function deleteReport(){

        //Inserio os dados do cliete no banco de dados
        return (new Database('report'))->delete('idReport = '.$this->idReport);
        
        //Sucesso
        return true;

    }
   /**
     * Método responsável por retornar um usuário pelo idReport
     *
     * @param Intenger $idReport
     * @return Report
     */
    public static function getReportById($idReport){

        return self::getReport('idReport = '.$idReport)->fetchObject(self::class);
    }
   
  
     /**
     * Método responsavel por uma consulta customizada
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getReport($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('report'))->select($where, $order, $limit, $fields);
    }
    
     /**
     * Método responsavel por retornar todos os report  
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getReportAll($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('report'))->select($where, $order, $limit, $fields)->fetchAll();
    }
  
   
}