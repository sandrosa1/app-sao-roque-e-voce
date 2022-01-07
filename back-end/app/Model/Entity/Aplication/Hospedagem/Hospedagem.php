<?php

namespace App\Model\Entity\Aplication\Hospedagem;

use \SandroAmancio\DatabaseManager\Database;

use \App\Model\Entity\Aplication\App as dbApp;

class Hospedagem extends dbApp{


    public $id_hospedagem;
    public $estacionamento;
    public $briquedos;
    public $restaurante;
    public $ar_condicionado;
    public $wi_fi;
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
    public $domigo;
    public $logo;
    public $img2;
    public $img3;
    public $descricao;
    public $feriado;

  

    public function insertNewHospedagem(){

        $this->id_hospedagem = (new Database('hospedagem'))->insert([

            'id_app'            => $this->id_app,
            'estacionamento'    => $this->estacionamento,
            'briquedos'         => $this->briquedos,
            'restaurante'       => $this->restaurante,
            'ar_condicionado'   => $this->ar_condicionado,
            'wi_fi'             => $this->wi_fi,
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
            'domigo'            => $this->domigo,
            'logo'              => $this->logo,
            'img2'              => $this->img2,
            'img3'              => $this->img3,
            'descricao'         => $this->descricao,
            'feriado'           => $this->feriado,
        ]);

        return true;

    }

     /**
     * Método responsável por retornar um cliente pelo idUser
     *
     * @param Intenger $id_customer
     * @return Hospedagem
     */
    public static function getHospedagemById($id_app){

        return self::getHospedagem('id_app = '.$id_app)->fetchObject(self::class);
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
    public static function getHospedagem($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('hospedagem'))->select($where, $order, $limit, $fields);
    }

}


// 'nomeFantasia'      => $this->nomeFantasia,
// 'visualizacao'      => $this->visualizacao,
// 'segmento'          => $this->segmento,
// 'tipo'              => $this->tipo,
// 'email'             => $this->email,
// 'telefone'          => $this->telefone,
// 'celular'           => $this->celular,
// 'cep'               => $this->cep,
// 'localidade'        => $this->localidade,
// 'numero'            => $this->numero,
// 'bairro'            => $this->bairro,
// 'total_custo'       => $this->total_custo,
// 'total_avaliacao'   => $this->total_avaliacao,