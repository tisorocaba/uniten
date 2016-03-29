<?php 
require_once '../util/config.php';
Security::cursoSecurity();
$agenda = new AgendaCurso();
if(!empty($_REQUEST['agenda'])){
  $_SESSION['CODAGENDA'] = $agenda->escape($_REQUEST['agenda']);	
}
$agenda->get($_SESSION['CODAGENDA']);

$user = unserialize($_SESSION['USER']);



$diarios = new DiarioClasse();
if((int)$user->tipoLogin == 2){
    $diarios->alias('d')->where('d.agenda=? and d.professor = ? and data_aula <= CURRENT_DATE',$_SESSION['CODAGENDA'],$user->professor)->order('data DESC')->find();
}else{
    $diarios->alias('d')->where('d.agenda=? and data_aula <= CURRENT_DATE',$_SESSION['CODAGENDA'])->order('data DESC')->find();
}


logDao::gravaLog($user->login, 'diarios', 'Acessou: diarios de classe',$_REQUEST,'','Agenda: '.$_SESSION['CODAGENDA']);

?>
<link href="../intranet.css" rel="stylesheet" type="text/css">
      <p><span class="titulo">Relatórios de Classes :: Diário de Classe</span><br></p>
      <table width="100%" cellpadding="3" cellspacing="1" class="lista">
        <tr class="listaClara">
          <td colspan="4">Curso: <?php echo $agenda->curso->nome?>
          <br />
          Data de início: <?php echo data_br($agenda->dataInicio)?>
          <br>
          Local: <?php echo $agenda->local->local?>
          </td>
          <td width="244" colspan="3" align="right">
          <?php if((int)$user->tipoLogin == 0){ ?>
          <a href="redirecionador.php">INCLUIR DIÁRIO</a>
          <?php } ?>
          </td>
        </tr>
        <tr class="listaClara">
          <td><strong>Cód.</strong></td>
          <td><strong>Data</strong></td>
          <td><strong>Disciplina</strong></td>
          <td><strong>Horas</strong></td>
          <td colspan="2" align="center"></td>
        </tr>
        <?php
            $totalMin = 0;
            while ($diarios->fetch()){
            $totalMin += retornaMinutos($diarios->horas);
            
         ?>

        <tr class="listaClara">
          <td width="50"><?php echo $diarios->id?></td>
          <td width="60"><?php echo data_br($diarios->data)?></td>
          <td width="653"><?php echo Disciplina::staticGet($diarios->disciplina)->nome?></td>
          <td width="140"><?php echo $diarios->horas?></td>
          <td colspan="4" align="center">
              <a href="principal.php?acao=diarioVisualizar&id=<?php echo $diarios->id?>">
                  <img src="../imagens/icon_view.png" alt="" width="24" height="24" hspace="5" border="0" />
              </a>
              &nbsp;&nbsp;&nbsp;
              <a href="redirecionador.php?id=<?php echo $diarios->id?>">
                   <?php if((int)$user->tipoLogin == 2){ ?>
                  <img src="../imagens/icon_editar.gif" width="17" height="22" hspace="5" border="0" />
                  <?php } ?>
             </a>
          </td>
        </tr>
       
        <?php } ?>
         <tr class="listaClara">
          <td>&nbsp;</td>
          <td >&nbsp;</td>
          <td align="right">Total:</td>
          <td width="140"><?php echo calculaHoras($totalMin);//$totalMin / 60 // ?></td>
          <td align="right">&nbsp;</td>
        </tr>
      </table>
      <p>&nbsp;</p>