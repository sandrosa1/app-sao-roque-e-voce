<?php

namespace App\Help;


class Help{


    

    /**
     * Método responsável em converter um texto em um array de palavras
     *
     * @param string $text
     * @return array
     */
    public static function helpTextForArray($text){

    
        $chars = [];
        $chars = ['"','!','@','#','$','%','¨','&','*','(',')','-','_','+','-','§','`','[',']','{','}','~','^',':',';','.',',','<','>','|','/','?',"'","\\"];
  
        return array_filter(explode(" ",str_replace($chars,"",mb_strtoupper($text))));
    
    }

    /**
     * Metódo responsável por retornar uma string separada por virgúlo
     *
     * @param array $array
     * @return string
     */
    public static function helpArrayForString($array){

        return mb_strtoupper(implode(", ", $array));

    }
            
    

}