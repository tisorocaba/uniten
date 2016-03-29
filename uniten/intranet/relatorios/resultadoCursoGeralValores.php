<?php
require_once '../util/config.php';
Security::admSecurity();
$user = unserialize($_SESSION['USER']);


$inicio = data_us(Aluno::staticGet(12)->escape($_REQUEST['data_inicio']));
$fim = data_us(Aluno::staticGet(12)->escape($_REQUEST['data_fim']));
logDao::gravaLog($user->login, 'resultadoAlunoGeral.php', 'Visualizou: Resultado da Pesquisa Aluno Geral', $_REQUEST, ' Periodo: ' . $inicio . ' a ' . $fim);



if (@$_REQUEST['filtro']=="L") {



    $sql = "SELECT  
    id as cod,
     (select nome from curso where id = curso_id) as curso,
     (select retorna_mes_br(MONTH(data_inicio))) as mes,
      (select local from local where id = LC.local_id) as local,
     
    (select sum(carga_horaria) from disciplina D, agenda_professor_disciplina A where A.local_curso_id = LC.id and A.disciplina_id = D.id) as cargahoraria,
    vagas,
    (select fantasia from empresa where id = empresa_curso_id) as empresa,
    
    (select count(*) from local_curso_aluno LCA where status <> 0 and local_curso_id = LC.id) as iniciaram, 
     
     
    (select count(*) from local_curso_aluno LCA where local_curso_id = id and LCA.status = 2) as aprovados,
    
    (select count(*) from local_curso_aluno LCA where local_curso_id = id and LCA.status = 3) as reprovados,
    ((select count(*) from local_curso_aluno LCA where status <> 0 and local_curso_id = LC.id) - ((select count(*) from local_curso_aluno LCA where local_curso_id = id and LCA.status = 2)+(select count(*) from local_curso_aluno LCA where local_curso_id = id and LCA.status = 3))) as desistentes,
    
    (select percentual_formandos(vagas,id)) as aproveitamento,valor




From local_curso LC
where data_inicio >= '" . $inicio . "' 
AND data_termino   <= '" . $fim . "'
AND status = 2";

// REmovida do select para contabilizar todos os cursos
//  HAVING (select count(*) from local_curso_aluno LCA where local_curso_id = id and LCA.status = 2)  >0



    if ((int) $_POST['local'] != 0) {
        $sql .= " AND local_id = " . (int) $_POST['local'] . " ORDER BY  data_inicio,local_id ASC ";
        $local = Local::staticGet((int) $_POST['local'])->local;
    } else {
        $sql .= " ORDER BY  data_inicio, local_id ASC ";
        $local = " Local: TODOS";
    }
} else {

    $sql = " SELECT  
    id as cod,
     (select nome from curso where id = curso_id) as curso,
     (select retorna_mes_br(MONTH(data_inicio))) as mes,
     (select local from local where id = LC.local_id) as local,
     (select id from local where id = LC.local_id) as idLoc,
     
    (select sum(carga_horaria) from disciplina D, agenda_professor_disciplina A where A.local_curso_id = LC.id and A.disciplina_id = D.id) as cargahoraria,
    vagas,
    (select fantasia from empresa where id = empresa_curso_id) as empresa,
    
    (select count(*) from local_curso_aluno LCA where status <> 0 and local_curso_id = LC.id) as iniciaram, 
     
     
    (select count(*) from local_curso_aluno LCA where local_curso_id = id and LCA.status = 2) as aprovados,
    
    (select count(*) from local_curso_aluno LCA where local_curso_id = id and LCA.status = 3) as reprovados,
    ((select count(*) from local_curso_aluno LCA where status <> 0 and local_curso_id = LC.id) - ((select count(*) from local_curso_aluno LCA where local_curso_id = id and LCA.status = 2)+(select count(*) from local_curso_aluno LCA where local_curso_id = id and LCA.status = 3))) as desistentes,
    
    (select percentual_formandos(vagas,id)) as aproveitamento,valor




From local_curso LC
where data_inicio >= '" . $inicio . "' 
AND data_termino   <= '" . $fim . "'
AND status = 2
AND local_id in (select id from local where projeto_id = " . $_REQUEST['programa'] . ") order by local_id ASC";

    $local = " Programa: " . Projeto::staticGet((int) $_REQUEST['programa'])->nome;
}










$rs = Aluno::staticGet(12)->_getConnection()->executeSQL($sql);


$_SESSION['SQL'] = $sql;
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../intranet.css" rel="stylesheet" type="text/css">
<link href="../css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">
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
            <p><strong class="titulo">Relatórios &raquo; Curso &raquo; Formando por Vaga(Valores)</strong> </p>
        </td>
    </tr>

</table>


<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
        <td width="1139" colspan="2"><strong>Período Pesquisado: </strong><?php echo $_REQUEST['data_inicio'] ?> a <?php echo $_REQUEST['data_fim'] ?> </td>
    </tr>
    <tr class="listaClara">
        <td colspan="2"><strong> <?php echo $local; ?></strong></td>
    </tr>



    <tr class="">
        <td>&nbsp;</td>
    </tr>
    <tr class="">
        <td><table width="100%" border="0">
                <tr align="center">
                    <td width="3%" bgcolor="#CCCCCC" style="font-size:10px"><strong>Cód.</strong></td>
                    <td width="31%" bgcolor="#CCCCCC" style="font-size:10px"><strong>Local </strong></td>
                    <td width="27%" bgcolor="#CCCCCC" style="font-size:10px"><strong>Curso</strong></td>
                    <td width="5%" bgcolor="#CCCCCC" style="font-size:10px"><strong>Empresa</strong></td>
                    <td width="4%" bgcolor="#CCCCCC" style="font-size:10px"><strong>Mês</strong></td> 

                    <td width="6%" bgcolor="#CCCCCC" style="font-size:10px"><strong>C.Horária</strong></td>
                    <td width="4%" bgcolor="#CCCCCC" style="font-size:10px"><strong>Vagas</strong></td>
                    <td width="7%" bgcolor="#CCCCCC" style="font-size:10px"><strong>Valor do Curso</strong></td>
                </tr>
                <?php
                $cont = 0;
                $i = 1;
                $j = 1;

                $totalVagas = 0;
            
                $totalIniciaram = 0;
                $totalFormandos = 0;
                $totalValor = 0;
              

                $idLoc = false;
                while ($row = mysql_fetch_array($rs)) {

                    if ($_REQUEST['filtro']!="L") {
                        if($idLoc === false){
                            $idLoc = @$row['idLoc']; 
                            $linha = "listaClara";
                        }else{
                            if($idLoc !=  @$row['idLoc']){
                                if($linha=='listaClara'){
                                    $linha = "listaEscura";
                                }else{
                                    $linha='listaClara';
                                }
                                $idLoc = $row['idLoc']; 
                            }
                        }
                        
                    } else {
                        if ($cont === 0) {
                            $linha = "listaClara";
                            $cont = 1;
                        } else {
                            $linha = "listaEscura";
                            $cont = 0;
                        }
                    }



                    $totalVagas += $row['vagas'];

                    $totalIniciaram += $row['iniciaram'];
                    $totalFormandos += $row['aprovados'];
                   
					$totalValor += $row['valor'];

                    if ((int) $row['aproveitamento'] > 0) {
                        $j++;
                    }
                    ?>
                    <tr class="<?php echo $linha ?>" align="center" >
                        <td align="left" style="font-size:10px"><?php echo $row['cod'] ?></td>
                        <td align="left" style="font-size:10px"><?php echo ($row['local']) ?></td>
                        <td align="left" style="font-size:10px"><?php echo $row['curso'] ?></td>
                        <td style="font-size:10px"><?php echo $row['empresa'] ?></td>
                        <td style="font-size:10px"><?php echo ($row['mes']) ?></td>

                        <td style="font-size:10px"><?php echo $row['cargahoraria'] ?></td>
                        <td style="font-size:10px"><?php echo $row['vagas'] ?></td>
                        <td style="font-size:10px">R$ <?php echo number_format($row['valor'], 2, ',', '.') ?></td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
                <tr class="" align="center">
                    <td colspan="6" bgcolor="#FFFF99" style="font-size:10px" align="right">TOTAL</td>
                    <td bgcolor="#FFFF99" style="font-size:10px"> <?php echo $totalVagas ?></td>
                    <td bgcolor="#FFFF99" style="font-size:10px">R$ <?php echo number_format($totalValor, 2, ',', '.') ?></td>
                </tr>

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