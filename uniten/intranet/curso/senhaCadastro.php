<?php
require_once '../util/config.php';
Security::cursoSecurity();
$projeto = new Projeto();
$projeto->alias('p')->order('p.nome ASC')->find();

if(!empty($_GET['id']))
{
   $obj = new Local();
   $obj->get($_GET['id']);
   $_POST = $obj->toArray();
   $lbBotao = "Alterar";
}else{
   $lbBotao = "Gravar";
}
logDao::gravaLog($user->login, 'senhaCadastro', 'Acessou: alteracao de senha');
?>


<p><span class="titulo">Alterar &raquo; Senha</span><br>
<link href="../css/validationEngine.jquery.css" rel="stylesheet" type="text/css">
<script src="../js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript"  src="scripts/senhaCadastro.js"></script>

<form name="form1" method="post" id="form1" action="usuarioLogic.php">
	<input type="hidden" name="id" value="<?php echo @$user->id?>"  />
    <input type="hidden" name="empresa" value="<?php echo @$user->empresa->id?>"  />
    <table width="100%" cellpadding="3" cellspacing="1">
        <tr>
          <td width="20%" valign="top"> Usuário: </td>
          <td width="80%" align="left"><?php echo @$user->nome?></td>
        </tr>
         <tr>
          <td width="20%" valign="top"> Login: </td>
          <td width="80%" align="left"><?php echo @$user->login?></td>
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
          
           <input type="hidden" name="acao" value="alterarsenha">
           <input type="submit" name="btGravar" id="btGravar" value="alterar"></td>
        </tr>
      </table>
</form>
