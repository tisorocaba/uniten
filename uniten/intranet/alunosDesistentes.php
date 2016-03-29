<?php
require_once 'util/config.php';
require_once 'dao/agendaCursoDao.php';
Security::admSecurity();

if(!empty($_REQUEST['agenda'])){
	$_SESSION['CODAGENDA'] = $_REQUEST['agenda'];
}
$agendaDao = new AgendaCursoDao();
$alunos = $agendaDao->listaAlunoInciaram($_SESSION['CODAGENDA']);

$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'alunosDesistentes', 'Acessou: lista de desistencia',$_REQUEST,'','Agenda: '.$_SESSION['CODAGENDA']);


?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="intranet.css" rel="stylesheet" type="text/css">
<script src="js/jquery-1.5.min.js" type="text/javascript"></script>
<script src="scripts/cadidatos.js" type="text/javascript"></script>
      <p><span class="titulo">Alunos :: Desistência</span><br />
  <br>
Curso: <?php echo $agenda->curso->nome?><br />
Data: <?php echo data_br($agenda->dataInicio)?><br />
Alunos: <?php echo count($alunos)?><br />
<a href="xls_alunos.php?agenda=<?php echo $_SESSION['CODAGENDA']?>" target="_blank">Exportar para Excel</a></p>
      <table width="100%" cellpadding="3" cellspacing="1" class="lista">
        <tr class="listaClara">
         
          <td><strong>Nome</strong></td>
          <td><strong>Email</strong></td>
          <td><strong>Telefone</strong></td>
          <td><strong>Status</strong></td>
          <td width="162" align="center">&nbsp;</td>
        </tr>
        <?php 
		
		  foreach($alunos as $aluno) { 
		
		
		?>
        <tr class="listaClara">
         
            <td width="221" style="text-transform: uppercase"><a href="aluno.php?cod=<?php echo $aluno->id?>"><?php echo $aluno->aluno?></a></td>
          <td width="189" style="text-transform: uppercase"><?php echo $aluno->email?></td>
          <td width="187"><?php echo $aluno->telefone?></td>
          <td width="147"><?php echo statusAluno($aluno->status)?></td>
          <td align="center">
              
              <?php if($aluno->status==4){ ?>
               <a href="desistenciaLogic.php?aluno=<?php echo $aluno->id?>&acao=remover">cancelar desistência</a> 
              <?php }else{  ?>
              <a href="desistenciaCadastro.php?aluno=<?php echo $aluno->id?>">Informar desistência</a>
              <?php } ?>
          </td>
        </tr>
        <?php } ?>
      </table>
      <p><a href="javascript:;" onclick="print();">imprimir</a></p>