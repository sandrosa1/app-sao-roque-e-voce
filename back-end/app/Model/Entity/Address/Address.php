<?php

namespace App\Model\Entity\Address;

use \SandroAmancio\DatabaseManager\Database;

class Address{


    public $idAddress;
    public $cep;
    public $logradouro;
    public $numero;
    public $bairro;
    public $localidade;
    public $latitude;
    public $longitude;


    public function insertAddress(){

        return $this->idAddress = (new Database('address'))->insert([

            'cep'         => $this->cep,
            'logradouro'  => $this->logradouro,
            'bairro'      => $this->bairro,
            'localidade'  => $this->localidade,
            'latitude'    => $this->latitude,
            'longitude'   => $this->longitude,
        ]);

    }

    public function updateAddress(){

       return (new Database('address'))->update('idAddress ='.$this->idAddress,[

            'cep'         => $this->cep,
            'logradouro'  => $this->logradouro,
            'bairro'      => $this->bairro,
            'localidade'  => $this->localidade,
            'latitude'    => $this->latitude,
            'longitude'   => $this->longitude,

        ]);

       
   }


   public function deleteAddress(){

        return (new Database('address'))->delete('idAddress ='>$this->idAddress);

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
    public static function getAddressAll($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('address'))->select($where, $order, $limit, $fields)->fetchAll();

    }


}