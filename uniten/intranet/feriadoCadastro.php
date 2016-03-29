<?php
require_once 'util/config.php';
Security::admSecurity();
if(!empty($_GET['id']))
{
   $obj = new Feriado();
   $obj->get($_GET['id']);
   $_POST = $obj->toArray();
   $_POST['data'] = data_br($_POST['data']);
   $lbBotao = "Alterar";
   logDao::gravaLog($user->login, 'feriadoCadastro', 'Acessou: cadastro de feriado(alterar)', $_REQUEST, '', 'Feriado: ' . $_GET['id']);
}else{
   $lbBotao = "Gravar";
   logDao::gravaLog($user->login, 'feriadoCadastro', 'Acessou: cadastro de feriado(novo)', $_REQUEST);
}

?>

<p><span class="titulo">Feriado &raquo; Cadastro</span><br>
<hr />
</p>
<link href="css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">
<link href="js/css/jquery-ui.css" rel="stylesheet" type="text/css">
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.ui.core.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.ui.widget.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.ui.datepicker.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="scripts/feriadoCadastro.js"></script>


<form name="form1" id="form1" method="post" action="feriadoLogic.php">
 <input type="hidden" name="id" value="<?php echo @$_POST['id']?>"  />
<table width="100%" cellpadding="3" cellspacing="1">
  <tr>
          <td width="17%" valign="top">Título do Feriado</td>
      <td width="83%"><input name="titulo" type="text" id="titulo" size="80" value="<?php echo @$_POST['titulo']?>" maxlength="150" class="validate[required]" />
      *</td>
    </tr>
        <tr>
          <td valign="top">Data:</td>
          <td><input type="text" name="data" value="<?php echo @$_POST['data']?>" id="data" size="12"  maxlength="12" class="validate[required]" />
          *</td>
        </tr>
        <tr>
          <td valign="top">Comentário:</td>
          <td><textarea name="comentario" id="comentario"    cols="78" rows="2" ><?php echo @$_POST['comentario']?></textarea></td>
        </tr>
       
        <tr>
          <td valign="top">&nbsp;</td>
          <td align="left">* campos obrigatórios</td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td align="left">

               <input type="hidden" name="acao" value="gravar">
           <input type="submit" name="btGravar" id="btGravar" value="<?php echo $lbBotao?>">
           <input type="button" name="enviar2" id="" value="Voltar" onClick="self.location='principal.php?acao=feriados'"></td>
       


          </td>
        </tr>
      </table>
</form>
