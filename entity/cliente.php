<?php

 // classe para inserção e retorno dos atributos do cliente em instancia
 
class cliente
{
    private  $nome;
    private  $cpf;
    private  $rg;
    private  $dt_nasc;
    private  $nome_mae;
    private  $email;
    private  $tel_1;
    private  $tel_2;
    private  $endereco;
    private  $ponto_referencia;
    private  $data_vencimento;
    private  $plano_escolhido;
    private  $info_add;
    private  $dt_nasc_string;
    private  $nome_func;

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome(string $nome_cliente)
    {
        $this->nome = $nome_cliente;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf_cliente)
    {
        $cpfCorrigido = str_replace('.', '', str_replace('-', '', $cpf_cliente));

        $this->cpf = $cpfCorrigido;
    }

    public function getRg()
    {
        return $this->rg;
    }

    public function setRg(string $rg_cliente)
    {
        $this->rg = $rg_cliente;
    }

    public function getDtNasc()
    {
        return $this->dt_nasc;
    }

    public function SetDtNasc(DateTimeInterface $dt_nasc_cliente)
    {
        $this->dt_nasc = $dt_nasc_cliente;
    }

    public function getNomeMae()
    {
        return $this->nome_mae;
    }

    public function setNomeMae(string $nome_mae_cliente)
    {
        $this->nome_mae = $nome_mae_cliente;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email_cliente)
    {
        $this->email = $email_cliente;
    }


    public function getTel1()
    {
        return $this->tel_1;
    }

    public function setTel1(string $tel_1_cliente)
    {
        $this->tel_1 = $tel_1_cliente;
    }

    public function getTel2()
    {
        return $this->tel_2;
    }

    public function setTel2(string $tel_2_cliente)
    {
        $this->tel_2 = $tel_2_cliente;
    }

    public function getEndereco()
    {
        return $this->endereco;
    }

    public function setEndereco(string $endereco_cliente)
    {
        $this->endereco = $endereco_cliente;
    }

    public function getPontoDeReferencia()
    {
        return $this->ponto_referencia;
    }

    public function setPontoDeReferencia(string $ponto_referencia_cliente)
    {
        $this->ponto_referencia = $ponto_referencia_cliente;
    }

    public function getDataVencimento()
    {
        return $this->data_vencimento;
    }

    public function setDataVencimento(string $data_vencimento_cliente)
    {
        $this->data_vencimento = $data_vencimento_cliente;
    }

    public function getPlanoEscolhido()
    {
        return $this->plano_escolhido;
    }

    public function setPlanoEscolhido(string $plano_escolhido_cliente)
    {

        switch ($plano_escolhido_cliente) {

            case 1:
                $plano = "START - SEM FIDELIDADE";

                break;
            case 2:
                $plano = "FAMILY - SEM FIDELIDADE";

                break;
            case 3:
                $plano = "OFFICE - SEM FIDELIDADE";

                break;
            case 4:
                $plano = "GAME - SEM FIDELIDADE";

                break;

            case 5:
                $plano = "START - COM FIDELIDADE";

                break;
            case 6:
                $plano = "FAMILY - COM FIDELIDADE";

                break;
            case 7:
                $plano = "OFFICE - COM FIDELIDADE";

                break;
            case 8:
                $plano = "GAME - COM FIDELIDADE";

                break;
        }


        $this->plano_escolhido = $plano;
    }

    public function getInfoAdd()
    {
        return $this->info_add;
    }

    public function setInfoAdd(string $info_add_cliente)
    {
        $this->info_add = $info_add_cliente;
    }

    public function getDtNascString()
    {
        return $this->dt_nasc_string;
    }

    public function setDtNascString(string $dt_nasc_string)
    {
        $this->dt_nasc_string = $dt_nasc_string;
    }


    public function getNomeFunc()
    {
        return $this->nome_func;
    }

    public function setNomeFunc(string $nome_funcionario)
    {
        $this->nome_func = $nome_funcionario;
    }
}
