<?php

namespace App\Model\Entity\Aplication\Help;

use \SandroAmancio\DatabaseManager\Database;

use \App\Model\Entity\Aplication\App as dbApp;

class Help extends dbApp{


    /**
     * id
     *
     * @var integer
     */
    public $idAppHelp;
    /**
     * Palavras improprias
     *
     * @var string
     */
    public $blockedWord;
  

    public function insertNewHelp(){

        $this->idAppHelp = (new Database('appHelp'))->insert([

            'blockedWord'         => $this->blockedWord,
            
        ]);

        return true;

    }

    /**
     * Método reponsável por atualizar os dados de uma appHelp
     *
     * @return void
     */
    public function updateHelp(){

        //Atualiza os dados gerais da appHelp
        return (new Database('appHelp'))->update('idAppHelp = '.$this->idAppHelp,[

     
            'blockedWord'         => $this->blockedWord,
            
        ]);
        
        //Sucesso
        return true;

    }

     /**
     * Método reponsável por deletar uma appHelp
     *
     * @return void
     */
    public static function deleteHelp($idAppHelp){

        return (new Database('appHelp'))->delete('idAppHelp = '.$idAppHelp);
        
        //Sucesso
        return true;

    }

    public static function getHelpBlockedWord($blockedWord){

        return (new Database('appHelp'))->select('blockedWord = "'.$blockedWord.'"')->fetchObject(self::class);
    }

     /**
     * Método responsável por retornar uma appHelp pelo idAppHelp
     *
     * @param Intenger $id_customer
     * @return Help
     */
    public static function getHelpById($idAppHelp){

        return self::getHelp('idAppHelp = '.$idAppHelp)->fetchObject(self::class);
    }

     /**
     * Método responsavel por retornar todas as appHelp
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getHelp($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('appHelp'))->select($where, $order, $limit, $fields);
        
    }



}



