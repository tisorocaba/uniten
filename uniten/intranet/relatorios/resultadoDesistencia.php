<?php
require_once '../util/config.php';
Security::admSecurity();
$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'resultadoDesistencia.php', 'Acessou: ', $_REQUEST);

$inicio = data_us(Aluno::staticGet(12)->escape($_REQUEST['data_inicio']));
$fim = data_us(Aluno::staticGet(12)->escape($_REQUEST['data_fim']));
logDao::gravaLog($user->login, 'resultadoDesistencia.php', 'Visualizou: Resultado da pesquisa de Desistencia ', $_REQUEST,' Periodo: '.$inicio.' a '.$fim);

$sql = "select 
  id as agenda,
 (select local from local where id = local_id) as local,
 (select nome from curso WHERE id = curso_id ) as curso,
 (select fantasia from empresa where id = empresa_curso_id) as fantasia,
  DATE_FORMAT(data_termino, '%m' ) as mes_termino,
 ((select count(aluno_id) from local_curso_aluno LCA where LCA.local_curso_id = LC.id and LCA.status = 4) * 100 / (
(select count(aluno_id) from local_curso_aluno LCA where LCA.local_curso_id = LC.id and LCA.status = 2) +
(select count(aluno_id) from local_curso_aluno LCA where LCA.local_curso_id = LC.id and LCA.status = 3) +
(select count(aluno_id) from local_curso_aluno LCA where LCA.local_curso_id = LC.id and LCA.status = 4) )) as percentual



from local_curso LC

where data_inicio >= '" . $inicio . "' 
AND data_inicio   <= '" . $fim . "'
AND status = 2 
";

// REmovida do select para contabilizar todos os cursos
//  HAVING (select count(*) from local_curso_aluno LCA where local_curso_id = id and LCA.status = 2)  >0



if ((int) $_POST['local'] !== 0) {
    $sql .= " AND local_id = " . (int) $_POST['local'] . " ORDER BY  percentual DESC ";
    $local = Local::staticGet((int) $_POST['local'])->local;
} else {
    $sql .= " ORDER BY  percentual DESC ";
    $local = " TODOS";
}


$rs = Aluno::staticGet(12)->_getConnection()->executeSQL($sql);


$_SESSION['SQL'] = $sql;
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

<script src="scripts/formAlunoGeral.js"></script>

<table width="100%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Relatórios &raquo; Desistência</strong> </p>
        </td>
    </tr>

</table>


<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
        <td width="1139" colspan="2"><strong>Período Pesquisado: </strong><?php echo $_REQUEST['data_inicio'] ?> a <?php echo $_REQUEST['data_fim'] ?> </td>
    </tr>
    <tr class="listaClara">
        <td colspan="2"><strong>Local:</strong> <?php echo $local; ?></td>
    </tr>



    <tr class="">
        <td>&nbsp;</td>
    </tr>
    <tr class="">
        <td><table width="100%" border="0">
                <tr align="center">
                    <td width="8%" bgcolor="#CCCCCC"><strong>Cód.</strong></td>
                    <td width="32%" bgcolor="#CCCCCC"><strong>Curso</strong></td>
                    <td width="14%" bgcolor="#CCCCCC"><strong>Mês de Término</strong></td> 
                    <td width="15%" bgcolor="#CCCCCC"><strong>Local</strong></td>
                    <td width="15%" bgcolor="#CCCCCC"><strong>Empresa</strong></td>
                    <td width="16%" bgcolor="#CCCCCC"><strong>Percentual de Desistência</strong></td>
                  
                </tr>
                <?php
                $cont = 0;
               
                
                while ($row = mysql_fetch_array($rs)) {
                  

                    if ($cont === 0) {
                        $linha = "listaClara";
                        $cont = 1;
                    } else {
                        $linha = "listaEscura";
                        $cont = 0;
                    }
                    
                   
                    ?>
                    <tr class="<?php echo $linha ?>" align="center">
                        <td align="left"><?php echo $row['agenda'] ?></td>
                        <td align="left"><?php echo $row['curso'] ?></td>
                        
                        <td><?php echo mostraMes($row['mes_termino']) ?></td>
                        <td><?php echo $row['local'] ?></td>
                        <td><?php echo $row['fantasia'] ?></td>
                       
                        <td><?php echo number_format($row['percentual'],2) ?> %</td>
                       
                    </tr>
                    <?php 
                } ?>

            </table></td>

    </tr>
    <tr class="">
        <td>&nbsp;</td>
    </tr>
    <tr class="">
        <td align="center"><input type="button" name="button2" id="button3" value="voltar" onclick="history.go(-1)" />
          <input type="button" name="button" id="button" value="imprimir" onclick="print();" />
            <input type="button" name="button" id="button2" value="exportar" onclick="self.location='../xls_relatorios.php'" /></td>
    </tr>



</table>

<?php

function porcentagem($total, $valor) {
    $x = (($valor * 100) / $total);
    return number_format($x, 1);
}
?>