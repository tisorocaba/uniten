<?php
require_once '../util/config.php';
Security::uniteempregaSecurity();
$aluno = new Aluno();
$aluno->get($aluno->escape($_REQUEST['cod']));

 
 //logDao::gravaLog($user->id, 'alunoFicha', 'Ficha do Aluno', $_REQUEST);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../intranet.css" rel="stylesheet" type="text/css">
<link href="../css/validationEngine.jquery.css" rel="stylesheet" type="text/css">

<script src="../js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>

<script src="scripts/entrevistaForm.js"></script>
<table width="100%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Aluno &raquo; Entrevista</strong></p>
        </td>
    </tr>
    <tr>
        <td>
        <form id="form1" name="form1" method="post" action="processoLogic.php">
          <input type="hidden" name="status" value="1" />
          <input type="hidden" name="aluno" value="<?php echo $aluno->escape($_REQUEST['cod'])?>" />
          <table width="100%" border="0" cellspacing="3" cellpadding="1">
            <tr>
              <td colspan="2"><strong>Aluno</strong></td>
            </tr>
            <tr>
              <td colspan="2"><hr /></td>
            </tr>
            <tr>
              <td width="20%">Nome:</td>
              <td width="80%"><?php echo $aluno->nome;?></td>
            </tr>
            <?php if(!empty($aluno->email)){ ?>
            <tr>
              <td>Email:</td>
              <td><?php echo $aluno->email?></td>
            </tr>
            <?php } ?>
            <tr>
              <td>Telefone:</td>
              <td><?php echo $aluno->ddd?>-<?php echo $aluno->telefone?></td>
            </tr>
            <tr>
              <td>Data da entrevista:</td>
              <td><input type="text" name="data" id="data" maxlength="10" size="10" class="validate[required]"/></td>
            </tr>
            <tr>
              <td>Horário da entrevista:</td>
              <td><input type="text" name="hora" id="hora" maxlength="5" size="5" class="validate[required]" /></td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;
                <input type="submit" name="button" id="button" value="agendar" />
                &nbsp;&nbsp;&nbsp;
                <input type="button" name="button2" id="button2" value="voltar" onclick="self.location='principal.php?acao=resultadoPesquisa'" /></td>
            </tr>
          </table>
        </form></td>
    </tr>
</table>

<p>&nbsp;</p>
