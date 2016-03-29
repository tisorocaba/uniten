<?php
require_once 'util/config.php';
require_once 'dao/agendaCursoDao.php';
Security::admSecurity();



if(!empty($_REQUEST['agenda'])){
	$_SESSION['CODAGENDA'] = $_REQUEST['agenda'];
}

$agendaDao = new AgendaCursoDao();
$alunos = $agendaDao->listaAlunoAgendaFinal($_SESSION['CODAGENDA']);

$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);


$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'relatorio_final', 'Acessou: Relatorio Final de Curso', $_REQUEST, '', 'Agenda: ' . $_SESSION['CODAGENDA']);



?>

<link href="intranet.css" rel="stylesheet" type="text/css">
<script src="js/jquery-1.5.min.js" type="text/javascript"></script>
<script src="scripts/cadidatos.js" type="text/javascript"></script>
      <p><span class="titulo">Relatório Final de Curso</span><br />
  <br>
Curso: <?php echo $agenda->curso->nome?><br />
Data: <?php echo data_br($agenda->dataInicio)?><br />
      </p>
      <table width="100%" cellpadding="3" cellspacing="1" class="lista">
        <tr class="listaClara">
          <td colspan="9" align="right"><a href="xls_certificado.php">Exportar para Certificado</a></td>
        </tr>
        <tr class="listaClara">
          <td ><strong>Nome</strong></td>
          <td width="88" align="center"><strong>VT</strong></td>
          <td align="center"><strong>Apontamentos</strong></td>
          <td align="center"><strong>Faltas</strong></td>
          <td align="center"><strong>Percentual de Frequência(%)</strong></td>
          <td align="center"><strong>Nota</strong></td>
          <td width="67" align="center"><strong>Status</strong></td>
        </tr>
        <?php 
		
		  foreach($alunos as $aluno) { 
		
		
		?>
        <tr class="listaClara">
          <td width="344" style="text-transform: uppercase"><a href="aluno.php?cod=<?php echo $aluno->aluno_id?>"><?php echo $aluno->aluno?></a></td>
          <td align="center"><?php echo ($aluno->passes)?></td>
          <td width="141" align="center"><?php echo $aluno->apontamentos?></td>
          <td width="141" align="center"><?php echo $aluno->faltas?></td>
          <td width="267" align="center"><?php 
        
         /* if((float)$aluno->percentual>0){
              echo number_format(100-(float)$aluno->percentual,2);
          }elseif((int)$aluno->status===2){
              echo "100";
          }else{
              echo number_format((float)$aluno->percentual,2);
          }*/
          if($aluno->apontamentos=='0'){
              echo "0";
          }else{
               echo number_format((float)$aluno->percentual,2); 
          }
          
          ?></td>
          <td width="100" align="center">
          
              <?php echo number_format($aluno->nota,2)?>                  
         
          </td>
       
          <td align="center"><?php 
		    
			if((int)$aluno->status===2){
				echo '<font color="#0000FF">'.statusAluno($aluno->status).'</font>';
			}else{
				 echo '<font color="#FF0000">'.statusAluno($aluno->status).'</font>';
			}
			
			
			
			?></td>
        </tr>
        <?php } ?>
      </table>
      <p>&nbsp;</p>