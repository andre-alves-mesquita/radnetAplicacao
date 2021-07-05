<?php

class enviarEmail
{

    //função utilizada para preencher os campos do email com os valores enviados no formulario, criando um
    // html.
    public function preencherCorpoDoEmail(string $nome, string $cpf, string $rg,  string $nomeMae, string $email, string $tel1, string $tel2, string $endereco, string $pontoDeReferencia, string $dataDeVencimento, string $planoEscolhido, string $infoAdd, string $dt_nasc_string, string $nome_func)
    {

        $arquivo = "
    <style type='text/css'>

    body {
        margin: 0px;
        font-family: Arial;
        font-size: 12px;
        color: black;
        
    }

    </style>
    <html>
    <table width='510' border=1 style='border-color: LightCyan' bgcolor=silver>
    
    <tr>
        <td width='500'>Nome: $nome</td>
    </tr>
    <tr>
        <td width='320'>CPF: $cpf</td>
    </tr>
    <tr>
    <td width='320'>RG: $rg</td>
</tr>
<tr>
    <td width='320'>Data de Nascimento: $dt_nasc_string </td>
</tr>
<tr>
    <td width='320'>Nome da Mãe: $nomeMae</td>
</tr>
<tr>
    <td width='320'>E-mail: $email</td>
</tr>
<tr>
    <td width='320'>Telefone 1: $tel1</td>
</tr>
<tr>
    <td width='320'>Telefone 2: $tel2</td>
</tr>
<tr>
    <td width='320'>Endereço: $endereco</td>
</tr>
<tr>
    <td width='320'>E-mail: $pontoDeReferencia</td>
</tr>
<tr>
    <td width='320'>Data de Vencimento: $dataDeVencimento</td>
</tr>
<tr>
    <td width='320'>Plano Escolhido: $planoEscolhido</td>
</tr>
<tr>
    <td width='320'>Informações Adicionais: $infoAdd</td>
</tr>
<tr>
    <td width='320'>Nome do Funcionario: $nome_func</td>
</tr>
     
    </table>

    </html>
";

        return $arquivo;
    }
}
