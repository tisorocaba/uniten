<?php
require_once '../util/config.php';
Security::admSecurity();
$user = unserialize($_SESSION['USER']);


$inicio = data_us(Aluno::staticGet(12)->escape($_REQUEST['data_inicio']));


if((int)$_REQUEST['visualizar']===1){
	$sql = " select count(local_curso_id) as total, C.nome as curso, LC.id as cod, L.local, LC.* from local_curso_aluno LCA, aluno A, local_curso LC, curso C , local L
        where aluno_id = A.id
        and LCA.local_curso_id = LC.id
        and LC.curso_id = C.id
        and LC.local_id = L.id
        and local_curso_id in (select id from local_curso where prova_data = '" . $inicio . "')
		group by local_curso_id
			
		";
}else{
	$sql = " select CONCAT(LC.id, '-', aluno_id) as protocolo, C.nome as curso, LC.id as cod, L.local, A.* from local_curso_aluno LCA, aluno A, local_curso LC, curso C , local L
        where aluno_id = A.id
        and LCA.local_curso_id = LC.id
        and LC.curso_id = C.id
        and LC.local_id = L.id
        and local_curso_id in (select id from local_curso where prova_data = '" . $inicio . "')
			
		";
}








$rs = Aluno::staticGet(12)->_getConnection()->executeSQL($sql);


$_SESSION['SQL'] = $sql;



logDao::gravaLog($user->login, 'resultadoInscricaoPorData.php', 'Visualizou: Resultado da pesquisa de Inscrições por Data da Prova', $_REQUEST,' Data: '.$inicio);

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
            <p><strong class="titulo">Relatórios &raquo; Inscrições por Data da Prova</strong> </p>
        </td>
    </tr>

</table>


<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
        <td width="1139" colspan="2"><strong>Data da prova: </strong><?php echo $_REQUEST['data_inicio'] ?> </td>
    </tr>
  

    <tr class="">
        <td>
       <?php if($_REQUEST['visualizar']==0) { ?>
        Total: <strong><?php echo mysql_num_rows($rs)?></strong> inscrições
        <?php } ?>
          <table width="100%" border="0">
            <tr>
              <td>&nbsp;</td> 
              <td align="right"><a href="../xls_relatorios.php" target="_blank">Exportar</a></td>
            </tr>
        </table></td>
    </tr>
    <tr class="">
        <td>
        <?php if((int)$_REQUEST['visualizar']===1) { ?>
         
         <table width="100%" border="0">
                <tr align="center">
                    <td width="29%" bgcolor="#CCCCCC" align="left"><strong>Curso</strong></td>
                    <td width="18%" bgcolor="#CCCCCC"><strong>Local do Curso</strong></td>
                    <td width="18%" bgcolor="#CCCCCC"><strong>Local da Prova</strong></td>
                    <td width="17%" bgcolor="#CCCCCC"><strong>Inscritos</strong></td>
                </tr>
                <?php
                $cont = 0;
                $i=1;
                $total =0;
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
                        <td align="left"><?php echo $row['curso'] ?> </td>
                        <td align="center"><?php echo mb_strtoupper($row['local']) ?></td>
                        
                        <td align="center"><?php echo mb_strtoupper($row['prova_local']) ?></td>
                        <td align="center"><?php echo mb_strtoupper($row['total']) ?></td>
                    </tr>
                        <?php
					$i++; 
                } ?>
                    <tr class="" align="center">
                      <td align="left">&nbsp;</td>
                      <td align="center">&nbsp;</td>
                      <td align="center">Total</td>
                      <td align="center"><?php echo $total;?></td>
                    </tr>
                    
                
             </table>
         <?php }else{ ?>
         <table width="100%" border="0">
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
          </table>
         <?php } ?>    
      </td>

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
