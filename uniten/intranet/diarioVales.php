<?php
require_once 'util/config.php';
require_once 'dao/diarioClasseDao.php';
Security::admSecurity();

$diario = DiarioClasse::staticGet($_REQUEST['id']);


$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);

$diarioDao = new DiarioClasseDao();
?>

<link href="intranet.css" rel="stylesheet" type="text/css">
<script src="js/jquery-1.5.min.js" type="text/javascript"></script>
<script src="scripts/agendamonitores.js" type="text/javascript"></script>
<p><span class="titulo">Vale Transporte</span><br />
    <br>
    Curso: <?php echo $agenda->curso->nome ?><br />
    Local:  <?php echo $agenda->local->local ?>  <br /> 
	Data: <?php echo data_br($diario->data);?><br />
        Monitor: <?php echo Professor::staticGet($diario->professor)->nome;?><br />
</p>

    <table width="100%" cellpadding="1" cellspacing="1" >
        <tr >
            <td colspan="2"><strong>Aluno</strong><strong>s que receberam vale-transporte</strong></td>
        </tr>
         <tr >
              <td colspan="2"><hr /></td>
            </tr>
        <?php      foreach ($diarioDao->listaAlunosUtilizamPasse($_REQUEST['id']) as $aluno) {  ?>
           
            <tr >
                <td width="100%"><?php echo $aluno->nome ?></td>
            
            </tr>
        <?php } ?>
    </table>
    <p align="center">
      <input name="alterar" value="voltar" type="button" onclick="history.go(-1)" />
    <input name="imprimir" value="imprimir" type="button" onclick="print();" /></p>
