<?php
require_once '../util/config.php';
Security::admSecurity();
$user = unserialize($_SESSION['USER']);


$inicio = data_us(Aluno::staticGet(12)->escape($_REQUEST['data_inicio']));
$fim    = data_us(Aluno::staticGet(12)->escape($_REQUEST['data_fim']));

logDao::gravaLog($user->login, 'resultadoPosCursophp', 'Visualizou: Resultado da pesquisa Poscurso ', $_REQUEST,' Periodo: '.$inicio.' a '.$fim);

$sql = "select  
count(*) as total,
  (select count(*)  from poscurso P, local_curso L where local_curso_id = L.id and P.data_cadastro >= '".$inicio."' and P.data_cadastro <= '".$fim."' and trabalhando = 1) as trabalhando_sim,
  (select count(*)  from poscurso P, local_curso L where local_curso_id = L.id and P.data_cadastro >= '".$inicio."' and P.data_cadastro <= '".$fim."' and trabalhando = 0) as trabalhando_nao,
  (select count(*)  from poscurso P, local_curso L where local_curso_id = L.id and P.data_cadastro >= '".$inicio."' and P.data_cadastro <= '".$fim."' and trabalhando = 1 and registrado = 1) as trabalhando_registrado_sim,  
  (select count(*)  from poscurso P, local_curso L where local_curso_id = L.id and P.data_cadastro >= '".$inicio."' and P.data_cadastro <= '".$fim."' and trabalhando = 1 and registrado = 0) as trabalhando_registrado_nao, 
  (select count(*)  from poscurso P, local_curso L where local_curso_id = L.id and P.data_cadastro >= '".$inicio."' and P.data_cadastro <= '".$fim."' and trabalhando = 1 and registrado = 0 and autonomo = 1) as trabalhando_como_autonomo_sim,
  (select count(*)  from poscurso P, local_curso L where local_curso_id = L.id and P.data_cadastro >= '".$inicio."' and P.data_cadastro <= '".$fim."' and trabalhando = 1 and registrado = 0 and autonomo = 0) as trabalhando_como_autonomo_nao,
  (select count(*)  from poscurso P, local_curso L where local_curso_id = L.id and P.data_cadastro >= '".$inicio."' and P.data_cadastro <= '".$fim."' and estava_empregado = 1) as trabalhava_antes, 
  (select count(*)  from poscurso P, local_curso L where local_curso_id = L.id and P.data_cadastro >= '".$inicio."' and P.data_cadastro <= '".$fim."' and era_area = 1) as era_area,
  (select count(*)  from poscurso P, local_curso L where local_curso_id = L.id and P.data_cadastro >= '".$inicio."' and P.data_cadastro <= '".$fim."' and atendimento = 1) as atendimento_regular,
  (select count(*)  from poscurso P, local_curso L where local_curso_id = L.id and P.data_cadastro >= '".$inicio."' and P.data_cadastro <= '".$fim."' and atendimento = 2) as atendimento_bom,
  (select count(*)  from poscurso P, local_curso L where local_curso_id = L.id and P.data_cadastro >= '".$inicio."' and P.data_cadastro <= '".$fim."' and atendimento = 3) as atendimento_otimo,
  (select count(*)  from poscurso P, local_curso L where local_curso_id = L.id and P.data_cadastro >= '".$inicio."' and P.data_cadastro <= '".$fim."' and curso_ajudou = 1) as curso_ajudou
  
from poscurso P, local_curso L
where local_curso_id = L.id and P.data_cadastro >= '".$inicio."' and P.data_cadastro <= '".$fim."'";


//var_dump($sql);
$rs = Aluno::staticGet(12)->_getConnection()->executeSQL($sql);

$obj = mysql_fetch_object($rs);
$_SESSION['SQL'] = $sql;

$trabalhandoSim = porcentagem($obj->total,$obj->trabalhando_sim);
$trabalhandoNao = 100-$trabalhandoSim;
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../intranet.css" rel="stylesheet" type="text/css">
<link href="../../css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">
<link href="../js/css/jquery-ui.css" rel="stylesheet" type="text/css">
<link href="../js/css/ui.theme.css" rel="stylesheet" type="text/css">
<script src="../../js/jquery-1.6.2.min.js"></script>
<script src="../../js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="../../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.ui.core.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.ui.widget.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.ui.datepicker.js" type="text/javascript" charset="utf-8"></script>

<script src="scripts/formAlunoGeral.js"></script>

<table width="100%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Relatórios &raquo; Pós Curso</strong> </p>
        </td>
    </tr>
   
</table>


<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
      <td colspan="3"><strong>Período pesquisado: </strong><?php echo $_REQUEST['data_inicio'] ?> a <?php echo $_REQUEST['data_fim'] ?> </td>
    </tr>
    <tr class="listaClara">
      <td colspan="3"><strong>Total de Alunos: <?php echo $obj->total ?> alunos</strong></td>
    </tr>
      


                    <tr class="">
                      <td colspan="2">&nbsp;</td>
            </tr>
                    <tr class="">
                      <td colspan="2"><hr /></td>
                    </tr>
                    <tr class="">
                      <td colspan="2"><strong>Trabalhando:</strong></td>
                    </tr>
                    <tr class="">
                      <td width="89">&nbsp;</td>
                      <td width="1050"><table width="50%" border="0">
                        <tr>
                          <td width="39%">Sim:</td>
                          <td width="61%"><?php echo $trabalhandoSim ?>% - (<?php echo $obj->trabalhando_sim?>) Autônomo : <?php echo porcentagem($obj->total,$obj->trabalhando_como_autonomo_sim)?>% - (<?php echo $obj->trabalhando_como_autonomo_sim?>)</td>
                        </tr>
                        <tr>
                          <td>Não:</td>
                          <td><?php echo $trabalhandoNao?>% - (<?php echo $obj->trabalhando_nao?>)</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr class="">
                      <td colspan="2"><hr /></td>
                    </tr>
                    <tr class="">
                      <td colspan="2"><strong>Registrado</strong></td>
                    </tr>
                    <tr class="">
                      <td>&nbsp;</td>
                      <td><table width="50%" border="0">
                        <tr>
                          <td width="39%">Sim:</td>
                          <td width="61%"><?php echo porcentagem($obj->total,$obj->trabalhando_registrado_sim)?>% - (<?php echo $obj->trabalhando_registrado_sim?>)</td>
                        </tr>
                        <tr>
                          <td>Não:</td>
                          <td><?php echo porcentagem($obj->total,$obj->trabalhando_registrado_nao)?>% - (<?php echo $obj->trabalhando_registrado_nao?>)</td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr class="">
                      <td colspan="2"><hr /></td>
                      
                    </tr>
                    <tr class="">
                      <td colspan="2"><strong>Atendimento</strong></td>
                    </tr>
                    <tr class="">
                      <td>&nbsp;</td>
                      <td><table width="50%" border="0">
                        <tr>
                          <td width="39%">Regular:</td>
                          <td width="61%"><?php echo porcentagem($obj->total,$obj->atendimento_regular)?>% - (<?php echo $obj->atendimento_regular?>)</td>
                        </tr>
                        <tr>
                          <td>Bom:</td>
                          <td><?php echo porcentagem($obj->total,$obj->atendimento_bom)?>% - (<?php echo $obj->atendimento_bom?>)</td>
                        </tr>
                        <tr>
                          <td>Ótimo:</td>
                          <td><?php echo porcentagem($obj->total,$obj->atendimento_otimo)?>% - (<?php echo $obj->atendimento_otimo?>)</td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr class="">
                      <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr class="">
                      <td colspan="2"><strong>Estava empregado antes do curso:</strong> <?php echo porcentagem($obj->total,$obj->trabalhava_antes)?>% - (<?php echo $obj->trabalhava_antes?>)</td>
                      
                    </tr>
                    <tr class="">
                      <td colspan="2"><hr /></td>
                    </tr>
                    <tr class="">
                      <td colspan="2"><strong>Está na área referente ao curso: </strong><?php echo porcentagem($obj->total,$obj->era_area)?>% - (<?php echo $obj->era_area?>)</td>
                    </tr>
                    <tr class="">
                      <td colspan="2"><hr /></td>
                    </tr>
                    <tr class="">
                      <td colspan="2"><strong>O Curso ajudou: </strong><?php echo porcentagem($obj->total,$obj->curso_ajudou)?>% - (<?php echo $obj->curso_ajudou?>)</td>
                    </tr>
                    <tr class="">
                      <td colspan="2"><hr /></td>
                    </tr>
                    <tr class="">
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr class="">
                      <td colspan="2" align="center">
                         <input type="button" name="button2" id="button3" value="voltar" onclick="history.go(-1);" />
                         <input type="button" name="button" id="button" value="imprimir" onclick="print();" />
                         <input type="button" name="button" id="button2" value="exportar" onclick="self.location='../xls_relatorios.php'" /></td>
                    </tr>



            </table>

<?php

function porcentagem($total,$valor){
    try {
        $x = (($valor*100) / $total);
    } catch (Exception $exc) {
        $x=0;
    }

  
    return number_format($x,1);
}

?>