<?php
require_once 'util/config.php';
Security::admSecurity();
if(!empty($_GET['id']))
{
   $obj = new Segmento();
   $obj->get($_GET['id']);
   $_POST = $obj->toArray();
   $lbBotao = "Alterar";
   logDao::gravaLog($user->login, 'segmentoCadastro', 'Acessou: cadastro de segmento(alterar)', $_REQUEST, '', 'Segmento: ' . $_GET['id']);
}else{
   $lbBotao = "Gravar";
   logDao::gravaLog($user->login, 'segmentoCadastro', 'Acessou: cadastro de segmento(novo)', $_REQUEST);
}

?>
<p><span class="titulo">Segmento &raquo; Cadastro</span><br> 
</p>
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/segmentoCadastro.js"></script>


<form name="form1" method="post" action="segmentoLogic.php" id="form" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo @$_POST['id']?>"  />
<table width="100%" cellpadding="3" cellspacing="1">
        <tr>
          <td valign="top">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="17%" valign="top">Segmento:*</td>
          <td width="83%">
              <input name="nome" type="text" id="nome" size="50" maxlength="85" value="<?php echo @$_POST['nome']?>"></td>
        </tr>
        <?php if(!empty($_POST['imagem'])) { ?>
        <?php } ?>
        <tr>
          <td valign="top">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td align="left">
              <input type="hidden" name="acao" value="gravar">
           <input type="submit" name="btGravar" id="btGravar" value="<?php echo $lbBotao?>">
          <input type="button" name="enviar" id="" value="Voltar" onClick="self.location='principal.php?acao=segmentos'"></td>
        </tr>
      </table>
</form>
