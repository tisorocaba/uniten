<?php 
require_once '../util/config.php';
Security::cursoSecurity();



$dataini   = Empresa::staticGet((int)$_POST['empresa'])->escape(data_us($_POST['data_inicio']));
$datafinal = Empresa::staticGet((int)$_POST['empresa'])->escape(data_us($_POST['data_fim']));


logDao::gravaLog($user->login, 'gastosPesquisa', 'Visualizou: resultado pesquisa relatorio financeiro', $_REQUEST,'','Periodo: '.$_POST['data_inicio'].' a '.$_POST['data_fim'].' Empresa: '.$_POST['empresa']);



$sql = 'SELECT
   
    local_curso_id as id,
    (select nome from curso C, local_curso LC where LC.id = local_curso_id and LC.curso_id = C.id) as curso,
    
(select data_inicio from curso C, local_curso LC where LC.id = local_curso_id and LC.curso_id = C.id) as inicio,
(select periodo from curso C, local_curso LC where LC.id = local_curso_id and LC.curso_id = C.id) as periodo,
 
(select local from local L, local_curso LC where LC.id = local_curso_id and LC.local_id = L.id) as local,
    
    (select 
     (select sum(carga_horaria) as carga  from disciplina D, curso_disciplina CD WHERE CD.curso_id = C.id and CD.disciplina_id = D.id) as carga
      from curso C, local_curso LC where LC.id = local_curso_id and LC.curso_id = C.id)  as carga,
      
      (select valor from local_curso where local_curso_id = id) as valor,
      
      ROUND((select valor from local_curso where local_curso_id = id) / (select 
     (select sum(carga_horaria) as carga  from disciplina D, curso_disciplina CD WHERE CD.curso_id = C.id and CD.disciplina_id = D.id) as carga
      from curso C, local_curso LC where LC.id = local_curso_id and LC.curso_id = C.id),2 ) as valor_hora,
      
     ROUND( ((select valor from local_curso where local_curso_id = id) / (select 
     (select sum(carga_horaria) as carga  from disciplina D, curso_disciplina CD WHERE CD.curso_id = C.id and CD.disciplina_id = D.id) as carga
      from curso C, local_curso LC where LC.id = local_curso_id and LC.curso_id = C.id)  )  * (SEC_TO_TIME( SUM( TIME_TO_SEC( `horas` ) ) )),2) as valor_pagar,
      
      (SEC_TO_TIME( SUM( TIME_TO_SEC( `horas` ) ) )) as horas_completas, 

      (select sum(vale)*2  from diario_classe_aluno where diario_classe_id = id) as vales,
      (select valor_vale from local_curso where local_curso_id = id) as valor_vale,
      
      (select sum(vale)*2  from diario_classe_aluno where diario_classe_id = id)*(select valor_vale from local_curso where local_curso_id = id) as gasto_vale
 

FROM diario_classe 
where  data_aula >= "'.$dataini.'" 
and data_aula <= "'.$datafinal.'" 
and local_curso_id 
in (select id from local_curso where empresa_curso_id = "'.(int)$_POST['empresa'].'")
group by local_curso_id

';

$_SESSION['SQL'] = $sql;

$rs = Empresa::staticGet(11)->_getConnection()->executeSQL($sql)




?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../intranet.css" rel="stylesheet" type="text/css">
<script src="../scripts/gastosPesquisa.js"></script>
      <p><span class="titulo">Controle Financeiro</span><br>
</p>
      <table width="100%" cellpadding="3" cellspacing="1" class="lista">
        <tr class="listaClara">
          <td colspan="13"><strong>Empresa: </strong> <?php echo Empresa::staticGet((int)$_POST['empresa'])->fantasia;?></td>
        </tr>
        <tr class="listaClara">
          <td colspan="13"><strong>Período: <?php echo $_POST['data_inicio']?> a <?php echo $_POST['data_fim']?></strong></td>
        </tr>
       
        <tr class="listaClara">
          <td width="308"><strong>Curso</strong></td>
          <td width="320"><strong>Local</strong></td>
          <td width="78"><strong>Início</strong></td>
          <td width="50"><strong>Período</strong></td>
          <td width="78"><strong>Valor  Curso</strong></td>
          <td width="45"><strong>Carga </strong></td>
          <td width="74" align="right"><strong>Valor hora</strong></td>
          <td width="71" align="right"><strong>Aulas min.</strong></td>
          <td width="95" align="right"><strong>Horas a pagar</strong></td>
         
          
        </tr>
         <?php 
		    $cont = 0;
			$totalGeralCuros = 0;
			$totalGeralCarga = 0;
			$totalGeralHorasMinistradas = 0;
			$totalGeralHorasPagar = 0;
			$totalGeralVale = 0;
			$totalGastoVale = 0;
			
		    while($row = mysql_fetch_array($rs)){ 
			 if ($cont === 0) {
                        $linha = "listaClara";
                        $cont = 1;
                    } else {
                        $linha = "listaEscura";
                        $cont = 0;
                    }
					
			$totalGeralCuros += $row['valor'];
		    $totalGeralCarga += $row['carga'];
			$totalGeralHorasMinistradas += $row['horas_completas'];
			$totalGeralHorasPagar  += converterHoraValor($row['horas_completas'],$row['valor_hora']);
			$totalGastoVale += $row['gasto_vale'];
		 ?>
        <tr class="<?php echo $linha?>">
          <td><?php echo $row['curso']?></td>
          <td><?php echo $row['local']?></td>
          <td><?php echo data_br($row['inicio'])?></td>
          <td><?php echo periodoCurso($row['periodo'])?></td>
          <td>R$ <?php echo number_format($row['valor'],2,',','.')?></td>
          <td><?php echo $row['carga']?></td>
          <td align="right">R$ <?php echo number_format($row['valor_hora'],2,',','.')?></td>
          <td align="right">
              <a href="diarios.php?agenda=<?php echo $row['id']?>" class="cssHistorico"> <?php echo extraiSegundo($row['horas_completas'])?> </a>hs
          </td>
          <td align="right">R$ <?php echo number_format(converterHoraValor($row['horas_completas'],$row['valor_hora']),2,',','.')?></td>
         
         
        </tr>
       <?php } ?> 
       
       
       <tr class="<?php echo $linha?>" >
          <td align="right"><strong>Totais </strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><strong>R$ <?php echo number_format($totalGeralCuros,2,',','.')?></strong></td>
          <td><strong><?php echo $totalGeralCarga?></strong></td>
          <td align="right"></td>
          <td align="right"><strong><?php echo $totalGeralHorasMinistradas?> hs</strong></td>
          <td align="right"><strong>R$ <?php echo  number_format($totalGeralHorasPagar,2,',','.')?></strong></td>
       
          
        </tr>
       
      </table>
      <p align="center">
         <input type="button" name="imprimir" id="imprimir" value="Imprimir" onclick="print();" /> 
        <input type="button" name="enviar" id="enviar2" value="Exportar" onclick="self.location='xls_gastos.php'" /> 
        <input type="button" name="enviar2" id="enviar" value="Voltar" onclick="self.location='principal.php?acao=gastos'" />
</p>
