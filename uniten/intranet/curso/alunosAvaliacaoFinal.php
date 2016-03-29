<?php
require_once '../util/config.php';
require_once '../dao/agendaCursoDao.php';
Security::cursoSecurity();

$agendaDao = new AgendaCursoDao();
if(!empty($_REQUEST['agenda'])){
	$_SESSION['CODAGENDA'] = $_REQUEST['agenda'];
}

$alunos = $agendaDao->listaAlunoAgenda($_SESSION['CODAGENDA']);

$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'diarioVisualizacao', 'Acessou: avaliacao final',$_REQUEST,'', 'Agenda: '.$_SESSION['CODAGENDA']);


?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../intranet.css" rel="stylesheet" type="text/css">
<script src="../js/jquery-1.5.min.js" type="text/javascript"></script>
<script src="scripts/cadidatos.js" type="text/javascript"></script>

      <p><span class="titulo">Avaliação Final</span><br />
  <br>
Curso: <?php echo $agenda->curso->nome?><br />
Data: <?php echo data_br($agenda->dataInicio)?><br />
Alunos: <?php echo count($alunos)?><br />
<a href="xls_alunos_avaliacao_final.php?agenda=<?php echo $_SESSION['CODAGENDA']?>" target="_blank">Exportar para Excel</a></p>
      <table width="100%" cellpadding="3" cellspacing="1" class="lista">
        <tr class="listaClara">
         
          <td><strong>Nome</strong></td>
          <td><strong>Presença</strong></td>
          <td><strong>Nota final</strong></td>
          <td width="124" align="center"><strong>Status</strong></td>
          <td width="170" align="center">&nbsp;</td>
        </tr>
        <?php 
		
		  foreach($alunos as $aluno) { 
		
		
		?>
        <tr class="listaClara">
         
            <td width="634" style="text-transform: uppercase"><a href="aluno.php?cod=<?php echo $aluno->id?>"><?php echo $aluno->aluno?></a></td>
           <td width="50"><?php echo number_format($aluno->percentual,0)?>%</td>
            <td width="110"><?php echo $aluno->nota?></td>
          <td align="center"><?php echo statusAluno($aluno->status)?></td>
          <td align="center">
              <a href="alunoCadastroAvaliacao.php?cod=<?php echo $aluno->id?>">
               <?php if($aluno->status != 4){ ?>   incluir/alterar avaliação <?php } ?>
              </a>
         </td>
        </tr>
        <?php } ?>
      </table>
      <p><a href="javascript:;" onclick="print();">imprimir</a></p>