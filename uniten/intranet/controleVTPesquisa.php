<?php 
require_once 'util/config.php';
Security::admSecurity();


$_SESSION['DATAINICIO'] = Local::staticGet((int)$_POST['local'])->escape(data_us($_POST['data_inicio']));
$_SESSION['DATAFINAL'] = Local::staticGet((int)$_POST['local'])->escape(data_us($_POST['data_fim']));





logDao::gravaLog($user->login, 'controleVTPesquisa', 'Visualizou: resultado da pesquisa', $_REQUEST,'','Periodo: '.$_SESSION['DATAINICIO'].' a '.$_SESSION['DATAFINAL']);

if((int)$_REQUEST['local']==0){
	$titulo = "UNITE / UNITE ÉDEN";
        
        $sql = 'select id,
                   sum( (select count(*) from diario_classe_aluno where diario_classe_id = id and vale = 1) * 2 ) as total,
                  (SELECT nome FROM  local_curso LC, curso C WHERE  DC.local_curso_id = LC.id AND LC.curso_id = C.id) as curso,
                  (SELECT local FROM  local_curso LC, local L WHERE  DC.local_curso_id = LC.id AND LC.local_id = L.id) as local,
                  (SELECT periodo FROM  local_curso LC WHERE  DC.local_curso_id = LC.id) as periodo,
                  (SELECT LC.id FROM local_curso LC WHERE  DC.local_curso_id = LC.id) as id,

                   local_curso_id
            from diario_classe DC 
            where data_aula >= "'.$_SESSION['DATAINICIO'].'"
            and data_aula <= "'.$_SESSION['DATAFINAL'].'"
            and local_curso_id in (SELECT id FROM local_curso WHERE local_id = 1 or local_id = 31)
            group by local_curso_id';
        
        
  }else{
	$titulo = Local::staticGet((int)$_POST['local'])->local;
         $sql = 'select id,
                   sum( (select count(*) from diario_classe_aluno where diario_classe_id = id and vale = 1) * 2 ) as total,
                  (SELECT nome FROM  local_curso LC, curso C WHERE  DC.local_curso_id = LC.id AND LC.curso_id = C.id) as curso,
                  (SELECT local FROM  local_curso LC, local L WHERE  DC.local_curso_id = LC.id AND LC.local_id = L.id) as local,
                  (SELECT periodo FROM  local_curso LC WHERE  DC.local_curso_id = LC.id) as periodo,
                  (SELECT LC.id FROM local_curso LC WHERE  DC.local_curso_id = LC.id) as id,

                   local_curso_id
            from diario_classe DC 
            where data_aula >= "'.$_SESSION['DATAINICIO'].'"
            and data_aula <= "'.$_SESSION['DATAFINAL'].'"
            and local_curso_id in (SELECT id FROM local_curso WHERE local_id = '.(int)$_REQUEST['local'].')
            group by local_curso_id';
         
    

}



$_SESSION['SQL'] = $sql;

$rs = Local::staticGet((int)$_POST['local'])->_getConnection()->executeSQL($sql)




?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="intranet.css" rel="stylesheet" type="text/css">
<script src="scripts/controleVTPesquisa.js"></script>
      <p><span class="titulo">Controle de VT</span><br>
</p>
      <table width="100%" cellpadding="3" cellspacing="1" class="lista">
        <tr class="listaClara">
          <td colspan="13"><strong>Local: </strong> <?php echo $titulo?></td>
        </tr>
        <tr class="listaClara">
          <td colspan="13"><strong>Período: <?php echo $_POST['data_inicio']?> a <?php echo $_POST['data_fim']?></strong></td>
        </tr>
       
        <tr class="listaClara">
          <td width="155"><strong>Local</strong></td>
          
          <td width="15"><strong>Cód.</strong></td>
          <td width="533"><strong>Curso</strong></td>
         
          <td width="165"><strong>Período</strong></td>
         
          
          <td width="289" align="right"><strong>Total de VT</strong></td>
          
        </tr>
         <?php 
		    $cont  = 0;
			$total = 0;
			
			
		    while($row = mysql_fetch_array($rs)){ 
			 if ($cont === 0) {
                        $linha = "listaClara";
                        $cont = 1;
                    } else {
                        $linha = "listaEscura";
                        $cont = 0;
                    }
					
			$total += $row['total'];
		    
		 ?>
        <tr class="<?php echo $linha?>">
          <td><?php echo $row['local']?></td>
          <td><?php echo $row['local_curso_id']?></td>
          <td><?php echo $row['curso']?></td>
          
          <td><?php echo periodoCurso($row['periodo'])?></td>
         
         
          <td align="right">
		   <a href="controleVTDetalhes.php?agenda=<?php echo  $row['id'] ?>" class="cssAlunos" id="<?php echo $row['id'] ?>">
		    <?php echo $row['total']?>
           </a>
           </td>
         
        </tr>
       <?php } ?> 
       
       
       <tr class="<?php echo $linha?>" >
          <td align="right">&nbsp;</td>
         
          <td align="right"></td>
        
          <td align="right">&nbsp;</td>
       
          <td align="right"><b><strong>Total: </strong><?php echo $total?></b></td>
          
        </tr>
       
      </table>
      <p align="center">
         <input type="button" name="imprimir" id="imprimir" value="Imprimir" onclick="print();" /> 
        <input type="button" name="enviar" id="enviar2" value="Exportar" onclick="self.location='xls_gastos.php'" /> 
        <input type="button" name="enviar2" id="enviar" value="Voltar" onclick="self.location='principal.php?acao=controleVT'" />
</p>
