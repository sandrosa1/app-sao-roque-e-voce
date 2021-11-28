<?php

namespace App\Http;

class Request {

    /**
     * Instancia do Router
     *
     * @var Router
     */
    private $router;

    /**
     * Método HTTP da requisão
     *
     * @var string
     */
    private $httpMethod;

    /**
     * URI da página
     *
     * @var string
     */
    private $uri;

    /**
     * Parametros da URL
     *
     * @var array
     */
    private $queryParams = [];

    /**
     * Variáveis recebisdas no POST da página ($$_POST)
     *
     * @var array
     */
    private $postVars = [];

    /**
     * Cabeçãlho da requisição
     *
     * @var array
     */
    private $headers = [];

    /**
     * Construtor da classe
     */
    public function __construct($router){
        $this->router      = $router;
        $this->queryParams = $_GET ?? [];
        $this->headers     = getallheaders();
        $this->httpMethod  = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->setUri();
        $this->setPostVars();
    }


    /**
     * Metódo respónsavel por definir as variaveis de post
     *
     * @return void
     */
    private function setPostVars(){

        //Verifica o método da requisição
        if($this->httpMethod == 'GET') return false;

        //POST padrão
        $this->postVars = $_POST ?? [];

        //POST VARS
        $inputRaw = file_get_contents('php://input');

        $this->postVars = strlen($inputRaw and empty($_POST)) ? json_decode($inputRaw,true) : $this->postVars;


    }

    /**
     * Método responsável por definir a URI
     *
     * @return void
     */
    private function setUri(){
        //URI COMPLETA (COM GETS)
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';

        //REMOVE GETS DA URI
        $xURI = explode('?',$this->uri);
        $this->uri = $xURI[0];

    }

    /**
     * Método reponsável por retornar a instancia de Router
     *
     * @return  Router
     */ 
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * Retorna o método HTTP da requisão
     *
     * @return  string
     */ 
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * Retorna URI da página retorna URI
     *
     * @return  string
     */ 
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Retorna cabeçãlho da requisição
     *
     * @return  array
     */ 
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     *Retorna parametros da URL
     *
     * @return  array
     */ 
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     * Retorna as variáveis recebidas no POST da página ($_POST)
     *
     * @return  array
     */ 
    public function getPostVars()
    {
        return $this->postVars;
    }

}