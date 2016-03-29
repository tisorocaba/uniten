<?php
require_once 'util/config.php';
require_once 'dao/agendaCursoDao.php';
Security::admSecurity();



if(!empty($_REQUEST['agenda'])){
	$_SESSION['CODAGENDA'] = $_REQUEST['agenda'];
}

$agendaDao = new AgendaCursoDao();
$alunos = $agendaDao->listaCandidatoAgendaDesclassificados($_SESSION['CODAGENDA'],@$_REQUEST['aluno']);

$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);

$user = unserialize($_SESSION['USER']);

logDao::gravaLog($user->login, 'candidatosDesclassificados', 'Acessou: lista de candidatos desclassificados', $_REQUEST, '', 'Agenda: ' . $_SESSION['CODAGENDA']);


?>

<link href="intranet.css" rel="stylesheet" type="text/css">
<script src="js/jquery-1.5.min.js" type="text/javascript"></script>
<script src="scripts/cadidatos.js" type="text/javascript"></script>
      <p><span class="titulo">Candidatos</span><br />
  <br>
Curso: <?php echo $agenda->curso->nome?><br />
Data: <?php echo data_br($agenda->dataInicio)?><br />
<a href="xls_candidatos_desclassificados.php?agenda=<?php echo $_SESSION['CODAGENDA']?>" target="_blank">Exportar para Excel</a></p>
      <table width="100%" cellpadding="3" cellspacing="1" class="lista">
        <tr class="listaClara">
          <td height="76" colspan="8"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="100%" align="center"><table width="100%" border="0">
                <tr>
                  <td width="23%"><strong>Listar Candidatos:</strong> 
                    <label for="select"></label>
                    <select name="tipoCandidatos" id="tipoCandidatos"  onchange='self.location=this.value'>
                      <option value="candidatos.php">Inscritos</option>
                      <option value="candidatosClassificados.php">Classificados</option>
                      <option value="candidatosDesclassificados.php" selected="selected">Não Compareceram</option>
                  </select></td>
                  <td width="44%">&nbsp;</td>
                  <td width="33%" align="right">Total: <strong>(<?php echo count($alunos)?>)</strong></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td align="center"><strong>Candidatos que não compareceram</strong></td>
            </tr>
          </table></td>
        </tr>
        <tr class="listaClara">
          <td><strong>Protocolo</strong></td>
           <td><strong>Nome</strong></td>
          <td><strong>Telefone</strong></td>
          <td><strong>Email</strong></td>
          <td align="left"><strong>Bairro</strong></td>
         
        </tr>
        <?php 
		
		  foreach($alunos as $aluno) { 
		
		
		?>
        <tr class="listaClara">
          <td width="142" align="left"><?php echo $_SESSION['CODAGENDA'].'-'.$aluno->id?></td>
          <td width="378" align="left" style="text-transform: uppercase"><a href="aluno.php?cod=<?php echo $aluno->id?>"><?php echo $aluno->aluno?></a></td>
          <td width="94" align="left"><?php echo $aluno->telefone?></td>
          <td width="310" align="left" style="text-transform: uppercase"><?php echo $aluno->email?></td>
          <td width="211" align="left"><span style="text-transform: uppercase"><?php echo $aluno->bairro?></span></td>
        
        </tr>
        <?php } ?>
      </table>
      <p>&nbsp;</p>