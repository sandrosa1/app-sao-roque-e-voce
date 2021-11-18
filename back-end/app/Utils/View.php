<?php

namespace App\Utils;

class View{

    /**
     * Variáveis padrões da view
     *
     * @var array
     */
    private static $vars = [];

    /**
     * Método responsável por definir os dados do inicio da classe
     *
     * @param array $vars
     * @return void
     */
    public static function init($vars = []){
        self::$vars = $vars;

    }
    /**
     * Método responsável por retornar o contéudo de um view
     *
     * @param string $view
     * @return string
     */
    private static function getContentView($view){
        $file = __DIR__ . '/../../resources/view/'.$view.'.html';
        // se existir retorna o conteúdo, se não retona vazio
        return file_exists($file) ? file_get_contents($file) : '';

    }
    /**
     * Método responsável por retornar o conteúdo renderizado de um view
     *
     * @param string $view
     * @param array $vars (Strings/numeric)
     * @return string
     */
    public static function render($view, $vars = []){
        //  cCONTEÚDO DA VIEW
        
        $contentView = self::getContentView($view);
 
        //MERGE DE VARIÁVEIS DA VIEW
        $vars = array_merge(self::$vars,$vars);

        //CHAVES DOS ARRAY DE VARIAVEIS (Cria um array somente com as chaves)
        $keys = array_keys($vars);
    

        //MAPEANDO OS DADOS
        $keys = array_map(function($item){
            return  '{{'.$item.'}}';
        },$keys);
     
        //RETORNA O CONTEÚDO RENDERIZADO
        return str_replace($keys,array_values($vars),$contentView);
    }
}