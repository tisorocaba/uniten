<?php
require_once '../util/config.php';
Security::uniteempregaSecurity();

require_once 'dao/processoDao.php';
$processoDao = new ProcessoDao();

if(empty($_REQUEST['cod'])){
    die('ERRO: Código inválido!');
}

$aProcesso = $processoDao->recuperaProcesso($processoDao->escape($_REQUEST['cod']));


$aluno = new Aluno();
$aluno->get($aProcesso['aluno']);

 
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
            <p><strong class="titulo">Aluno &raquo; <?php echo faseProcesso($_SESSION['STATUSENTRE']); ?></strong></p>
        </td>
    </tr>
    <tr>
        <td>
        <form id="form1" name="form1" method="post" action="processoLogic.php">
          
          <input type="hidden" name="aluno" value="<?php echo $aluno->escape($aProcesso['aluno'])?>" />
          <input type="hidden" name="id" value="<?php echo $aluno->escape($_REQUEST['cod'])?>" />
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
              <td>Data da alteração:</td>
              <td><input type="text" name="data" id="data" maxlength="10" size="10" class="validate[required]"/>
                *</td>
            </tr>
           
           
           <?php if($_SESSION['STATUSENTRE']==1){ ?>
            <tr>
              <td>Setor de trabalho:</td>
              <td><input type="text" name="setor" id="setor" maxlength="30" size="30"  /></td>
            </tr>
            <tr>
              <td>Alterar para:</td>
              <td>
                 <input type="radio" name="status" id="radio2" value="2" class="validate[required]" />
                  em  experiência 
                 <input type="radio" name="status" id="radio3" value="3" class="validate[required]" />
                 efetivar
              </td>
            </tr>
            <?php }elseif($_SESSION['STATUSENTRE']==2){ ?>
            <tr>
              <td>Alterar para:</td>
              <td>
                 <input type="radio" name="status" id="radio3" value="3" class="validate[required]" />
                  efetivar
                 <input type="radio" name="status" id="radio4" value="4" class="validate[required]" />
                 desligar
              </td>
            </tr>
            <?php }else{ ?>
             <tr>
              <td>Motivo do desligamento:</td>
              <td><label for="textarea"></label>
              <textarea name="motivo" id="motivo" cols="45" class="validate[required]" rows="5"></textarea>*</td>
            </tr>
            <tr>
              <td>Alterar para:</td>
              <td>
                
                 <input type="radio" name="status" id="radio2" value="4" checked="checked" />
                 desligar
              </td>
            </tr>
            <?php } ?>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;
                <input type="submit" name="button" id="button" value="alterar" />
                &nbsp;&nbsp;&nbsp;
                <input type="button" name="button2" id="button2" value="voltar" onclick="self.location='principal.php?acao=processos'" /></td>
            </tr>
          </table>
        </form></td>
    </tr>
</table>

<p>&nbsp;</p>
