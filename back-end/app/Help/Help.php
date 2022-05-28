<?php

namespace App\Help;

use \App\Controller\Srv\PageSrv;
use \App\Model\Entity\Aplication\App as EntityApp;
use \App\Validate\Validate;
use \App\Image\Upload;
use \App\Image\Resize;



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

    public static function helpApp(){

        $session = new PageSrv();
        $idApp =  $session->idSession;
        return EntityApp::getAppById($idApp);

    }

    /**
     * Undocumented function
     *
     * @param string $opcao
     * @return void
     */
    public static function helpOptions($opcao){

        switch ($opcao) {
            case 'entregaDomicilio';
                return ["Dellivery","class='c-pri ml-4 fas fa-truck'"];

            case 'estacionamento':
                return ["Vaga","class='c-pri ml-4 fas fa-car'"];

            case 'acessibilidade':
                return ["Acessibilidade","class='c-pri ml-4 fab fa-accessible-icon'"];

            case "whatsapp":
                return ["whatsapp","class='c-pri ml-4 fab fa-whatsapp'"];

            case "wiFi":
                return ["WiFi","class='c-pri ml-4 fas fa-wifi'"];

            case "trilhas":
                return ["Trilha","class='c-pri ml-4 fas fa-hiking'"];

            case "refeicao":
                return ["Refeição","class='c-pri ml-4 fas fa-utensils'"];

            case "emporio":
                return ["Empório","class='c-pri ml-4 fas fa-store'"];

            case "adega":
                return ["Adega","class='c-pri ml-4 fas fa-wine-bottle'"];

            case "bebidas":
                return ["Bebidas","class='c-pri ml-4 fas fa-glass-cheers'"];

            case "sorveteria":
                return ["Sorveteria","class='c-pri ml-4 fas fa-ice-cream'"];

            case "show":
                return ["Shows","class='c-pri ml-4 far fa-stars'"];

            case "brinquedos":
                return ["Brinquedos","class='c-pri ml-4 fas fa-gamepad'"];

            case "restaurante":
                return ["Restaurante","class='c-pri ml-4 fas fa-utensils'"];

            case "arCondicionado":
                return ["ArCondi","class='c-pri ml-4 fal fa-air-conditioner'"];

            case "academia":
                return ["Academia","class='c-pri ml-4 fas fa-running'"];

            case "piscina":
                return ["Piscina","class='c-pri ml-4 fas fa-swimmer'"];

            case "refeicao":
                return ["Refeição","class='c-pri ml-4 fas fa-cookie-bite'"];

            case "musica":
                return ["Música","class='c-pri ml-4 fas fa-music'"];

            case "fe":
                return ["Fé","class='c-pri ml-4  fa-solid fa-hands-praying'"];

            case "natureza":
                return ["Natureza","class='c-pri ml-4  fa-solid fa-tree'"];

            case "cachoeira":
                return ["Cachoeira","class='c-pri ml-4  fa-solid fa-water'"];
        
            default:
                # code...
                break;
        }
    }


    /**
     * Undocumented function
     *
     * @param [type] $app
     * @return void
     */
    public static function helpGetTypeHeader($app){

        switch ($app->segmento) {
            case 'evento':
                return ["Eventos","fas fa-calendar-alt"];

            case 'servicos':
                return ["Serviços","fas fa-tools"];

            case 'comercio':
                return ["Comércios","fas fa-store"];

            case 'hospedagem':
                return ["Hospedagens","fas fa-hotel"];

            case 'turismo':
                return ["Turísmo","fas fa-camera-retro"];

            case 'gastronomia':
            return ["Gastronomia","fas fa-wine-glass-alt"];
            
        }
    }



    /**
     * Modo responsável peo controlar o upload de imagens
     *
     * @param [
     * @return void
     */
    public static function hellUploadImage($validate, $app, $appSegmento,$update){


       
        if(isset($_FILES['arquivoImagem']) || isset($_FILES['arquivoLogo']) ){

            if(isset($_FILES['arquivoImagem'])){
                $uploads = Upload::createMultiUpload($_FILES['arquivoImagem']);
                $tamanho = 750;
                $logotipo = false;
            }else{
                $uploads = Upload::createMultiUpload($_FILES['arquivoLogo']);
                $tamanho = 150;
                $logotipo = true;
            }

            
       
            $pathImages = [];
            $number = 1;

           if($uploads){

                foreach ($uploads as $objUpload) {
                    // Move os arquivos de upload
                    $objUpload->generateNewName($app->idApp, $number++);

                    $sucesso = $objUpload->upload('/var/www/html/app-sao-roque-e-voce/back-end/img/imgApp');

                    array_push($pathImages, $objUpload->getBasename());
                    //Instacia de redimencionamento
                    $objResize = new Resize('/var/www/html/app-sao-roque-e-voce/back-end/img/imgApp/'.$objUpload->getBasename());

                    $objResize->resize($tamanho);

                    $objResize->save('/var/www/html/app-sao-roque-e-voce/back-end/img/imgApp/'.$objUpload->getBasename(),70);


                    if($sucesso){
                        continue;
                        
                    }else{

                        $validate->setErro('Erro ao enviar o arquivo <br>');
                    }

                }
                
            }else{
                $validate->setErro('Formato da imagem inválido!');
            }
            if(count($validate->getErro()) > 0){
               return false;
                
            }

            if($update){

                if($logotipo){

                    unlink('/var/www/html/app-sao-roque-e-voce/back-end/img/imgApp/'.$app->img1);
                }else{
    
                    unlink('/var/www/html/app-sao-roque-e-voce/back-end/img/imgApp/'.$app->img1);
                    unlink('/var/www/html/app-sao-roque-e-voce/back-end/img/imgApp/'.$appSegmento->img2);
                    unlink('/var/www/html/app-sao-roque-e-voce/back-end/img/imgApp/'.$appSegmento->img3);
    
                }
            }
           

            Help::HelpInsertPathImageDataBase($app,$pathImages);
    
            return true;

        }
    }


    /**
     * Método responsável por controlar a inserção dos caminhos das imagens no banco de dados
     *
     * @param Entity $app
     * @param string $pathImages
     * @return void
     */
    private static function helpInsertPathImageDataBase($app, $pathImages){

        $appSegmento = HelpEntity::helpGetEntity($app); 
        

        switch ($app->segmento) {
            case 'gastronomia':
                return HelpEntity::helpImgGastronomia($app, $appSegmento,$pathImages);

            case 'evento':
                return HelpEntity::helpImgEvento($app, $appSegmento,$pathImages);

            case 'servicos':
                return HelpEntity::helpImgServico($app, $appSegmento,$pathImages);

            case 'comercio':
                return HelpEntity::helpImgComercio($app, $appSegmento,$pathImages);

            case 'hospedagem':
                return HelpEntity::helpImgHospedagem($app, $appSegmento,$pathImages);

            case 'turismo':
                return HelpEntity::helpImgTurismo($app, $appSegmento,$pathImages);
           
        }

    }


}