<?php

namespace App\Image;

class Resize{

    /**
     * Image GD
     *
     * @var resouse
     */
    public $image;

    /**
     * Tipo da image
     *
     * @var string
     */
    private $type;


    public function __construct($file)
    {
        //IMAGEM
        $this->image = imagecreatefromstring(file_get_contents($file));

        //INFO
        $info = pathinfo($file);
        $this->type = $info['extension'] == 'jpg' ? 'jpeg' : $info['extension'];

    }

    /**
     * Método respónsavel por redefinir o tamanho da imagem
     *
     * @param integer $newWidth
     * @param integer $newHeight
     * @return void
     */
    public function resize($newWidth, $newHeight = -1){
        
        $this->image = imagescale($this->image, $newWidth, $newHeight);
    }


    /**
     * Método respónsavel por retornar a imagem na tela
     *
     * @param integer $quality
     * @return void
     */
    public function print($quality = 100){
        header('Content-Type: image/'.$this->type);
        $this->output(null,$quality);
        exit;
    }


    /**
     * Método respónsavel por salvar a imagem no disco
     *
     * @param string $localFile
     * @param integer $quality
     * @return void
     */
    public function save($localFile, $quality = 100){
        $this->output($localFile,$quality);
    }

    /**
     * Método responsável pela saida da imagem
     *
     * @param string $localFile
     * @param integer $quality
     * @return void
     */
    private function output($localFile,$quality = 100){

        switch ($this->type) {

            case 'jpeg':
                imagejpeg($this->image,$localFile,$quality);
                break;        
            default:
                # code...
                break;
        }
    }
}