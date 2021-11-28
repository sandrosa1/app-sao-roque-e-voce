<?php

namespace App\Http;

class Response {

    /**
     * Código do Status HTTP
     *
     * @var integer
     */
    private $httpCode = 200;

     /**
     * Cabeçalho da Response
     *
     * @var array
     */
    private $headers = [];

    /**
     * Tipo de conteudo da requisição
     *
     * @var string
     */
    private $contentType = 'text/html';

    
    /**
     * Conteúdo do response
     *
     * @var mixed
     */
    private $content;

    /**
     * Método responsável por definar a classe e retornar os valores
     *
     * @param integer $httpCode
     * @param mixed $content
     * @param string $contentType
     */
    public function __construct($httpCode, $content, $contentType = 'text/html')
    {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }

    
    /**
     * Método responsável por  iniciar a classe e definir os valores
     *
     * @param string $contentType
     * @return void
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type',$contentType);

    }
    /**
     * Método responsável por adicionar um registro no cabeçãlho de response
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public function addHeader($key, $value){
        $this->headers[$key] = $value;
    }

    /**
     * Método rtesponsável por enviar os headers para o navegador
     *
     * @return void
     */
    private function sendHeaders(){

        http_response_code($this->httpCode);

        foreach($this->headers as $key=>$value){
            header($key.': '.$value);
        }
    }
    /**
     * Método responsável por enviar a resposta para o usuário
     *
     * @return void
     */
    public function sendResponse(){

        $this->sendHeaders();

        switch($this->contentType){
            case 'text/html';
            echo $this->content;
            exit;
            case 'application/json';
            // Converte para JSON e não deixa escapar caracteres unicoder nem as barras
            echo json_encode($this->content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            exit;
        }
    }
}