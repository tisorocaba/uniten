<?php
require_once '../util/config.php';
require_once '../dao/agendaCursoDao.php';
Security::provaSecurity();

if(!empty($_REQUEST['agenda'])){
    $_SESSION['CODAGENDA'] = $_REQUEST['agenda'];
}
$agendaDao = new AgendaCursoDao();
$alunos = $agendaDao->listaCandidatoAgenda($_SESSION['CODAGENDA'],@$_REQUEST['aluno']);

$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);
$user = unserialize($_SESSION['USER']);

logDao::gravaLog($user->login, 'candidados', 'Acessou: lista de candidados ', $_REQUEST,'','Agenda: '.$_SESSION['CODAGENDA']);


?>

<link href="../intranet.css" rel="stylesheet" type="text/css">
<script src="../js/jquery-1.5.min.js" type="text/javascript"></script>
<script src="../scripts/cadidatos.js" type="text/javascript"></script>
      <p><span class="titulo">Candidatos</span><br />
  <br>
Curso: <?php echo $agenda->curso->nome?><br />
Data prova: <?php echo data_br($agenda->provaData)?><br />
</p>
      <table width="100%" cellpadding="3" cellspacing="1" class="lista">
        <tr class="listaClara">
          <td colspan="8"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="41%">Aluno:
                <input name="agenda" type="hidden" id="agenda" value="<?php echo @$_SESSION['CODAGENDA']?>" />
                <label for="textfield"></label>
                <input type="text" name="aluno" id="aluno" value="<?php echo @$_REQUEST['aluno']?>" />
              <input type="submit" name="button" id="button" value="Pesquisar" onclick="self.location='candidatos.php?agenda=<?php echo $_SESSION['CODAGENDA']?>&amp;aluno='+document.getElementById('aluno').value" /></td>
              <td width="43%" align="center">Candidatos: <?php echo count($alunos)?></td>
              <td width="16%" align="right"><a href="xls_candidatos.php?agenda=<?php echo $_SESSION['CODAGENDA']?>" target="_blank">Exportar para Excel</a></td>
            </tr>
          </table></td>
        </tr>
        <tr class="listaClara">
          <td><strong>Protocolo</strong></td>
          <td><strong>CPF</strong></td>
          <td><strong>Nome</strong></td>
         <!--  <td><strong>Telefone</strong></td> -->
         <!--  <td><strong>Bairro</strong></td>-->
          <td><strong>Classificação</strong></td>
          <td><strong>Nota</strong></td>
          <td width="150" align="center">&nbsp;</td>
        </tr>
        <?php 
		
		  foreach($alunos as $aluno) { 
		
		
		?>
        <tr class="listaClara">
          <td width="142"><?php echo $_SESSION['CODAGENDA']?>-<?php echo $aluno->id?></td>
          <td width="113"><?php echo $aluno->cpf?></td>
          <td width="493" style="text-transform:uppercase"><a href="aluno.php?cod=<?php echo $aluno->id?>"><?php echo $aluno->aluno?></a></td>
         <!-- <td width="137"><?php echo $aluno->telefone?></td> -->
         <!--  <td width="190"><?php echo $aluno->bairro?></td>-->
          <td width="127">
		  <?php if($aluno->classificacao!=0){ ?>
		  		<?php echo $aluno->classificacao?>º
          <?php } ?>
          </td>
          <td width="103"><?php 
		    if($aluno->nota_prova!='' && $aluno->nota_prova>0){
			  echo number_format($aluno->nota_prova,2,',','.');
			}
			?></td>
          <td align="center">
            <?php if($aluno->classificacao==0){ ?>
            		<a href="classificacaoCadastro.php?aluno=<?php echo $aluno->id?>">classificar</a>
            <?php }else{ ?>
            		<a href="classificacaoLogic.php?aluno=<?php echo $aluno->id?>&acao=desclassificar">reclassificar</a>
            <?php } ?>
            </td>
        </tr>
        <?php } ?>
      </table>
      <p>&nbsp;</p>