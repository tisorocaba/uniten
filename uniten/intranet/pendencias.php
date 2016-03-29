<?php
require_once 'util/config.php';
require_once '../intranet/dao/pendenciaDao.php';
Security::admSecurity();

$pendenciasDao = new PendenciaDao();
$pendenciasDao->removeLog();

// agendas sem presenca
$diariosSemPresencas = array();
if ($user->local != 1) {
    $diariosSemPresencas = $pendenciasDao->diariosSemPresenca($user->local);
} else {
    $diariosSemPresencas = $pendenciasDao->diariosSemPresenca();
}
$_SESSION['diariosSemPresencas'] = $diariosSemPresencas;
$totalSemPresenca = count($diariosSemPresencas);


// agendas sem monitor
$agendasSemMonitores = array();
if ($user->local != 1) {
    $agendasSemMonitores = $pendenciasDao->agendasSemProfessor($user->local);
} else {
    $agendasSemMonitores = $pendenciasDao->agendasSemProfessor();
}
$_SESSION['agendasSemMonitores'] = $agendasSemMonitores;
$totalAgendaSemMonitor = count($agendasSemMonitores);


// agendas com poucos alunos
$agendasPoucoAlunos = array();
if ($user->local != 1) {
    $agendasPoucoAlunos = $pendenciasDao->agendasComPoucosAulons($user->local);
} else {
    $agendasPoucoAlunos = $pendenciasDao->agendasComPoucosAulons();
}
$_SESSION['agendasPoucoAlunos'] = $agendasPoucoAlunos;
$totalAgendaPoucoAlunos = count($agendasPoucoAlunos);



// agendas com poucos alunos
$agendasSemLancamentoAvaliacao = array();
if ($user->local != 1) {
    $agendasSemLancamentoAvaliacao = $pendenciasDao->agendasFinalizadasSemAvaliacao($user->local);
} else {
    $agendasSemLancamentoAvaliacao = $pendenciasDao->agendasFinalizadasSemAvaliacao();
}
$_SESSION['agendasSemLancamentoAvaliacao'] = $agendasSemLancamentoAvaliacao;
$totalAgendasSemLancamentoAvaliacao = count($agendasSemLancamentoAvaliacao);

// agendas sem valor de frete -- valido apenas para unite eden(31) e unite seminario(1)
$agendasSemValorVale = array();
if ($user->local != 1) {
    $agendasSemValorVale = $pendenciasDao->agendaComValorVale($user->local);
} else {
    $agendasSemValorVale = $pendenciasDao->agendaComValorVale();
}
$_SESSION['agendasSemValorVale'] = $agendasSemValorVale;
$totalAgendasSemValorVale = count($agendasSemValorVale);

// agendas sem valor de frete 
$agendasSemValor = array();
if ($user->local != 1) {
    $agendasSemValor = $pendenciasDao->agendasSemValorCurso($user->local);
} else {
    $agendasSemValor = $pendenciasDao->agendasSemValorCurso();
}
$_SESSION['agendasSemValor'] = $agendasSemValor;
$totalAgendasSemValor = count($agendasSemValor);




// agendas sem diarios
$agendasSemDiarios = array();
if ($user->local != 1) {
    $agendasSemDiarios = $pendenciasDao->agendasSemDiarios($user->local);
} else {
    $agendasSemDiarios = $pendenciasDao->agendasSemDiarios();
}
$_SESSION['agendasSemDiarios'] = $agendasSemDiarios;
$totalAgendasSemDiarios = count($agendasSemDiarios);




$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'pendencias', 'Acessou: pendencias do sistema', $_REQUEST);


?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="intranet.css" rel="stylesheet" type="text/css">
<link href="css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/alunos.js"></script>
<table width="100%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Relatório de pendências</strong></p>
        </td>
    </tr>
    <tr>
        <td>
            <form action="principal.php?acao=alunosPesquisa" method="post" name="form1" id="form1">
                <table width="100%" border="0" cellspacing="3" cellpadding="1">
                    <tr class="splicenet">
                        <td width="100%"><table width="100%" cellpadding="3" cellspacing="1" class="lista">

                               <tr class="listaClara">
                                  <td><strong>Agendas sem diários </strong></td>
                                  <td><a href="xls_pendencias_diarios.php" target="_blank">
                                    <?php  echo count($agendasSemDiarios)?> agendas</a></td>
                                </tr>
                             
                                <!-- 
                                <tr class="listaClara">
                                  <td colspan="2">
                                  
                                  
                                   <table width="100%" border="0">
                                               <?php foreach ($agendasSemDiarios as $empresa) {
                                                ?>
                                                <tr>
                                                    <td width="89%" class="normal"><?php  echo $empresa['empresa']?> </td>
                                                    <td width="11%" class="normal">
                                                    <a href="xls_pendencias_diarios.php?cod=<?php echo $empresa['idempresa']?>" target="_blank">
                                                    <?php  echo $empresa['total']?>
agendas</a><a href="xls_pendencias_diarios.php?cod=<?php echo $empresa['idempresa']?>" target="_blank"></a></td>
                                                </tr>
                                                <?php } ?>
                                            </table>
                                  
                                  
                                  
                                  </td>
                                </tr>
                                -->
                                <tr class="listaEscura">
                                    <td width="884"><strong>Quantidade de diários sem lançamentos de presenças</strong></td>
                                    <td width="105"><a href="xls_pendencias.php?cod=1"><?php echo $totalSemPresenca; ?> diários </a></td>
                                </tr>

                                <?php
                                if ($totalSemPresenca > 0) {
                                    if ($user->local != 1) {
                                        $agendasSemValorEmpresa = $pendenciasDao->diariosSempresencaByEmpresa($user->local);
                                    } else {
                                        $agendasSemValorEmpresa = $pendenciasDao->diariosSempresencaByEmpresa();
                                    }
                                    ?>
                                    <tr class="listaEscura">
                                        <td colspan="2">
                                            
                                            <table width="100%" border="0">
                                               <?php foreach ($agendasSemValorEmpresa as $empresa) {
                                                ?>
                                                <tr>
                                                    <td width="92%" class="normal"><?php  echo $empresa['empresa']?> </td>
                                                    <td width="8%" class="normal">
                                                    <a href="xls_pendencias_diarios_empresa.php?cod=<?php echo $empresa['cod']?>" target="_blank"><?php  echo $empresa['total']?> diários</a></td>
                                                </tr>
                                                <?php } ?>
                                            </table>
                                            
                                            
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr class="listaClara">
                                    <td width="884"><strong>Cursos sem monitor</strong></td>
                                    <td width="105"><a href="xls_pendencias.php?cod=2"><?php echo $totalAgendaSemMonitor; ?> cursos</a></td>
                                </tr>

                                <tr class="listaEscura">
                                    <td width="884"><strong>Cursos com pouco ou sem alunos</strong></td>
                                    <td width="105"><a href="xls_pendencias.php?cod=3"><?php echo $totalAgendaPoucoAlunos; ?> cursos</a></td>
                                </tr>

                                <tr class="listaClara">
                                    <td width="884"><strong>Cursos sem lançamento de avaliação</strong></td>
                                    <td width="105"><a href="xls_pendencias.php?cod=4"><?php echo $totalAgendasSemLancamentoAvaliacao; ?> cursos</a></td>
                                </tr>

                                <tr class="listaEscura">
                                    <td width="884"><strong>Cursos sem lançamento de VT</strong></td>
                                    <td width="105"><a href="xls_pendencias.php?cod=5"><?php echo $totalAgendasSemValorVale; ?> cursos</a></td>
                                </tr>

                                <tr class="listaEscura">
                                    <td width="884"><strong>Cursos sem lançamento de valor</strong></td>
                                    <td width="105"><a href="xls_pendencias.php?cod=6"><?php echo $totalAgendasSemValor; ?> cursos</a></td>
                                </tr>


                            </table></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </form>

        </td>
    </tr>
</table>

<p>&nbsp;</p>
