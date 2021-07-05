<?php

/*

Modelo de Email - Não está sendo utilizado na aplicação

require_once '../src/PHPMailer.php';
require_once '../src/SMTP.php';
require_once '../src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {

    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'andre20mesquita@gmail.com';
    $mail->Password = 'Andre@20092007';
    $mail->Port = 587;

    $mail->setFrom('andre20mesquita@gmail.com');
    $mail->addAddress('andre20naruto@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = 'Teste de email via gmail';
    $mail->Body = 'Chegou o email testes';
    $mail->AltBody = 'tbm chegou';

    if ($mail->send()) {
        echo "email enviado com sucesso";
    } else {
        echo "falha no email";
    }
} catch (Exception $e) {

    echo "Erro ao enviar mensagem: {$mail->ErrorInfo}";
}

*/