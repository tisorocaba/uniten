<?php
require_once 'util/config.php';
require_once 'dao/diarioClasseDao.php';
require_once 'dao/agendaDisciplinaProfessorDao.php';
Security::admSecurity();
$agenda = new AgendaCurso();
$_SESSION['CODAGENDA'] = $agenda->escape($_REQUEST['agenda']);
$agenda->get($_SESSION['CODAGENDA']);

$diarios = new DiarioClasse();
$diarios->alias('d')->where('d.agenda=? and d.data >= ? and d.data <= ?', $_SESSION['CODAGENDA'],$_SESSION['DATAINICIO'],$_SESSION['DATAFINAL'])->order('data DESC')->find();

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'controleVTDetalhes', 'Acessou: lista de VT gastos na agenda', $_REQUEST,'','Agenda: '.$_REQUEST['agenda']);

?>
<link href="intranet.css" rel="stylesheet" type="text/css">
<p><span class="titulo">Diário de Classe</span><br></p>
<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
        <td colspan="2">Curso: <?php echo $agenda->curso->nome ?>
            <br />
            Período pesquisado: <?php echo data_br($_SESSION['DATAINICIO']) ?> a <?php echo data_br($_SESSION['DATAFINAL']) ?>
        </td>
        <td colspan="6" align="right"><br />
        </td>
    </tr>
    <tr class="listaClara">
        <td height="28"><strong>Data</strong></td>
        <td><strong>Disciplina</strong></td>
        <td><strong>Monitor</strong></td>
        <td>Horas</td>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center"><strong>VT</strong></td>
    </tr>
    <?php
    $totalMin = 0;
    $totalVales = 0;
    $i = 0;
    $mes = '';
    $agendaProfessorDao = new AgendaDisciplinaProfessorDao();
    while ($diarios->fetch()) {
        
       
	   $rs = 
        
        $totalMin += retornaMinutos($diarios->horas);
        $diarioClasseDao = new DiarioClasseDao();
        $vales = $diarioClasseDao->totalVales($diarios->id);

        $totalVales += $vales;
        $i++;
        ?>

        <tr class="listaClara">
            <td width="93"><?php echo data_br($diarios->data) ?></td>
            <td width="358"><?php echo Disciplina::staticGet($diarios->disciplina)->nome ?></td>
            <td width="308"><?php echo $agendaProfessorDao->getProfessorPorAgendaDiciplina($_SESSION['CODAGENDA'], $diarios->disciplina) ?></td>
            <td width="79"><?php echo $diarios->horas ?></td>
            <td width="84">&nbsp;</td>
            <td width="71">&nbsp;</td>
            <td width="49">&nbsp;</td>
            <td width="72" align="right"><?php echo $vales * 2 ?></td>
        </tr>

    <?php } ?>
    <tr class="listaClara">
        <td>&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td>Total:</td>
        <td><?php echo str_pad(calculaHoras($totalMin), 4, '0'); ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right"><?php echo $totalVales * 2 ?></td>
    </tr>
</table>
<p>Quantidade de aulas: <?php echo $i; ?></p>
