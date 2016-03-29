<?php
require_once 'util/config.php';
require_once 'dao/agendaCursoDao.php';
Security::admSecurity();



if (!empty($_REQUEST['agenda'])) {
    $_SESSION['CODAGENDA'] = $_REQUEST['agenda'];
}

$agendaDao = new AgendaCursoDao();
$alunos = $agendaDao->listaCandidatoAgenda($_SESSION['CODAGENDA'], @$_REQUEST['aluno']);

$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);

$user = unserialize($_SESSION['USER']);

logDao::gravaLog($user->login, 'candidatos', 'Acessou: lista de candidatos inscritos', $_REQUEST, '', 'Agenda: ' . $_SESSION['CODAGENDA']);
?>

<link href="intranet.css" rel="stylesheet" type="text/css">
<script src="js/jquery-1.5.min.js" type="text/javascript"></script>
<script src="scripts/cadidatos.js" type="text/javascript"></script>
<p><span class="titulo">Candidatos</span><br />
    <br>
    Curso: <?php echo $agenda->curso->nome ?><br />
    Data: <?php echo data_br($agenda->dataInicio) ?><br />
    <input type="hidden" value="<?php echo $_SESSION['CODAGENDA'] ?>" id="hdAgenda" />
<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
        <td colspan="8"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td colspan="3" align="center"><table width="100%" border="0">
                            <tr>
                                <td><strong>Exportar:</strong>
                                    <select name="cbExportar" id="cbExportar" >
                                        <option value="" >Selecionar...</option>
                                        <option value="i" >Inscritos</option>
                                        <option value="m">Matrículado</option>

                                    </select></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="23%"><strong>Listar Candidatos:</strong>
                                    <label for="select"></label>
                                    <select name="tipoCandidatos" id="tipoCandidatos"  onchange='self.location = this.value'>
                                        <option value="candidatos.php" selected="selected">Inscritos</option>
                                        <option value="candidatosClassificados.php">Classificados</option>
                                        <option value="candidatosDesclassificados.php" >Não Compareceram</option>
                                    </select></td>
                                <td width="69%">&nbsp;</td>
                                <td width="8%">Total: <strong><?php echo count($alunos) ?></strong></td>
                            </tr>
                        </table></td>
                </tr>
                <tr>
                    <td colspan="3" align="center"><strong>Candidatos Inscritos</strong></td>
                </tr>
                <tr>
                    <td width="30%">Pesquisa:
                        <input name="agenda" type="hidden" id="agenda" value="<?php echo @$_SESSION['CODAGENDA'] ?>" />
                        <label for="textfield"></label>
                        <input type="text" name="aluno" id="aluno" value="<?php echo @$_REQUEST['aluno'] ?>" />
                        <input type="submit" name="button" id="button" value="Pesquisar" onclick="self.location = 'candidatos.php?agenda=<?php echo $_SESSION['CODAGENDA'] ?>&amp;aluno=' + document.getElementById('aluno').value" /></td>
                    <td width="54%" align="center">&nbsp;</td>
                    <td width="16%" align="right"><a href="candidatoCadastro.php?agenda=<?php echo $_REQUEST['agenda'] ?>" >Incluir Candidato</a></td>
                </tr>
            </table></td>
    </tr>
    <tr class="listaClara">
        <td><strong>Protocolo</strong></td>
        <td><strong>Cadastro</strong></td>
        <td><strong>Nome</strong></td>
        <td><strong>Telefone</strong></td>
        <td><strong>Bairro</strong></td>
        <td><strong>Classificação</strong></td>
        <td width="61" align="center"><strong>Matriculado</strong></td>
        <td width="21" align="center">&nbsp;</td>
    </tr>
<?php
foreach ($alunos as $aluno) {
    ?>
        <tr class="listaClara">
            <td width="142"><?php echo $_SESSION['CODAGENDA'] . '-' . $aluno->id ?></td>
            <td width="88"><?php echo $aluno->data ?></td>
            <td width="314" style="text-transform: uppercase"><a href="aluno.php?cod=<?php echo $aluno->id ?>"><?php echo $aluno->aluno ?></a></td>
            <td width="123" ><?php echo $aluno->telefone ?></td>
            <td width="267" style="text-transform: uppercase"><?php echo $aluno->bairro ?></td>
            <td width="98">
    <?php if ($aluno->classificacao != 0) { ?>
        <?php echo $aluno->classificacao ?>º
        <?php if ($aluno->classificacao > $agenda->vagas) { ?>
                        Suplente
                    <?php } ?>

                <?php } ?>
            </td>
            <td align="center">
                <input type="checkbox" name="checkbox" id="<?php echo $aluno->id ?>" class="cssConfirmacao" <?php if ($aluno->status == 1) echo "checked"  ?> <?php if ((int)$aluno->status ===4) { echo "disabled=\"disabled\""; } ?>   />
                <label for="checkbox">Sim</label></td>
            <td align="center">
    <?php if ((int) $user->login === 100 || (int) $user->login === 5) { ?>
                    <a href="javascript:;" id="<?php echo $aluno->id ?>" class="remover"><img src="imagens/icon_delete.gif" width="15" height="15" border="0" /></a>
    <?php } ?>
            </td>

        </tr>
                <?php } ?>
</table>
<p>&nbsp;</p>