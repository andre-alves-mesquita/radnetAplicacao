<?php


include_once 'entity/cliente.php';
include_once 'functions/upload.php';
include_once 'functions/persistencia.php';
include_once 'functions/enviarEmail.php';

require_once 'src/PHPMailer.php';
require_once 'src/SMTP.php';
require_once 'src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Cria uma instandia do cliente e preenche seus valores em getters e setterss
$Cliente = new cliente();
$Cliente->setNome($_POST['nome']);
$Cliente->setCpf($_POST['cpf']);
$Cliente->setRg($_POST['rg']);
$Cliente->SetDtNasc(new DateTimeImmutable($_POST['dt_nasc']));
$Cliente->setNomeMae($_POST['nome_mae']);
$Cliente->setEmail($_POST['email']);
$Cliente->setTel1($_POST['1_tel']);
$Cliente->setTel2($_POST['2_tel']);
$Cliente->setEndereco($_POST['endereco']);
$Cliente->setPontoDeReferencia($_POST['pt_ref']);
$Cliente->setDataVencimento($_POST['dt_venc']);
$Cliente->setPlanoEscolhido($_POST['pl_esc']);
$Cliente->setInfoAdd($_POST['info_add']);
$Cliente->setDtNascString($_POST['dt_nasc']);
$Cliente->setNomeFunc($_POST['nome_func']);

//Funções para fazer o upload das imagens
$upload = new upload($_POST, $_FILES);
$upload->fazerUpload();
$upload->fazerUpload2();

//Grava as informações da instancia no banco de dados
$persistencia = new persistencia('area-administrativa/radnet-admin/app/database/radnet.sqlite', 'sqlite:');
$status = $persistencia->insertBanco(

    $Cliente->getNome(),
    $Cliente->getCpf(),
    $Cliente->getRg(),
    $Cliente->getDtNasc(),
    $Cliente->getNomeMae(),
    $Cliente->getEmail(),
    $Cliente->getTel1(),
    $Cliente->getTel2(),
    $Cliente->getEndereco(),
    $Cliente->getPontoDeReferencia(),
    $Cliente->getDataVencimento(),
    $Cliente->getPlanoEscolhido(),
    $Cliente->getInfoAdd(),
    $Cliente->getNomeFunc()

);


//Funções para envio de email com as informações da instancia
$enviarEmail = new enviarEmail();

//Função que preenche o corpo do email a ser enviado
$arquivo = $enviarEmail->preencherCorpoDoEmail(
    $Cliente->getNome(),
    $Cliente->getCpf(),
    $Cliente->getRg(),
    $Cliente->getNomeMae(),
    $Cliente->getEmail(),
    $Cliente->getTel1(),
    $Cliente->getTel2(),
    $Cliente->getEndereco(),
    $Cliente->getPontoDeReferencia(),
    $Cliente->getDataVencimento(),
    $Cliente->getPlanoEscolhido(),
    $Cliente->getInfoAdd(),
    $Cliente->getDtNascString(),
    $Cliente->getNomeFunc()
);

//Prenchimento das informações necessarias para o envio do email
$mail = new PHPMailer(true);

try {

    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'andre20mesquita@gmail.com'; //Email em que irá aparecer como remetente
    $mail->Password = 'Andre@20092007'; // senha do email para autenticação
    $mail->Port = 587;

    $mail->setFrom('andre20mesquita@gmail.com');
    $mail->addAddress('andre20naruto@gmail.com'); // Email destinatário

    $mail->isHTML(true);
    $mail->Subject = 'Teste de email via gmail'; // assunto
    $mail->Body = $arquivo;
    $mail->AltBody = $arquivo;

    if ($mail->send()) {
        echo "email enviado com sucesso";
    } else {
        echo "falha no email";
    }
} catch (Exception $e) {

    echo "Erro ao enviar mensagem: {$mail->ErrorInfo}";
}


//Iniciando a sessão:
//Função criada para enviar um status para a pagina inicial sobre o envio e persistencia das informações
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$_SESSION['status'] = $status;

//redirecionamento da pagina, teve que ser em java script para que a o envio do email nao falhasse
echo "<script>
alert('Dados enviados!');
window.location.href = 'index.php';
</script>";
