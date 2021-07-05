<?php

class persistencia
{


    private $caminhoBanco;
    private $tipoBanco;

    public function __construct(string $caminhoBanco, string $tipoBanco)
    {
        $this->caminhoBanco = $caminhoBanco;
        $this->tipoBanco = $tipoBanco;
    }

    //função que insere os dados no banco de dados sqlite que esta na pasta
    //area-administrativa/app/database/config/radnet.sqlite

    public function insertBanco(string $nome, string $cpf, string $rg, DateTimeInterface $dt_nasc, string $nomeMae, string $email, string $tel1, string $tel2, string $endereco, string $pontoDeReferencia, string $dataDeVencimento, string $planoEscolhido, string $infoAdd, string $nome_func)
    {

        //$caminhoBanco = 'area-administrativa/app/database/config/radnet.sqlite';
        //$pdo = new PDO('sqlite:' . $caminhoBanco);

        $pdo = new PDO($this->tipoBanco . $this->caminhoBanco);

        $sqlInsert = "INSERT INTO cliente (
            `nome`,
            `cpf`,
            `rg`,
            `dt_nasc`,
            `nome_mae`,
            `email`,
            `tel_1`,
            `tel_2`,
            `endereco`,
            `ponto_referencia`,
            `data_vencimento`,
            `plano_escolhido`,
            `info_add`,
            `nome_func`
            )
            VALUES(
        '{$nome}',
        '{$cpf}',
        '{$rg}',
        '{$dt_nasc->format('Y-m-d')}',
        '{$nomeMae}',
        '{$email}',
        '{$tel1}',
        '{$tel2}',
        '{$endereco}',
        '{$pontoDeReferencia}',
        '{$dataDeVencimento}',
        '{$planoEscolhido}',
        '{$infoAdd}',
        '{$nome_func}')";

        $status = $pdo->exec($sqlInsert);

        //retorna a inserção para ser enviado um aviso de sucesso ou falha
        return $status;
    }
}
