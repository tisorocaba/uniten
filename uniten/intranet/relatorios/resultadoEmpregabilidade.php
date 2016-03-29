<?php
require_once '../util/config.php';
Security::admSecurity();
$user = unserialize($_SESSION['USER']);



$inicio = data_us(Aluno::staticGet(12)->escape($_REQUEST['data_inicio']));
$fim = data_us(Aluno::staticGet(12)->escape($_REQUEST['data_fim']));
logDao::gravaLog($user->login, 'resultadoEmpregabilidade.php', 'Visualizou: Resultado de Empregabilidade ', $_REQUEST,' Periodo: '.$inicio.' a '.$fim);

$sql = "select count(P.aluno_id) as total, C.nome as curso, C.id as cod from poscurso P, local_curso L, curso C 
where P.local_curso_id = L.id and L.curso_id = C.id
and P.data_cadastro >= '" . $inicio . "' 
and P.data_cadastro <= '" . $fim . "' 
and trabalhando = 1 ";

$sFiltro = '';
if ($_POST['registrado'] != '') {
    $sql .= " AND registrado = " . $_POST['registrado'];
	if((int)$_POST['registrado']===1){
	   $sFiltro .= '<br>&raquo;Registrado: Sim';
	}else{
	   $sFiltro .= '<br>&raquo;Registrado: Não';
	}
	
}

if ($_POST['autonomo'] != '') {
    $sql .= " AND autonomo = " . $_POST['autonomo'];
	if((int)$_POST['autonomo']===1){
	   $sFiltro .= '<br>&raquo;Autônomo: Sim';
	}else{
	   $sFiltro .= '<br>&raquo;Autônomo: Não';
	}
} 

if ($_POST['estavaEmpregado'] != '') {
    $sql .= " AND estava_empregado = " . $_POST['estavaEmpregado'];
	if((int)$_POST['estavaEmpregado']===1){
	   $sFiltro .= '<br>&raquo;Estava empregado antes do curso: Sim';
	}else{
	   $sFiltro .= '<br>&raquo;Estava empregado antes do curso: Não';
	}
} 

if ($_POST['eraArea'] != '') {
    $sql .= " AND era_area = " . $_POST['eraArea'];
	if((int)$_POST['eraArea']===1){
	   $sFiltro .= '<br>&raquo;Era na área referente ao curso: Sim';
	}else{
	   $sFiltro .= '<br>&raquo;Era na área referente ao curso: Não';
	}
} 

if ($_POST['cursoAjudou'] != '') {
    $sql .= " AND curso_ajudou = " . $_POST['cursoAjudou'];
	if((int)$_POST['cursoAjudou']===1){
	   $sFiltro .= '<br>&raquo;O Curso ajudou ser admitido no emprego atual: Sim';
	}else{
	   $sFiltro .= '<br>&raquo;O Curso ajudou ser admitido no emprego atual: Não';
	}
}

$sql .= " group by C.nome, C.id order by total DESC";



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
            <p><strong class="titulo">Relatórios &raquo; Empregabilidade</strong> </p>
        </td>
    </tr>

</table>


<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
        <td width="1139" colspan="2"><strong>Período Pesquisado: </strong><?php echo $_REQUEST['data_inicio'] ?> a <?php echo $_REQUEST['data_fim'] ?> </td>
    </tr>
    <?php if(!empty($sFiltro)){ ?>
  <tr class="listaClara">
        <td colspan="2"><strong>Filtro:</strong> <?php echo $sFiltro ?>  </td>
    </tr>
    <?php } ?>


    <tr class="">
        <td>&nbsp;</td>
    </tr>
    <tr class="">
        <td><table width="100%" border="0">
                <tr align="center">
                    <td width="8%" bgcolor="#CCCCCC"><strong>Posição</strong></td>
                    <td width="32%" bgcolor="#CCCCCC"><strong>Curso</strong></td>
                    <td width="14%" bgcolor="#CCCCCC"><strong>Total</strong></td> 
                </tr>
                <?php
                $cont = 0;
                $i=1;
                $total = 0;
                while ($row = mysql_fetch_array($rs)) {
                  

                    if ($cont === 0) {
                        $linha = "listaClara";
                        $cont = 1;
                    } else {
                        $linha = "listaEscura";
                        $cont = 0;
                    }
                    
					$total += $row['total'];
                   
                    ?>
                    <tr class="<?php echo $linha ?>" align="center">
                        <td align="left"><?php echo $i?>º </td>
                        <td align="left"><?php echo $row['curso'] ?></td>
                        
                        <td><?php echo $row['total'] ?></td>
                    </tr>
                    
                    <?php
					$i++; 
                } ?>

                <tr  align="center">
                                      <td align="left">&nbsp;</td>
                                      <td align="left">Total</td>
                                      <td><?php echo $total?></td>
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