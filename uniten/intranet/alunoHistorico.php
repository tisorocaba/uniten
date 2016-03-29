<?php
require_once 'util/config.php';
require_once 'dao/agendaCursoDao.php';
Security::admSecurity();
$aluno = Aluno::staticGet($_REQUEST['cod']);

$agendaDao = new AgendaCursoDao();
$cursos = $agendaDao->listaAgendaAluno($aluno->id);
$user = unserialize($_SESSION['USER']);

logDao::gravaLog($user->login, 'alunoHistorico', 'Acessou: Historico do aluno', $_REQUEST,'','Aluno: '.$_REQUEST['cod']);


?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="intranet.css" rel="stylesheet" type="text/css">
<script src="js/jquery-1.5.min.js" type="text/javascript"></script>
<script src="scripts/cadidatos.js" type="text/javascript"></script>
<p><span class="titulo">Alunos</span><br />
  <br>
        ALUNO: <?php echo $aluno->nome?><br />
        CPF: <?php echo $aluno->cpf?><br />
        RG: <?php echo $aluno->rg?><br />
</p>
      <table width="100%" cellpadding="3" cellspacing="1" class="lista">
        <tr class="listaClara">
         
          <td ><strong>Cod.</strong></td>
          <td ><strong>Curso</strong></td>
          <td><strong>Data Matricula</strong></td>
          <td><strong>Funcionário</strong></td>
          <td><strong>Início</strong></td>
          <td><strong>Termino</strong></td>
          <td><strong>Nota de Classificacao</strong></td>
          <td><strong>Nota do Curso</strong></td>
          <td><strong>Status</strong></td>
          <td width="117" align="center"><strong>Declaração</strong></td>
        </tr>
        <?php 
		
		  foreach($cursos as $curso) {
		
		
		?>
        <tr class="listaClara">
          <td width="29"><?php echo $curso->agenda?></td>
          <td width="232"><a href="agenda.php?cod=<?php echo $curso->agenda?>"><?php echo $curso->curso?></a></td>
          <td width="167"><?php echo $curso->matricula?></td>
          <td width="82"><?php echo $curso->usuario?></td>
          <td width="62"><?php echo $curso->inicio?></td>
          <td width="71"><?php echo $curso->termino?></td>
          <td width="110"><?php echo $curso->nota_prova?></td>
          <td width="63"><?php echo $curso->nota?></td>
          <td width="73">
		    <?php echo $curso->situacao?>
            <?php
			  if((int)$curso->status===4){ 
			    if(!empty($curso->desistencia)){
                            
                               echo "(<a href='desistenciaDetalhe.php?cod=".$curso->desistencia."'>justificada</a>)";
                            }else{
                               echo "<br>(não justificada)"; 
                            }
			  }
			  
			  ?>
            </td>
          <td align="center">
           <?php if($curso->status==1 || $curso->status==2){ ?>
             <a href="pdf_declaracao.php?agenda=<?php echo $curso->agenda?>&aluno=<?php echo $curso->aluno?>&status=<?php echo $curso->status;?>" target="_new">declaração</a>
             
             <?php if($curso->status==2){ ?>
             <!-- | <a href="pdf_certificado.php?agenda=<?php echo $curso->agenda?>&aluno=<?php echo $curso->aluno?>&status=<?php echo $curso->status;?>" target="_new">certificado - Frente</a> -->
           <?php } ?> 
           <?php } ?>  
             
           
          </td>
        </tr>
        <?php } ?>
      </table>
      <p><a href="javascript:;" onclick="print();">imprimir</a>
       </p>