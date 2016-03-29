<?php
require_once '../util/config.php';
Security::admSecurity();
$user = unserialize($_SESSION['USER']);


/**** pegando as datas ****/
$inicio = data_us(Aluno::staticGet(12)->escape($_REQUEST['data_inicio']));
$fim = data_us(Aluno::staticGet(12)->escape($_REQUEST['data_fim']));


/*** montando o sql generico ***/
$select = " select count(motivo) as totalmotivo, motivo ";
$from   = " from desistencia D, local_curso LC ";
$where  = " where data_inicio >= '" . $inicio . "' AND data_inicio   <= '" . $fim . "'";
$group  = " group by motivo ";

/*** verificando o tipo de pesquisa ***/
if($_REQUEST['filtro']=='L'){
	
	if($_REQUEST['local']!=0){
		$sqlLista = $select.$from.$where.' and D.local_curso_id = LC.id and local_id = '.$_REQUEST['local'].$group;
		$sqlTotal = 'select count(*) as total '.$from.$where.' and D.local_curso_id = LC.id and local_id = '.$_REQUEST['local'];
		$filtro = 'Local &raquo;  '.Local::staticGet((int)$_REQUEST['local'])->local;
                $sqlAbandono = "select count(aluno_id) as total from local_curso_aluno LCA, local_curso LC 
                                where LCA.local_curso_id = LC.id 
                                and LCA.status = 4
                                and data_inicio >= '" . $inicio . "' AND data_inicio   <= '" . $fim . "'
                                and LC.local_id = ".$_REQUEST['local']."
                                and LCA.aluno_id 
                                not in ( 
                                        select aluno_id  from desistencia D, local_curso LC  
                                        where D.local_curso_id = LC.id 
                                        and data_inicio >= '" . $inicio . "' AND data_inicio   <= '" . $fim . "'
                                        and LC.local_id = ".$_REQUEST['local']."
                                    )" ;
                
	}else{
		$sqlLista = $select.$from.$where.' and D.local_curso_id = LC.id '.$group;
		$sqlTotal = 'select count(*) as total '.$from.$where.' and D.local_curso_id = LC.id ';
                $sqlAbandono = "select count(aluno_id) as total  from local_curso_aluno LCA, local_curso LC 
                                where LCA.local_curso_id = LC.id 
                                and LCA.status = 4
                                and data_inicio >= '" . $inicio . "' AND data_inicio   <= '" . $fim . "'
                                and LCA.aluno_id 
                                not in ( 
                                        select aluno_id  
                                        from desistencia D, local_curso LC  
                                        where D.local_curso_id = LC.id 
                                        and data_inicio >= '" . $inicio . "' AND data_inicio   <= '" . $fim . "'
                                     )" ;
		$filtro = 'Local &raquo;  Todos';
	}
	
}elseif($_REQUEST['filtro']=='P'){
	if($_REQUEST['programa']!=0){
		$sqlLista = $select.$from.$where.' and D.local_curso_id = LC.id and local_id in 
		                                  (select L.id from local L, projeto P where projeto_id = P.id and P.id = '.$_REQUEST['programa'].') 
										  '.$group;
		$sqlTotal = 'select count(*) as total '.$from.$where.' and D.local_curso_id = LC.id and 
		                                local_id in (select L.id from local L, projeto P where projeto_id = P.id and P.id = '.$_REQUEST['programa'].') ';
                 $sqlAbandono = "select count(aluno_id) as total from local_curso_aluno LCA, local_curso LC 
                                where LCA.local_curso_id = LC.id 
                                and LCA.status = 4
                                and data_inicio >= '" . $inicio . "' AND data_inicio   <= '" . $fim . "'
                                and local_id in (select L.id from local L, projeto P where projeto_id = P.id and P.id = ".$_REQUEST['programa'].") 
                                and LCA.aluno_id 
                                not in ( 
                                        select aluno_id  from desistencia D, local_curso LC  
                                        where D.local_curso_id = LC.id 
                                        and data_inicio >= '" . $inicio . "' AND data_inicio   <= '" . $fim . "'
                                        and local_id in (select L.id from local L, projeto P where projeto_id = P.id and P.id = ".$_REQUEST['programa'].") 
                                    )" ;
		$filtro = 'Programa &raquo;  '.Projeto::staticGet((int)$_REQUEST['programa'])->nome;
	}else{
		$sqlLista = $select.$from.$where.' and D.local_curso_id = LC.id '.$group;
		$sqlTotal = 'select count(*) as total '.$from.$where.' and D.local_curso_id = LC.id ';
                $sqlAbandono = "select count(aluno_id) as total  from local_curso_aluno LCA, local_curso LC 
                                where LCA.local_curso_id = LC.id 
                                and LCA.status = 4
                                and data_inicio >= '" . $inicio . "' AND data_inicio   <= '" . $fim . "'
                                and LCA.aluno_id 
                                not in ( 
                                        select aluno_id  
                                        from desistencia D, local_curso LC  
                                        where D.local_curso_id = LC.id 
                                        and data_inicio >= '" . $inicio . "' AND data_inicio   <= '" . $fim . "'
                                     )" ;
		$filtro = 'Programa &raquo;  Todos'; 
	}
	
}elseif($_REQUEST['filtro']=='C'){
	
	if($_REQUEST['curso']!=0){
		$sqlLista = $select.$from.$where.' and D.local_curso_id = LC.id and curso_id = '.$_REQUEST['curso'].$group;
		$sqlTotal = 'select count(*) as total '.$from.$where.' and D.local_curso_id = LC.id and curso_id = '.$_REQUEST['curso'];
		$filtro   = 'Curso &raquo;  '.Curso::staticGet((int)$_REQUEST['curso'])->nome;
                $sqlAbandono = "select count(aluno_id) as total from local_curso_aluno LCA, local_curso LC 
                                where LCA.local_curso_id = LC.id 
                                and LCA.status = 4
                                and data_inicio >= '" . $inicio . "' AND data_inicio   <= '" . $fim . "'
                                and curso_id = ".$_REQUEST['curso']."
                                and LCA.aluno_id 
                                not in ( 
                                        select aluno_id  from desistencia D, local_curso LC  
                                        where D.local_curso_id = LC.id 
                                        and data_inicio >= '" . $inicio . "' AND data_inicio   <= '" . $fim . "'
                                        and curso_id = ".$_REQUEST['curso']."
                                    )" ;
	}else{
		$sqlLista = $select.$from.$where.' and D.local_curso_id = LC.id '.$group;
		$sqlTotal = 'select count(*) as total '.$from.$where.' and D.local_curso_id = LC.id ';
                $sqlAbandono = "select count(aluno_id) as total  from local_curso_aluno LCA, local_curso LC 
                                where LCA.local_curso_id = LC.id 
                                and LCA.status = 4
                                and data_inicio >= '" . $inicio . "' AND data_inicio   <= '" . $fim . "'
                                and LCA.aluno_id 
                                not in ( 
                                        select aluno_id  
                                        from desistencia D, local_curso LC  
                                        where D.local_curso_id = LC.id 
                                        and data_inicio >= '" . $inicio . "' AND data_inicio   <= '" . $fim . "'
                                     )" ;
		$filtro = 'Curso &raquo;  Todos';
	}
	
}



$rstotal = Aluno::staticGet(12)->_getConnection()->executeSQL($sqlTotal);
$row = mysql_fetch_array($rstotal);

$rs = Aluno::staticGet(12)->_getConnection()->executeSQL($sqlLista);

$rsAbandono = Aluno::staticGet(12)->_getConnection()->executeSQL($sqlAbandono);
$rowAbandono = mysql_fetch_array($rsAbandono);

$totalAmostra = ($row['total']+$rowAbandono['total']);


logDao::gravaLog($user->login, 'resultadoDesistenciaJustificativa.php', 'Visualizou: Resultado da pesquisa de justificativa de desistencia Periodo ', $_REQUEST,' Periodo: '.$inicio.' a '.$fim.' '.$filtro);

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
            <p><strong class="titulo">Relatórios &raquo; Motivo de Desistência</strong> </p>
        </td>
    </tr>

</table>


<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
      <td colspan="2"><strong>Filtrado: <?php echo $filtro;?></strong></td>
    </tr>
    <tr class="listaClara">
        <td width="1139" colspan="2"><strong>Período Pesquisado: </strong><?php echo $_REQUEST['data_inicio'] ?> a <?php echo $_REQUEST['data_fim'] ?> </td>
    </tr>
  

    <tr class="">
        <td>Total: <?php echo $totalAmostra;?> fichas</td>
    </tr>
    <tr class="">
        <td><table width="100%" border="0">
                <tr align="center">
                    <td width="71%" bgcolor="#CCCCCC" align="left"><strong>Motivo</strong></td>
                    <td width="16%" bgcolor="#CCCCCC"><strong>Quantidade</strong></td>
                    <td width="13%" bgcolor="#CCCCCC"><strong>Percentual</strong></td>
                </tr>
                <?php
                $cont = 0;
                $i=1;
                
                while ($row = mysql_fetch_array($rs)) {
                  

                    if ($cont === 0) {
                        $linha = "listaClara";
                        $cont = 1;
                    } else {
                        $linha = "listaEscura";
                        $cont = 0;
                    }
                    $rs2 = Aluno::staticGet(12)->_getConnection()->executeSQL('select nome from desistencia_motivo where id= '.$row['motivo']);
		    $row2 = mysql_fetch_array($rs2);
                   
                    ?>
                    <tr class="<?php echo $linha ?>" align="center">
                        <td align="left"><?php echo $row2['nome'] ?> </td>
                        <td align="center"><?php echo $row['totalmotivo']; ?></td>
                        <td align="center"><?php echo number_format((($row['totalmotivo']*100)/$totalAmostra),2)?>%</td>
                    </tr>
                    
                    <?php
					$i++; 
                } ?>
                    <tr  align="center" >
                        <td align="left">Abandono </td>
                        <td align="center"><?php echo $rowAbandono['total']; ?></td>
                        <td align="center"><?php echo @number_format((($rowAbandono['total']*100)/$totalAmostra),2)?>%</td>
                    </tr>
             </table></td>

    </tr>
    <tr class="">
        <td>&nbsp;</td>
    </tr>
    <tr class="">
        <td align="center"><input type="button" name="button2" id="button3" value="voltar" onclick="history.go(-1)" />
          <input type="button" name="button" id="button" value="imprimir" onclick="print();" /></td>
    </tr>



</table>
