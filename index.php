<?php

//Iniciando a sessão:
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

//Verifica se há o retorno status da tentativa de inserção do banco de dados

if (array_key_exists("status", $_SESSION)) {

    if ($_SESSION['status'] == 1) {
        echo "<script>alert('cadastro feito com sucesso');</script>";
    } else {
        echo "<script>alert('falha no cadastro, faça o cadastro novamento');</script>";
    }
    //destroi a sessão para que nao haja problemas com refresh
    session_unset();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="uft-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script type="text/javascript" src="jquery/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="jquery-mask/jquery.mask.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
</head>

<!-- as funções de script são para validar o cpf e utilizar a mascara de cpf -->

<body>

    <script>
        $(document).ready(function() {
            var $seuCampoCpf = $("#cpf");
            $seuCampoCpf.mask('000.000.000-00', {
                reverse: true
            });
        });

        $(document).ready(function() {
            var $seuCampoCpf = $("#TEL");
            $seuCampoCpf.mask('00-00000-0000', {
                reverse: true
            });
        });

        $(document).ready(function() {
            var $seuCampoCpf = $("#TEL2");
            $seuCampoCpf.mask('00-00000-0000', {
                reverse: true
            });
        });


        //Função que faz a validação do Cpf
        $(function() {
            //Executa a requisição quando o campo username perder o foco
            $('#cpf').blur(function() {
                var cpf = $('#cpf').val().replace(/[^0-9]/g, '').toString();

                var arr = ["11111111111", "22222222222", "33333333333", "44444444444", "55555555555", "66666666666", "77777777777", "88888888888", "99999999999", "00000000000"];

                if ($.inArray(cpf, arr) !== -1) {
                    var caractereRepetido = true;
                } else {
                    var caractereRepetido = false;
                };


                if (cpf.length == 11 && caractereRepetido == false) {
                    var v = [];

                    //Calcula o primeiro dígito de verificação.
                    v[0] = 1 * cpf[0] + 2 * cpf[1] + 3 * cpf[2];
                    v[0] += 4 * cpf[3] + 5 * cpf[4] + 6 * cpf[5];
                    v[0] += 7 * cpf[6] + 8 * cpf[7] + 9 * cpf[8];
                    v[0] = v[0] % 11;
                    v[0] = v[0] % 10;

                    //Calcula o segundo dígito de verificação.
                    v[1] = 1 * cpf[1] + 2 * cpf[2] + 3 * cpf[3];
                    v[1] += 4 * cpf[4] + 5 * cpf[5] + 6 * cpf[6];
                    v[1] += 7 * cpf[7] + 8 * cpf[8] + 9 * v[0];
                    v[1] = v[1] % 11;
                    v[1] = v[1] % 10;

                    //Retorna Verdadeiro se os dígitos de verificação são os esperados.
                    if ((v[0] != cpf[9]) || (v[1] != cpf[10])) {
                        alert('CPF inválido: ' + cpf);

                        $('#cpf').val('');
                        $('#cpf').focus();
                    }
                } else {
                    alert('CPF inválido:' + cpf);

                    $('#cpf').val('');
                    $('#cpf').focus();
                }
            });
        });
    </script>


    <!-- Construção da parte visual da aplicação-->
    <div class="container" style="padding:20px;">

        <div class="col-md-12 text-center" style="margin-bottom:30px;">
            <img src="img/logo.JPG" class="img-fluid" alt="radnet" width="300" height="400">
        </div>

        <div class="input-form">

            <div class="" style="margin-bottom: 30px; text-align:center;">

                <div class="card">
                    <div class="card-body">
                        <h2>Formulário de cadastro de Cliente</h2>
                    </div>
                </div>

            </div>
            <div class="d-flex justify-content-end" style="margin-bottom: 30px;">
                <a href="area-administrativa/radnet-admin/index.php"><button class="btn btn-primary" type="button">Painel Administrativo </button></a>
            </div>

            <form action="validacao.php" method="post" enctype="multipart/form-data">

                <div class=" input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Nome</span>
                    <input type="text" class="form-control" name="nome" placeholder="Nome Completo do Contratante" aria-label="Nome do Cliente" aria-describedby="basic-addon1" required>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">CPF</span>
                    <input type="text" class="form-control cpf-mask" name="cpf" id="cpf" placeholder="Ex.: 000.000.000-00" aria-label="CPF do Cliente" aria-describedby="basic-addon1" required>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">RG</span>
                    <input type="text" class="form-control" name="rg" placeholder="RG do Contratante" aria-label="RG do Cliente" aria-describedby="basic-addon1" required>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Data de Nascimento</span>
                    <input type="date" class="form-control" name="dt_nasc" placeholder="00-00-0000" aria-label="Data de Nascimento" aria-describedby="basic-addon1" required>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Nome da Mãe</span>
                    <input type="text" class="form-control" name="nome_mae" placeholder="Nome + Sobrenome" aria-label="Nome da Mãe" aria-describedby="basic-addon1" required>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">E-mail</span>
                    <input type="text" class="form-control" name="email" placeholder="exemplo@exemplo.com" aria-label="E-mail" aria-describedby="basic-addon1" required>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">1º telefone para contato</span>
                    <input type="tel" class="form-control" id="TEL" name="1_tel" placeholder="00-00000-0000" aria-label="1º telefone para contato" aria-describedby="basic-addon1" required>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">2º telefone para contato</span>
                    <input type="tel" class="form-control" id="TEL2" name="2_tel" placeholder="00-00000-0000" aria-label="2º telefone para contato" aria-describedby="basic-addon1" required>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Endereço</span>
                    <input type="text" class="form-control" name="endereco" placeholder="QD x LT x Conj x Rua x Bairro x Apart x " aria-label="Endereco" aria-describedby="basic-addon1" required>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Ponto de Referencia</span>
                    <input type="text" class="form-control" name="pt_ref" placeholder="Proximo a local x perto de y" aria-label="Ponto de Referencia" aria-describedby="basic-addon1" required>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Data de Vencimento</span>
                    <input type="text" class="form-control" name="dt_venc" placeholder="Ex.: 21" aria-label="Data de Vencimento" aria-describedby="basic-addon1" required>
                </div>

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Sem Fidelidade</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Com Fidelidade</a>
                    </li>

                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01">Plano Escolhido</label>
                            <select class="form-select" id="inputGroupSelect01" name="pl_esc" required>
                                <option value="1" selected>START - 20MB - R$ 79,90 / MENSAL</option>
                                <option value="2">FAMILY - 50MB - R$ 99,90 / MENSAL</option>
                                <option value="3">OFFICE - 100MB - R$ 149,90 / MENSAL</option>
                                <option value="4">GAME - 200MB - R$ 199,90 / MENSAL</option>
                            </select>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01">Plano Escolhido</label>
                            <select class="form-select" id="inputGroupSelect01" name="pl_esc" required>
                                <option value="5" selected>START - 20MB - R$ 59,90 / MENSAL</option>
                                <option value="6">FAMILY - 50MB - R$ 79,90 / MENSAL</option>
                                <option value="7">OFFICE - 100MB - R$ 129,90 / MENSAL</option>
                                <option value="8">GAME - 200MB - R$ 149,90 / MENSAL</option>
                            </select>
                        </div>

                    </div>

                </div>

                <div class="form-floating" style="margin-bottom: 15px;">
                    <textarea class="form-control" name="info_add" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                    <label for="floatingTextarea2">Informações Adicionais (se houver)</label>
                </div>

                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupFile01">Foto da Casa</label>
                    <input type="file" class="form-control" name="foto_casa" id="inputGroupFile01" required>
                </div>

                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupFile01">Foto da Rua (Não Obrigatório)</label>
                    <input type="file" class="form-control" name="foto_rua" id="inputGroupFile01">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input class="form-check-input" type="checkbox" value="" aria-label="Checkbox for following text input" required>
                    </div>
                    <span class="input-group-text" id="basic-addon1">Nome do Funcionário</span>
                    <input type="text" class="form-control" name="nome_func" placeholder="Nome + Sobrenome" aria-label="Ponto de Referencia" aria-describedby="basic-addon1" required>
                </div>

                <div class="d-grid gap-2 d-md-block" style="margin-bottom: 30px;">
                    <button class="btn btn-primary" type="submit">Enviar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

</body>

</html>