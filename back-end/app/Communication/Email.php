<?php

namespace App\Communication;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


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

        /**
        * Metódo responsavel pelo envio do email
        *
        * @param string|array $addresses destinatarios+
        * @param string $subject  assunto
        * @param string $body  descrição
        * @param string|array $attachments  anexos
        * @param string|array $ccs copias visíveis
        * @param string|array $bccs copias ocultas
        * @return boolean
        */
        public function sendEmail($addresses, $subject, $body, $name){

            //LIMPA A MENSAGEM DE ERRO
            $this->error = '';

            //Instacia do PHPMailer
            $objMail = new PHPMailer(true);
            try{
                //Credenciais de acsseso ao SMTP
                $objMail->isSMTP();
                $objMail->Host       = EMAIL_HOST;
                $objMail->SMTPAuth   = true;
                $objMail->Username   = EMAIL_USER;
                $objMail->Password   = EMAIL_PASS;
                $objMail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;;
                $objMail->Port       = EMAIL_PORT;
                $objMail->CharSet    = EMAIL_CHARSET;

               
                $objMail->setFrom(EMAIL_USER, EMAIL_FROM_NAME);
                $objMail->addAddress($addresses, $name);     

                $objMail->addReplyTo(EMAIL_USER, 'Resposta');
             
        
        
                //Content
                $objMail->isHTML(true);                                  
                $objMail->Subject = $subject;
                $objMail->Body    = $body;
                $objMail->AltBody = 'Mensagem para confirmação sistema São Roque e Você & Racsstudios';
        
               return $objMail->send();
                
            } catch (Exception $e) {

                $this->error = $e->getMessage();
                return false;
            }
        }
    }