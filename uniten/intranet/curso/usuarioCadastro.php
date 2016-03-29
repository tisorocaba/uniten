<?php
require_once '../util/config.php';
Security::cursoSecurity();
$menus = array();
if(!empty($_GET['id']))
{
   $obj = new Usuario();
   $obj->get($obj->escape($_GET['id']));
   if($obj->empresa->id != $user->empresa->id){
                        msg('ERRO: Açõe não permitida!');
                        gotox("principal.php?acao=usuarios");
   }
   $_POST = $obj->toArray();
   $lbBotao = "Alterar";
   $i=0;
   foreach ($obj->getLink('menus') as $menu) {
       $menus[$i]= $menu->id;
       $i++;
   }
}else{
   $lbBotao = "Gravar";
}
logDao::gravaLog($user->login, 'Cadastro de Usuario', '',$_REQUEST);

?>
<link href="../css/validationEngine.jquery.css" rel="stylesheet" type="text/css">
<script src="../js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/usuarioCadastro.js"></script>
<p><span class="titulo">Usuário &raquo; Cadastro</span><br>
</p>

<form name="form1" id="form1" method="post" action="usuarioLogic.php">
<input name="empresa" type="hidden" id="empresa" value="<?php echo $user->empresa->id?>" />
<input name="id" type="hidden" id="id" value="<?php echo @$_POST['id']?>" />
<table width="100%" cellpadding="3" cellspacing="1">
 
  <tr>
    <td width="11%" valign="top"  >Nome:</td>
    <td width="89%"><input name="nome" type="text" id="nome" value="<?php echo @$_POST['nome']?>" class="validate[required]"size="50" maxlength="85" />
      *</td>
  </tr>
  <tr>
    <td valign="top">Email: </td>
    <td align="left"><input name="email" type="text" id="email" value="<?php echo @$_POST['email']?>"  size="50" class="validate[required,custom[email]] " maxlength="110" />
      *</td>
  </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr id="linhaNivel-1" style="display:none">
          <td colspan="2" valign="top">&nbsp;</td>
        </tr>
        
        
         <tr id="linhaNivel-2" style="display:none">
          <td colspan="2" valign="top"><table width="544" border="0">
            <tr>
              <td colspan="4" bgcolor="#CCCCCC" class="blackPopup" align="center">Nível de acesso </td>
            </tr>
            <tr>
              <td width="27%"><input name="menu" type="checkbox" class="validate[minCheckbox[1]]" id="menu22" value="7" <?php if(in_array("7", $menus)) echo 'checked';?>/>
                 Professores</td>
              <td width="32%"><input name="menu2" type="checkbox" class="validate[minCheckbox[1]]" id="menu23" value="6" <?php if(in_array("6", $menus)) echo 'checked';?>/>
                Relatório de Classes</td>
              <td width="22%"><input name="menu[]" type="checkbox" class="validate[minCheckbox[1]]" id="menu24" value="16" <?php if(in_array("16", $menus)) echo 'checked';?> />
                    Usuários</td>
              <td width="19%">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        
        
        <tr id="linhaNivel-3" style="display:none">
          <td colspan="2" valign="top">&nbsp;</td>
        </tr>
        
        
        <tr>
          <td valign="top">&nbsp;</td>
          <td align="left">
          <input type="hidden" name="acao" value="gravar">
          <input type="submit" name="enviar" id="enviar" value="Gravar">
          <input type="button" name="enviar2" id="enviar2" value="Voltar" onClick="history.go(-1)"></td>
        </tr>
      </table>
</form>
