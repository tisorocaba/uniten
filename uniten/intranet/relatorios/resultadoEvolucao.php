<?php
require_once '../util/config.php';
require_once '../dao/agendaCursoDao.php';
include("../util/FusionChartsFree/Code/PHP/Includes/FusionCharts.php");
//include("../util/fusionChars/Includes/FusionCharts.php");
Security::admSecurity();
$user = unserialize($_SESSION['USER']);

logDao::gravaLog($user->login, 'resultadoEvolucao', 'Visualizou: Resultado da Evolucao ', $_REQUEST);

$agendaDao = new AgendaCursoDao();

asort($_REQUEST['anos']);

$_SESSION['ANOS'] = $_REQUEST['anos'];


?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../intranet.css" rel="stylesheet" type="text/css">
<link href="../css/validationEngine.jquery.css" rel="stylesheet" type="text/css">
<link href="../js/css/jquery-ui.css" rel="stylesheet" type="text/css">
<link href="../js/css/ui.theme.css" rel="stylesheet" type="text/css">
<script src="../js/jquery-1.6.2.min.js"></script>
<script src="../js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.ui.core.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.ui.widget.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.ui.datepicker.js" type="text/javascript" charset="utf-8"></script>
<script language="JavaScript" src="../util/FusionChartsFree/JSClass/FusionCharts.js"></script>

<script src="scripts/formAlunoGeral.js"></script>

<table width="100%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" bgcolor="#FFFFFF" style="text-align:justify;">
            <p><strong class="titulo">Relatórios &raquo; Evolução</strong> </p>
        </td>
    </tr>
   
</table>


<table width="100%" cellpadding="3" cellspacing="1" class="lista">
      


                    <tr class="">
                      <td colspan="2">&nbsp;</td>
            </tr>
                   
  <tr class="">
                      <td colspan="2"><table width="50%" border="0" align="center">
                        <tr>
                          <td>&nbsp;</td>
                          <?php foreach($_REQUEST['anos'] as $ano) { ?>
                              <td bgcolor="#FFFF00" align="center"><strong><?php echo $ano?></strong></td>
                          <?php } ?>
                        </tr>
                        <tr>
                          <td width="50%" bgcolor="#CCCCCC"><strong>Cursos Desenvolvidos</strong></td>
                          <?php foreach($_REQUEST['anos'] as $ano) { ?>
                          <td bgcolor="#CCCCCC" align="center"><?php echo $agendaDao->agendaDadosEvolucao($ano, 'C');?></td>
                          <?php } ?>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC"><strong>Vagas Ofertadas</strong></td>
                           <?php foreach($_REQUEST['anos'] as $ano) { ?>
                          <td bgcolor="#CCCCCC" align="center"><?php echo $agendaDao->agendaDadosEvolucao($ano, 'V');?></td>
                          <?php } ?>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC"><strong>Número de Formados</strong></td>
                           <?php foreach($_REQUEST['anos'] as $ano) { ?>
                          <td bgcolor="#CCCCCC" align="center"><?php echo $agendaDao->agendaDadosEvolucao($ano, 'N');?></td>
                          <?php } ?>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC"><strong>Demanda por cursos</strong></td>
                          <?php foreach($_REQUEST['anos'] as $ano) { ?>
                          <td bgcolor="#CCCCCC" align="center"><?php echo $agendaDao->agendaDadosEvolucao($ano, 'D');?></td>
                          <?php } ?>
                        </tr>
    </table></td>
                    </tr>
                    <tr class="">
                      <td width="89">&nbsp;</td>
                      <td width="1050">&nbsp;</td>
                    </tr>
                    <tr class="">
                      <td colspan="2" align="center">
                      
                       <?php
						echo renderChartHTML("../util/FusionChartsFree/Charts/FCF_MSColumn3D.swf", "xml-evolucao.php", "", "projecaoLucroAno", 850, 350, "", "", true);
                        ?>
                      </td>
                    </tr>
                    <tr class="">
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr class="">
                      <td colspan="2" align="center">
                         <input type="button" name="button2" id="button3" value="voltar" onclick="history.go(-1);" />
                         <input type="button" name="button" id="button" value="imprimir" onclick="print();" /></td>
                    </tr>



            </table>

<?php

function porcentagem($total,$valor){
    $x = @(($valor*100) / $total);
    return number_format($x,1);
}

?>