<?php
require_once 'util/config.php';
Security::admSecurity();
if(!empty($_GET['id']))
{
   $obj = new Usuario();
   $obj->get($_GET['id']);
   $_POST = $obj->toArray();
   $lbBotao = "Alterar";
}else{
   die('Acesso negado');
}
logDao::gravaLog($user->login, 'senhaUsuarioCadastro','Acessou: alteracao de senha do usuario', '',$_REQUEST,'','Usuario: '.$obj->nome);

?>


<p><span class="titulo">Alterar &raquo; Senha Usúario<br>
<link href="css/validationEngine.jquery.css" rel="stylesheet" type="text/css">
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/senhaCadastro.js"></script>
</p>
<form name="form1" method="post" id="form1" action="usuarioLogic.php">
	<input type="hidden" name="id" value="<?php echo @$obj->id?>"  />
    <input type="hidden" name="empresa" value="<?php echo @$obj->empresa->id?>"  />
    <table width="100%" cellpadding="3" cellspacing="1">
        <tr>
          <td width="20%" valign="top"> Usuário: </td>
          <td width="80%" align="left"><?php echo @$obj->nome?></td>
        </tr>
         <tr>
          <td width="20%" valign="top"> Login: </td>
          <td width="80%" align="left"><?php echo @$obj->login?></td>
        </tr>
        <tr>
          <td valign="top">Senha: </td>
          <td align="left">
              <input name="senha" type="password" id="senha" size="20" maxlength="20" class="validate[required,minSize[6]]" />*
          </td>
        </tr>
        <tr>
          <td valign="top">Confirma Senha: </td>
          <td align="left">
            <input name="csenha" type="password" id="csenha" size="20" maxlength="20" class="validate[required,equals[senha]] "  />*
          </td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td align="left">
          
           <input type="hidden" name="acao" value="alterarsenhauser">
           <input type="submit" name="btGravar" id="btGravar" value="alterar"></td>
        </tr>
      </table>
</form>
