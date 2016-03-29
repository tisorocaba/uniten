<?php
require_once 'util/config.php';
require_once 'dao/agendaCursoDao.php';
Security::admSecurity();
if(!empty($_REQUEST['agenda'])){
	$_SESSION['CODAGENDA'] = $_REQUEST['agenda'];
}


$agendaDao = new AgendaCursoDao();
$alunos = $agendaDao->listaAlunoAprovadosAgenda($_SESSION['CODAGENDA']);



$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);


$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'poscurso', 'Acessou: lista pos-curso', $_REQUEST, '', 'Agenda: ' . $_SESSION['CODAGENDA']);



?>

<link href="intranet.css" rel="stylesheet" type="text/css">
<script src="js/jquery-1.5.min.js" type="text/javascript"></script>
<script src="scripts/cadidatos.js" type="text/javascript"></script>
      <p><span class="titulo">Pós - Curso</span><br />
  <br>
Curso: <?php echo $agenda->curso->nome?><br />
Data: <?php echo data_br($agenda->dataInicio)?><br />
</p>
      <table width="100%" cellpadding="3" cellspacing="1" class="lista">
        <tr class="listaClara">
          <td colspan="7"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="74%"><!--Pesquisa:
                <input name="agenda" type="hidden" id="agenda" value="<?php echo @$_REQUEST['agenda']?>" />
                <label for="textfield"></label>
                <input type="text" name="aluno" id="aluno" value="<?php echo @$_REQUEST['aluno']?>" />
              <input type="submit" name="button" id="button" value="Pesquisar" onclick="self.location='candidatos.php?agenda=<?php echo @$_SESSION['CODAGENDA']?>&amp;aluno='+document.getElementById('aluno').value" />--></td>
              <td width="14%" align="center"><a href="relatorios/formPosCurso.php" class="cssAlunos">Relatório Pós-Curso</a></td>
              <td width="12%" align="right"><a href="xls_poscurso.php?agenda=<?php echo @$_SESSION['CODAGENDA']?>" target="_blank">Exportar para Excel</a></td>
            </tr>
          </table></td>
        </tr>
        <tr class="listaClara">
       
          <td><strong>Nome</strong></td>
          <td><strong>Telefone</strong></td>
          <td><strong>Email</strong></td>
         
          <td><strong>Pesquisado</strong></td>
          <td align="center">&nbsp;</td>
        </tr>
        <?php 
		
		  foreach($alunos as $aluno) { 
		
		
		?>
        <tr class="listaClara">
          
          <td width="316"><a href="aluno.php?cod=<?php echo $aluno->id?>" style="text-transform:uppercase"><?php echo $aluno->aluno?></a></td>
          <td width="126"><?php echo $aluno->telefone?></td>
          <td width="384" style="text-transform:uppercase"><?php echo $aluno->email?></td>
         
          <td width="89">
		    
             <?php if($aluno->ausente == 0){ ?>
                  <?php if($aluno->pesquisado == 0 ){ ?>
                   <font color="#FF9900"><strong> Não </strong>   </font>
                   <?php }else{ ?>
                   <font color="#336633"><strong> Sim </strong> </font>
                   <?php } ?>
             <?php }else{ ?>
                  <font color="#990033"><strong>  Ausente </strong> </font>
             <?php } ?>
          </td>
          <td align="center">
          <a href="posCursoCadastro.php?agenda=<?php echo $_SESSION['CODAGENDA']?>&aluno=<?php echo $aluno->id?>">
              <? if(empty ($aluno->situacao)){ ?>
                 incluir
              <?php }else{ ?>
                 alterar
              <?php } ?>
          </a>   
          </td>
        </tr>
        <?php } ?>
      </table>
      <p>&nbsp;</p>