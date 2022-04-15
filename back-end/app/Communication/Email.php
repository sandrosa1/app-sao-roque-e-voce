<?php

namespace App\Communication;

header('Content-Type: text/html; charset=utf-8'); 

    // use PHPMailer\PHPMailer\PHPMailer;
    // use PHPMailer\PHPMailer\Exception as PHPMailerExcepition;

    class Email{
        /**
        * Mensagem de erro
        *
        * @var string
        */
        private $error;
        /**
        * Get the value of error
        */
        public function getError()
        {
            return $this->error;
        }


        public function sendEmail($addresses, $subject, $body, $name = ''){


      
            $headers = 'From: RACS Studios <contato@racsstudios.com>'."\r\n" .
                        'Reply-To: contato@racsstudios.com '. "\r\n" .
                        'X-Mailer: MyFunction/' . phpversion().
                        'MIME-Version: 1.0' . "\r\n".
                        'To: Mary <$name>'."\r\n".
                        'Content-type: text/html; charset=UTF-8' . "\r\n";
                    
    
            try{
            
                $from = "contato@racsstudios.com";
                $to = $addresses;
                $subject = $subject;
                $message = $body;
                $headers = "From:" . $from;
                mail($to,$subject,$message, $headers);
            
                return true;
            
            }catch(\Exception $e){
    
            $this->error = $e->getMessage();
            return false;
    
            }
        }
    
        // /**
        // * Metódo responsavel pelo envio do email
        // *
        // * @param string|array $addresses destinatarios+
        // * @param string $subject  assunto
        // * @param string $body  descrição
        // * @param string|array $attachments  anexos
        // * @param string|array $ccs copias visíveis
        // * @param string|array $bccs copias ocultas
        // * @return boolean
        // */
        // public function sendEmail($addresses, $subject, $body, $attachments = [], $ccs = [], $bccs = []){

        //     //LIMPA A MENSAGEM DE ERRO
        //     $this->error = '';

        //     //Instacia do PHPMailer
        //     $objMail = new PHPMailer(true);
        //     try{
        //         //Credenciais de acsseso ao SMTP
        //         $objMail->isSMTP(true);
        //         $objMail->Host       = EMAIL_HOST;
        //         $objMail->SMTPAuth   = true;
        //         $objMail->Username   = EMAIL_USER;
        //         $objMail->Password   = EMAIL_PASS;
        //         $objMail->SMTPSecure = EMAIL_SECURE;
        //         $objMail->Port       = EMAIL_PORT;
        //         $objMail->CharSet    = EMAIL_CHARSET;

        //         //Remetente
        //         $objMail->setFrom(EMAIL_FORM_EMAIL,  EMAIL_FROM_NAME);

        //         //Destinatarios
        //         $addresses = is_array($addresses) ? $addresses : [$addresses];

        //         foreach($addresses as $address){
        //             $objMail->addAddress($address);
        //         }

        //         //Anexos
        //         $attachments = is_array($attachments) ? $attachments : [$attachments];

        //         foreach($attachments as $attachment){
        //             $objMail->addAttachment($attachment);
        //         }

        //         //ccs
        //         $ccs = is_array($ccs) ? $ccs : [$ccs];

        //         foreach($ccs as $cc){
        //             $objMail->addCC($cc);
        //         }

        //         //bccs
        //         $bccs = is_array($bccs) ? $bccs : [$bccs];

        //         foreach($bccs as $bcc){
        //             $objMail->addBCC($bcc);
        //         }

        //         //Conteudo do email
        //         $objMail->isHTML(true);
        //         $objMail->Subject = $subject;
        //         $objMail->Body    = $body;

        //         //Envia o email
        //         return $objMail->send();
                
        //     }catch(PHPMailerExcepition $e){

        //         $this->error = $e->getMessage();
        //         return false;

        //     }
        //}
    }