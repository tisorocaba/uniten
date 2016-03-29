<?php
require_once 'util/config.php';
Security::admSecurity();
$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);

$tempoDesempregos = new TempoDesemprego();
$tempoDesempregos->find();

$motivo = new DesistenciaMotivo();
$motivo->find();
$user = unserialize($_SESSION['USER']);
$desistenciajustificada = '';

if (!empty($_GET['id'])) {
    $obj = new Aluno();
    $obj->get($_GET['id']);
    
    $obj->nome = str_replace("\\", "",$obj->nome);
    $obj->endereco = str_replace("\\", "",$obj->endereco);
    $obj->cidade = str_replace("\\", "",$obj->cidade);
    
    $obj->dataNascimento = data_br($obj->dataNascimento);
    @$aluno = $obj->toArray();

    require_once 'dao/agendaCursoDao.php';
    $agendaDao = new AgendaCursoDao();
    $dadosAgenda = $agendaDao->getAgendaAluno($_SESSION['CODAGENDA'], $_GET['id']);
    if ($dadosAgenda !== false) {
        $nota = $dadosAgenda->nota;
        $classificacao = $dadosAgenda->classificacao;
        $status = (int) $dadosAgenda->status;
        $passe = $dadosAgenda->passe;

        if ($status === 4) {
            if (!empty(Desistencia::staticGet('aluno', $_GET['id'])->id)) {
                $desistenciaId = Desistencia::staticGet('aluno', $_GET['id'])->id;
                $desistenciajustificada = 1;
                $motivoDesistencia = Desistencia::staticGet('aluno', $_GET['id'])->motivo;
            } else {
                $desistenciajustificada = 0;
            }
        }
    }

    logDao::gravaLog($user->login, 'candidatoSituacao', 'Acessou: cadastro de situacao(alteracao)', $_REQUEST, '', 'aluno: ' . $_GET['id']);
} else {
    $aluno['cpf'] = $_REQUEST['cpf'];
    
   logDao::gravaLog($user->login, 'candidatoSituacao', 'Acessou: cadastro de situacao(novo)', $_REQUEST);

}
?>

<link href="intranet.css" rel="stylesheet" type="text/css">
<link href="css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">
<script src="js/jquery-1.6.2.min.js" type="text/javascript"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/candidatoFormulario.js"></script>
<form action="candidatoLogic.php" name="form" id="form1" method="post" enctype="multipart/form-data">
<?php if (!empty($_GET['id'])) { ?>
        <input type="hidden" name="id" id="id" value="<?php echo @$_GET['id'] ?>">
        <input type="hidden" name="desistenciaId" id="desistenciaId" value="<?php echo @$desistenciaId ?>">
<?php } ?>


    <input type="hidden" name="op" id="op" value="<?php echo @$_GET['acao'] ?>">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="intranet.css" rel="stylesheet" type="text/css">
    <table width="100%" border="0" cellspacing="0" cellpadding="15">
        <tr>
            <td valign="top" style="text-align:justify;">
                <p><strong class="titulo">Candidato &raquo;  Alteração de situação</strong></p>
            </td>
        </tr>
        <tr>
            <td>

                <table width="100%" border="0" cellspacing="3" cellpadding="1">

                    <tr>
                        <td colspan="2"><strong>Dados Pessoais</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr />
                        </td>
                    </tr>                    

                    <tr>
                        <td width="28%">Nome:</td>
                        <td width="72%" style="text-transform: uppercase">
                            <?php echo @$aluno['nome'];?>
                        </td>
                        </tr>
                        <tr>
                          <td>CPF:</td>
                          <td>
                              <?php echo @$aluno['cpf'];?>
                          </td>
                        </tr>
                        <tr>
                            <td>RG:</td>
                            <td>
                                <?php echo @$aluno['rg'];?>
                            </td>
                        </tr>

                    <!-- <tr>
                        <td width="28%">Nome:</td>
                        <td width="72%"><input name="nome" type="text" value="<?php echo @$aluno['nome'] ?>" size="55" maxlength="95" id="nome" class="validate[required]" />
                            *</td>
                    </tr>
                    <tr>
                        <td>CPF:</td>
                        <td><input name="cpf" type="text" size="12" value="<?php echo @$aluno['cpf'] ?>" maxlength="12"  readonly="readonly"/>
                            *</td>
                    </tr>
                    <tr>
                        <td>RG:</td>
                        <td><input name="rg" type="text" size="12" maxlength="12" id="rg" value="<?php echo @$aluno['rg'] ?>" class="validate[required]"  />
                            *</td>
                    </tr> -->

                    <tr>
                        <td><strong>Informações do Curso</strong></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2"><hr /></td>
                    </tr>
                    <tr>
                        <td>Situação:</td>
                        <td>
                            <select name="status_agenda" id="cbStatusAgenda">
                                <option value="0">suplente</option>
                                <option value="1" <?php if (@$status === 1)
                                        echo "selected" ?>>matriculado</option>
                                <option value="2" <?php if (@$status === 2)
                                        echo "selected" ?>>aprovado</option>
                                <option value="3" <?php if (@$status === 3)
                                        echo "selected" ?>>reprovado</option>
                                <option value="4" <?php if (@$status === 4)
                                        echo "selected" ?>>desistente</option> 
                            </select></td>                           
                    </tr>
                    
                    <tr>
                        <td align="left">&nbsp;</td>
                        <td align="left">
                            <input type="hidden" value="gravar" name="acao" />
                            <input name="enviar" type="submit" value="Concluir Alteração"  />
                            <input name="voltar" type="button" value="Voltar" onclick="history.go(-1)" />
                            &nbsp;&nbsp;&nbsp;</td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</form>
<p>&nbsp;</p>
