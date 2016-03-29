<?php
require_once '../util/config.php';
Security::admSecurity();
$user = unserialize($_SESSION['USER']);


$inicio = data_us(Aluno::staticGet(12)->escape($_REQUEST['data_inicio']));
$fim = data_us(Aluno::staticGet(12)->escape($_REQUEST['data_fim']));




$sql = "	
		select C.nome as curso, L.local as local,  A.* from 
   local_curso_aluno LCA, 
   local_curso LC,
   local L, 
   aluno A,
   curso C 
where LCA.data_cadastro >= '" . $inicio . "'
and LCA.data_cadastro <= '" . $fim . "'
and LCA.local_curso_id = LC.id
and LC.local_id = L.id
and LCA.aluno_id = A.id
and LC.curso_id = C.id
order by  C.nome, L.local ASC";





$rs = Aluno::staticGet(12)->_getConnection()->executeSQL($sql);


$_SESSION['SQL'] = $sql;

 logDao::gravaLog($user->login, 'resultadoInscricaoPeriodo.php', 'Visualizou: Resultado da pesquisa de Inscrições por Periodo ', $_REQUEST,' Periodo: '.$inicio.' a '.$fim);

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
            <p><strong class="titulo">Relatórios &raquo; Inscrições por Período</strong> </p>
        </td>
    </tr>

</table>


<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
        <td width="1139" colspan="2"><strong>Período Pesquisado: </strong><?php echo $_REQUEST['data_inicio'] ?> a <?php echo $_REQUEST['data_fim'] ?> </td>
    </tr>
  

    <tr class="">
        <td>Total: <?php echo mysql_num_rows($rs)?></td>
    </tr>
    <tr class="">
        <td><table width="100%" border="0">
                <tr align="center">
                    <td width="29%" bgcolor="#CCCCCC" align="left"><strong>Curso</strong></td>
                    <td width="18%" bgcolor="#CCCCCC"><strong>Local</strong></td>
                    <td width="18%" bgcolor="#CCCCCC"><strong>Aluno</strong></td>
                    <td width="17%" bgcolor="#CCCCCC"><strong>Email</strong></td>
                    <td width="18%" bgcolor="#CCCCCC"><strong>Telefone</strong></td> 
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
                    
					
                   
                    ?>
                    <tr class="<?php echo $linha ?>" align="center">
                        <td align="left"><?php echo $row['curso'] ?> </td>
                        <td align="center"><?php echo mb_strtoupper($row['local']) ?></td>
                        
                        <td align="center"><?php echo mb_strtoupper($row['nome']) ?></td>
                        <td align="center"><?php echo mb_strtoupper($row['email']) ?></td>
                        <td align="center"><?php echo $row['telefone'] ?></td>
                    </tr>
                    
                    <?php
					$i++; 
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
