<?php
require_once 'util/config.php';
require_once 'dao/agendaDisciplinaProfessorDao.php';
Security::admSecurity();



if (!empty($_REQUEST['agenda'])) {
    $_SESSION['CODAGENDA'] = $_REQUEST['agenda'];
}

$monitoresDao = new AgendaDisciplinaProfessorDao();
$monitores = $monitoresDao->listaProfessorAgenda($_SESSION['CODAGENDA']);


$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'empresaCursoMonitores', 'Acessou: lista de monitores da agenda ', $_REQUEST,'','Agenda: '.$_SESSION['CODAGENDA']);
?>

<link href="intranet.css" rel="stylesheet" type="text/css">
<script src="js/jquery-1.5.min.js" type="text/javascript"></script>
<script src="scripts/agendamonitores.js" type="text/javascript"></script>
<p><span class="titulo">Monitores</span><br />
    <br>
    Curso: <?php echo $agenda->curso->nome ?><br />
</p>

<?php if (count($monitores) > 0 && empty($_REQUEST['acao'])) { ?>
    <table width="100%" cellpadding="1" cellspacing="1" class="lista">
        <tr class="listaClara">
            <td><strong>Disciplina</strong></td>
            <td><strong>Monitor</strong></td>
        </tr>
        <?php
        foreach ($monitores as $monitor) {
            ?>
            <tr class="listaClara">
                <td width="291"><?php echo $monitor->disciplina ?></td>
                <td width="349"><?php echo $monitor->professor ?></td>
            </tr>
        <?php } ?>
    </table>
<p align="center"><input name="imprimir" value="imprimir" type="button" onclick="print();" /></p>

<?php } else { ?>
Nenhum professor cadastrado para esse curso.

<?php } ?>
