<?php

require __DIR__.'/includes/app.php';

use \App\Http\Router;

// Inicia o Router
$objRouter = new Router(URL);

// Inclui rotas das páginas
include __DIR__ . '/routes/pages.php';

// Inclui rotas do painel clientes APP
include __DIR__ . '/routes/srv.php';

// Inclui rotas do painel dos colaboradores racs
include __DIR__ . '/routes/racs.php';

// Imprime o response da rota
$objRouter->run()->sendResponse();



// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception as PHPMailerExcepition;

// $mail = new PHPMailer;
// $mail->isSMTP();
// $mail->SMTPDebug = 2;
// $mail->Host = 'smtp.hostinger.com';
// $mail->Port = 456;
// $mail->SMTPAuth = true;
// $mail->Username = 'contato@racsstudios.com';
// $mail->Password = 'ACRSracs@2022';
// $mail->setFrom('contato@racsstudios', 'Sandro');
// $mail->addReplyTo('contato@racsstudios.com', 'Sandro');
// $mail->addAddress('sandrosa0315@gmail.com', 'Sandro');
// $mail->Subject = 'Testing PHPMailer';
// $mail->msgHTML(file_get_contents('message.html'), __DIR__);
// $mail->Body = 'This is a plain text message body';
// //$mail->addAttachment('test.txt');
// if (!$mail->send()) {
//     echo 'Mailer Error: ' . $mail->ErrorInfo;
// } else {
//     echo 'The email message was sent.';
// }