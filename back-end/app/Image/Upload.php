<?php

namespace App\Image;



class Upload{

    /**
     * Nome do arquivo
     *
     * @var string
     */
    private $name;
    /**
     * Extensão do arquivo
     *
     * @var string
     */
    private $extension;
    /**
     * 
     *
     * @var [type]
     */
    private $type;
    /**
     * Nome temporario/Caminho temporário do arquivo
     *
     * @var string
     */
    private $tmpName;
    /**
     * Código de erro do upload
     *
     * @var integer
     */
    private $error;
    /**
     * Tamanho do arquivo
     *
     * @var integer
     */
    private $size;
    /**
     * Contador
     *
     * @var integer
     */
    private $duplicates = 0;


    /**
     * Construtor da classe
     *
     * @param array $file $_FILE[campo]
     */
    public function __construct($file)
    {
        $this->type = $file['type'];
        $this->tmpName = $file['tmp_name'];
        $this->error = $file['error'];
        $this->size = $file['size'];

        $info = pathinfo($file['name']);
        $this->name = $info['filename'];
        $this->extension = $info['extension'];
    }
    /**
    * Altera o nome do arquivo
    *
    * @param string $name
    */
    public function setName($name)
    {
        $this->name = $name;

    }

    /**
     * Cria o nome para imagem
     *
     * @return void
     */
    public function generateNewName($idApp,$number){

        $this->name = $idApp.'-'.$number;

    }

    /**
     * Retorna o nome do arquivo com sua extensão
     *
     * @return string
     */
    public function getBasename(){

        $extension = strlen($this->extension) ? '.'.$this->extension : '';

        //Valida duplicação
        $duplicates = $this->duplicates > 0 ? '-' .$this->duplicates : '';

        return $this->name.$duplicates.$extension;
    }

    /**
     * Determina um nome possível para o arquivo
     * @param string $dir
     * @param boolean $overwrite
     * @return void
     */
    private function getPossibleBasename($dir, $overwrite){

        //Sobrescreve o arquivo
        if($overwrite) return $this->getBasename();

        //Não sobrescreve o arquivo
        $basename = $this->getBasename();

        if(!file_exists($dir.'/'.$basename)){
            return $basename;
        }

        //Incrementa a duplicação
        $this->duplicates ++;

        return $this->getPossibleBasename($dir, $overwrite);


    }

    /**
     * Movo o arquivo para o diretorio indicado
     *
     * @param string $dir
     * @param boolean $overwrite
     * @return boolean
     */
    public function upload($dir, $overwrite = true){

       if($this->error != 0) return false;

       $path = $dir.'/'.$this->getPossibleBasename($dir, $overwrite);

       return move_uploaded_file($this->tmpName,$path);

    }

    public static function createMultiUpload($files){

        $uploads = [];

        $number = 1;

        foreach($files['name'] as $key => $value){

        
            //Array
            $file = [
                'name'     => $files['name'][$key],
                'type'     => $files['type'][$key],
                'tmp_name' => $files['tmp_name'][$key],
                'error'    => $files['error'][$key],
                'size'     => $files['size'][$key],
            ];

            $number ++;

            $uploads [] = new Upload($file);

        }

        return $uploads;

    }


  
}
