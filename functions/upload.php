<?php

class upload
{

    private $post;
    private $files;

    function __construct(array $array_post, array $array_files)
    {
        $this->post = $array_post;
        $this->files = $array_files;
    }

// função que faz o upload dos arquivos no servidor na pasta upload na raiz da aplicação
    public function fazerUpload()
    {

        // Lista de tipos de arquivos permitidos
        $tiposPermitidos = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png');
        // Tamanho máximo (em bytes)
        $tamanhoPermitido = 1024 * 5000; // 500 Kb

        $nome_cliente = $this->post['nome'];

        // O nome original do arquivo no computador do usuário
        $arqName = $this->files['foto_casa']['name'];
        // O tipo mime do arquivo. Um exemplo pode ser "image/gif"
        $arqType = $this->files['foto_casa']['type'];
        // O tamanho, em bytes, do arquivo
        $arqSize = $this->files['foto_casa']['size'];
        // O nome temporário do arquivo, como foi guardado no servidor
        $arqTemp = $this->files['foto_casa']['tmp_name'];
        // O código de erro associado a este upload de arquivo


        $arqError = $this->files['foto_casa']['error'];

        if ($arqError == 0) {
            // Verifica o tipo de arquivo enviado
            if (array_search($arqType, $tiposPermitidos) === false) {
                echo 'O tipo de arquivo enviado é inválido!';
                // Verifica o tamanho do arquivo enviado
            } else if ($arqSize > $tamanhoPermitido) {
                echo 'O tamanho do arquivo enviado é maior que o limite!';
                // Não houveram erros, move o arquivo
            } else {


                $pasta = 'uploads/';

                // Pega a extensão do arquivo enviado
                $extensao_array = explode('.', $arqName);
                $extensao_unica = end($extensao_array);
                $extensao = strtolower($extensao_unica);

                // Define o novo nome do arquivo usando um UNIX TIMESTAMP
                $nome = time() . '.' . $extensao;

                // Define o novo nome do arquivo usando um UNIX TIMESTAMP
                $nome = $nome_cliente . '-foto-casa-' . date('d-m-Y') . date('H-m-s')  . '.' . $extensao;


                move_uploaded_file($arqTemp, $pasta . $nome);
            }
        }
    }

    public function fazerUpload2()
    {

        // Lista de tipos de arquivos permitidos
        $tiposPermitidos = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png');
        // Tamanho máximo (em bytes)
        $tamanhoPermitido = 1024 * 5000; // 500 Kb

        $nome_cliente = $this->post['nome'];

        // O nome original do arquivo no computador do usuário
        $arqName = $this->files['foto_rua']['name'];
        // O tipo mime do arquivo. Um exemplo pode ser "image/gif"
        $arqType = $this->files['foto_rua']['type'];
        // O tamanho, em bytes, do arquivo
        $arqSize = $this->files['foto_rua']['size'];
        // O nome temporário do arquivo, como foi guardado no servidor
        $arqTemp = $this->files['foto_rua']['tmp_name'];
        // O código de erro associado a este upload de arquivo


        $arqError = $this->files['foto_rua']['error'];

        if ($arqError == 0) {
            // Verifica o tipo de arquivo enviado
            if (array_search($arqType, $tiposPermitidos) === false) {
                echo 'O tipo de arquivo enviado é inválido!';
                // Verifica o tamanho do arquivo enviado
            } else if ($arqSize > $tamanhoPermitido) {
                echo 'O tamanho do arquivo enviado é maior que o limite!';
                // Não houveram erros, move o arquivo
            } else {


                $pasta = 'uploads/';

                // Pega a extensão do arquivo enviado
                $extensao_array = explode('.', $arqName);
                $extensao_unica = end($extensao_array);
                $extensao = strtolower($extensao_unica);

                // Define o novo nome do arquivo usando um UNIX TIMESTAMP
                $nome = time() . '.' . $extensao;

                // Define o novo nome do arquivo usando um UNIX TIMESTAMP
                $nome = $nome_cliente . '-foto-rua-' . date('d-m-Y') . date('H-m-s')  . '.' . $extensao;


                move_uploaded_file($arqTemp, $pasta . $nome);
            }
        }
    }
}
