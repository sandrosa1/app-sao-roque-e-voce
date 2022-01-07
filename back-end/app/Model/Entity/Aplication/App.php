<?php

namespace App\Model\Entity\Aplication;

use \SandroAmancio\DatabaseManager\Database;

class App{


    public $idApp;
    public $nomeFantasia;
    public $segmento;
    public $tipo;
    public $email;
    public $telefone;
    public $celular;
    public $cep;
    public $logradouro;
    public $numero;
    public $bairro;
    public $localidade;
    public $complementos;
    public $chaves;
    public $visualizacao;
    public $total_custo;
    public $total_avaliacao;
    public $custo;
    public $avaliacao;
    public $img1;
   


  public function insertNewApp(){
        
       
    //Inserio os dados no banco de dados
   (new Database('app'))->insert([
    
        'idApp'          => $this->idApp, 
        'nomeFantasia'    => $this->nomeFantasia,
        'segmento'        => $this->segmento,
        'tipo'            => $this->tipo,
        'email'           => $this->email,
        'telefone'        => $this->telefone,
        'celular'         => $this->celular,
        'cep'             => $this->cep,
        'logradouro'      => $this->logradouro,
        'numero'          => $this->numero,
        'bairro'          => $this->bairro,
        'localidade'      => $this->localidade,
        'complementos'    => $this->complementos,
        'chaves'          => $this->chaves,
        'visualizacao'    => $this->visualizacao,
        'total_custo'     => $this->total_custo,
        'total_avaliacao' => $this->total_avaliacao,
        'custo'           => $this->custo,
        'avaliacao'       => $this->avaliacao,
        'img1'            => $this->img1,

         ]); 

         return true;

    }


    /**
     * Método reponsável por atualizar o Dados gerais do APP
     *
     * @return void
     */
    public function updateApp(){

        //Atualiza os dados gerais do app
        return (new Database('app'))->update('idApp = '.$this->idApp,[

            'idApp'          => $this->idApp, 
            'nomeFantasia'    => $this->nomeFantasia,
            'segmento'        => $this->segmento,
            'tipo'            => $this->tipo,
            'email'           => $this->email,
            'telefone'        => $this->telefone,
            'celular'         => $this->celular,
            'cep'             => $this->cep,
            'logradouro'      => $this->logradouro,
            'numero'          => $this->numero,
            'bairro'          => $this->bairro,
            'localidade'      => $this->localidade,
            'complementos'    => $this->complementos,
            'chaves'          => $this->chaves,
            'visualizacao'    => $this->visualizacao,
            'total_custo'     => $this->total_custo,
            'total_avaliacao' => $this->total_avaliacao,
            'custo'           => $this->custo,
            'avaliacao'       => $this->avaliacao,
            'img1'            => $this->img1,  
               
             
        ]);
        
        //Sucesso
        return true;

    }

     /**
     * Método reponsável por deletar um cliente
     *
     * @return void
     */
    public function deleteApp(){

        //Deleta os dados App
        return (new Database('app'))->delete('idApp = '.$this->idApp);
        
        //Sucesso
        return true;

    }

     /**
     * Método responsável por retornar um cliente pelo idUser
     *
     * @param Intenger $idApp
     * @return App
     */
    public static function getAppById($idApp){


        return self::getApp('idApp = '.$idApp)->fetchObject(self::class);
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
    public static function getApp($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('app'))->select($where, $order, $limit, $fields);
    }

   
}

