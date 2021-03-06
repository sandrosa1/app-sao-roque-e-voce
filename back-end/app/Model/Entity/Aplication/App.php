<?php

namespace App\Model\Entity\Aplication;

use \SandroAmancio\DatabaseManager\Database;

class App{


    public $idApp;
    public $status;
    public $nomeFantasia;
    public $segmento;
    public $tipo;
    public $email;
    public $telefone;
    public $site;
    public $facebook;
    public $instagram;
    public $youtube;
    public $celular;
    public $cep;
    public $logradouro;
    public $numero;
    public $bairro;
    public $localidade;
    public $chaves;
    public $visualizacao;
    public $totalCusto;
    public $totalAvaliacao;
    public $avaliacao;
    public $custoMedio;
    public $estrelas;
    public $img1;
    public $adicionais;
    public $latitude;
    public $longitude;
   
  public function insertNewApp(){
             
    //Inserio os dados no banco de dados
   (new Database('app'))->insert([
    
        'idApp'           => $this->idApp, 
        'status'          => $this->status, 
        'nomeFantasia'    => $this->nomeFantasia,
        'segmento'        => $this->segmento,
        'tipo'            => $this->tipo,
        'email'           => $this->email,
        'telefone'        => $this->telefone,
        'site'            => $this->site,
        'facebook'        => $this->facebook,
        'instagram'       => $this->instagram,
        'youtube'         => $this->youtube,
        'celular'         => $this->celular,
        'cep'             => $this->cep,
        'logradouro'      => $this->logradouro,
        'numero'          => $this->numero,
        'bairro'          => $this->bairro,
        'localidade'      => $this->localidade,
        'chaves'          => $this->chaves,
        'visualizacao'    => $this->visualizacao,
        'totalCusto'      => $this->totalCusto,
        'totalAvaliacao'  => $this->totalAvaliacao,
        'avaliacao'       => $this->avaliacao,
        'custoMedio'      => $this->custoMedio,
        'estrelas'        => $this->estrelas,
        'img1'            => $this->img1,
        'adicionais'      => $this->adicionais,  
        'latitude'        => $this->latitude,  
        'longitude'       => $this->longitude,  

         ]); 

         return true;

    }
    /**
     * M??todo repons??vel por atualizar o Dados gerais do APP
     *
     * @return void
     */
    public function updateApp(){

        //Atualiza os dados gerais do app
        return (new Database('app'))->update('idApp = '.$this->idApp,[

            'idApp'           => $this->idApp, 
            'status'          => $this->status, 
            'nomeFantasia'    => $this->nomeFantasia,
            'segmento'        => $this->segmento,
            'tipo'            => $this->tipo,
            'email'           => $this->email,
            'telefone'        => $this->telefone,
            'site'            => $this->site, 
            'facebook'        => $this->facebook,
            'instagram'       => $this->instagram,
            'youtube'         => $this->youtube,   
            'celular'         => $this->celular,
            'cep'             => $this->cep,
            'logradouro'      => $this->logradouro,
            'numero'          => $this->numero,
            'bairro'          => $this->bairro,
            'localidade'      => $this->localidade,
            'chaves'          => $this->chaves,
            'visualizacao'    => $this->visualizacao,
            'totalCusto'      => $this->totalCusto,
            'totalAvaliacao'  => $this->totalAvaliacao,
            'avaliacao'       => $this->avaliacao,
            'custoMedio'      => $this->custoMedio,
            'estrelas'        => $this->estrelas,
            'img1'            => $this->img1,  
            'adicionais'      => $this->adicionais, 
            'latitude'        => $this->latitude,  
            'longitude'       => $this->longitude,  
               
             
        ]);
        
        //Sucesso
        return true;

    }
    /**
     * M??todo repons??vel por deletar um cliente
     *
     * @return void
     */
    public static function deleteApp($idApp){

        //Deleta os dados App
        return (new Database('app'))->delete('idApp = '.$idApp);
        
        //Sucesso
        return true;

    }
    /**
     * M??todo respons??vel por retornar um app pelo ID
     *
     * @param Intenger $idApp
     * @return App
     */
    public static function getAppById($idApp){


        return self::getApp('idApp = '.$idApp)->fetchObject(self::class);
    }
    /**
     * M??todo respons??vel por retornar um App pelo n??mero do celular
     *
     * @param Intenger $idApp
     * @return App
     */
    public static function getAppByCelular($celular){


        return (new Database('app'))->select('celular = "'.$celular.'"')->fetchObject(self::class);
    }
    /**
     * M??todo respons??vel por retornar um App pelo n??mero do telefone
     *
     * @param Intenger $idApp
     * @return App
     */
    public static function getAppByTelefone($telefone){


        return (new Database('app'))->select('telefone = "'.$telefone.'"')->fetchObject(self::class);
    }
    /**
     * M??todo respons??vel por retornar um App pelo email
     *
     * @param Intenger $idApp
     * @return App
     */
    public static function getAppByEmail($email){


        return (new Database('app'))->select('email = "'.$email.'"')->fetchObject(self::class);
    }
    /**
     * M??todo responsavel por retornar todos App
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getAppAll($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('app'))->select($where, $order, $limit, $fields)->fetchAll();
    }

      /**
     * M??todo responsavel por retornar todos App
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

