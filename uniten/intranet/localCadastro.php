<?php
require_once 'util/config.php';
Security::admSecurity();
$projeto = new Projeto();
$projeto->alias('p')->order('p.nome ASC')->where('ativo = 1')->find();


if(!empty($_GET['id']))
{
   $obj = new Local();
   $obj->get($_GET['id']);
   $_POST = $obj->toArray();
   $lbBotao = "Alterar";
   logDao::gravaLog($user->login, 'locailCadastro', 'Acessou: cadastro de local(alteracao) ', $_REQUEST,'','Local: '.$_GET['id']);

}else{
   $lbBotao = "Gravar";
    logDao::gravaLog($user->login, 'locailCadastro', 'Acessou: cadastro de local(novo) ', $_REQUEST);

}


?>


<p><span class="titulo">Local &raquo; Cadastro</span><br>
<link href="css/validationEngine.jquery.css" rel="stylesheet" type="text/css">
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/localCadastro.js"></script>
</p>
<form name="form1" method="post" id="form1" action="localLogic.php">
	<input type="hidden" name="id" value="<?php echo @$_POST['id']?>"  />
    <table width="100%" cellpadding="3" cellspacing="1">
        <tr>
          <td width="20%" valign="top"> Projeto:</td>
          <td width="80%" align="left">
             <select name="projeto" id="projeto">
                <?php echo Lumine_Util::buildOptions($projeto,'id','nome', @$_POST['projeto']); ?>
          	</select>
            </td>
        </tr>
        <tr>
          <td valign="top">Local: </td>
          <td align="left"><input name="local" type="text" id="local" size="50" maxlength="120" class="validate[required]" value="<?php echo @$_POST['local'] ?>" />
            *</td>
        </tr>
        <tr>
          <td valign="top">Responsável: </td>
          <td align="left"><input name="responsavel" type="text" id="responsavel" size="50" maxlength="80" class="validate[required]"  value="<?php echo @$_POST['responsavel'] ?>"/>
            *</td>
        </tr>
        <tr>
          <td valign="top">Endereço:</td>
          <td align="left"><input name="endereco" type="text" id="endereco" size="50" maxlength="100" class="validate[required]" value="<?php echo @$_POST['endereco'] ?>" />
            *</td>
        </tr>
        <tr>
          <td valign="top">Numero:</td>
          <td align="left"><input name="numero" type="text" id="numero" size="6" maxlength="6" class="validate[required]"  onKeyPress="return sonumero(event)" value="<?php echo @$_POST['numero'] ?>"/>
            *</td>
        </tr>
        <tr>
          <td valign="top">CEP:</td>
          <td align="left"><input name="cep" type="text" id="cep" size="9" maxlength="9" value="<?php echo @$_POST['cep'] ?>"/>
          </td>
        </tr>
        <tr>
          <td valign="top">Bairro:</td>
          <td align="left"><input name="bairro" type="text" id="bairro" size="35" maxlength="50" class="validate[required]" value="<?php echo @$_POST['bairro'] ?>"/>
            *</td>
        </tr>
        <tr>
          <td valign="top">Telefone:</td>
          <td align="left"><input name="telefone" type="text"  onKeyPress="return sonumero(event)" id="telefone" size="10" maxlength="10" class="validate[required]" value="<?php echo @$_POST['telefone'] ?>" />
            *</td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td align="left">&nbsp;</td>
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
           <input type="button" name="enviar2" id="" value="Voltar" onClick="self.location='principal.php?acao=locais'"></td>
        </tr>
      </table>
</form>
