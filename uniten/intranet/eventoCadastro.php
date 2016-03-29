<?php
require_once 'util/config.php';
Security::admSecurity();
if(!empty($_GET['id']))
{
   $obj = new Galeria();
   $obj->get($_GET['id']);
   $_POST = $obj->toArray();
   $_POST['data'] = data_br($_POST['data']);
   $lbBotao = "Alterar";
   logDao::gravaLog($user->login, 'eventoCadastro', 'Acessou: cadastro de evento(alteracao)', $_REQUEST,'','Evento: '.$_GET['id']);
}else{
   $lbBotao = "Gravar";
   logDao::gravaLog($user->login, 'eventoCadastro', 'Acessou: cadastro de evento(novo)', $_REQUEST);
}

?>

<p><span class="titulo">Eventos &raquo; Cadastro</span><br>
</p>
<link href="css/validationEngine.jquery.css" rel="stylesheet" type="text/css">
<link href="css/datepicker.css" rel="stylesheet" type="text/css">
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/datepicker.js" type="application/javascript"></script>
<script src="js/datepicker-pt-BR.js" type="application/javascript"></script>
<script type="text/javascript" src="scripts/eventoCadastro.js"></script>
<form name="form1" id="form1" method="post" action="eventoLogic.php" enctype="multipart/form-data">
 <input type="hidden" name="id" value="<?php echo @$_POST['id']?>"  />
<table width="100%" cellpadding="3" cellspacing="1">
  <tr>
          <td width="17%" valign="top">Data:</td>
          <td width="83%"><input type="text" name="data" value="<?php echo @$_POST['data']?>" id="data" maxlength="150" class="validate[required]" >*</td>
        </tr>
        <tr>
          <td valign="top">Título do Evento:</td>
          <td><input name="titulo" type="text" id="titulo" size="80" value="<?php echo @$_POST['titulo']?>" maxlength="150" class="validate[required]" >*</td>
        </tr>
        <tr>
          <td valign="top">Foto Destaque:</td>
          <td><input name="foto" type="file" id="foto" size="30"  /></td>
        </tr>
        <?php if(!empty($_POST['foto'])){ ?>
        <tr>
          <td valign="top">&nbsp;</td>
          <td><img alt=""  src="../thumbs.php?img=<?php echo $_POST['foto']?>&amp;w=80&amp;h=80"/></td>
        </tr>
        <?php } ?>
        <tr>
          <td valign="top">Descrição do Evento:</td>
          <td><textarea name="descricao" id="descricao" cols="78" rows="15" ><?php echo @$_POST['descricao']?></textarea>*</td>
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
           <input type="button" name="enviar2" id="" value="Voltar" onClick="self.location='principal.php?acao=eventos'"></td>
       


          </td>
        </tr>
      </table>
</form>
