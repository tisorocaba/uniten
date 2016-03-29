<?php
require_once 'util/config.php';
Security::admSecurity();
if (!empty($_GET['id'])) {
    $obj = new Empresa();
    $obj->get($_GET['id']);
    $_POST = $obj->toArray();
    $lbBotao = "Alterar";
    logDao::gravaLog($user->login, 'empresaCadastro', 'Acessou: cadastro de empresa(alteracao) ', $_REQUEST,'','Empresa: '.$_GET['id']);

} else {
    $lbBotao = "Gravar";
    logDao::gravaLog($user->login, 'empresaCadastro', 'Acessou: cadastro de empresa(novo) ', $_REQUEST);

}

?>
<link href="css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript"  src="scripts/empresaCadastro.js"></script>
<p><span class="titulo">Empresa &raquo; Cadastro</span><br>

</p>

<form name="form1" method="post" id="form1" action="empresaLogic.php">
    <table width="100%" cellpadding="3" cellspacing="1">
        <tr>
            <td width="17%" valign="top">Típo:</td>
            <td width="83%">
                <select name="status" class="validate[required]" id="status">
                    <option value="">Selecione...</option>
                    <option value="1" <?php if(@$_POST['status']==1) echo "selected"?>>Aplica Prova</option>
                    <option value="2" <?php if(@$_POST['status']==2) echo "selected"?>>Aplica Cursos</option>
                    <option value="3" <?php if(@$_POST['status']==3) echo "selected"?>>UNITE</option>
                </select>
            </td>
        </tr>
        <tr>
          <td valign="top">Nome Fantasia</td>
          <td><input name="fantasia" type="text" id="fantasia" size="50" maxlength="85" value="<?php echo @$_POST['fantasia']?>" class="validate[required]" /></td>
        </tr>
        <tr>
            <td width="17%" valign="top">Razão Social :</td>
            <td width="83%"><input name="nome" type="text" id="nome" size="50" maxlength="85" value="<?php echo @$_POST['nome']?>" class="validate[required]">*</td>
        </tr>
        <tr>
            <td valign="top">Responsável:</td>
            <td><input name="responsavel" type="text" id="responsavel" size="50" maxlength="125" value="<?php echo @$_POST['responsavel']?>" class="validate[required]" />*</td>
        </tr>
        <tr>
            <td valign="top">Email:</td>
            <td><input name="email" type="text" id="email" size="50" maxlength="125" value="<?php echo @$_POST['email']?>" class="validate[required,custom[email]]" />*</td>
        </tr>
        <tr>
            <td valign="top">CEP:</td>
            <td><input name="cep" type="text" id="cep" size="9" value="<?php echo @$_POST['cep']?>" class="validate[required]" />
                <input type="button" name="enviar3" id="btPesquisar" value="Pesquisar"   />*<span id="lbCep"></span></td>
        </tr>
        <tr>
            <td valign="top">Endereço:</td>
            <td><input name="endereco" type="text" id="endereco" maxlength="45" value="<?php echo @$_POST['endereco']?>"  size="50" class="validate[required]"/>*</td>
        </tr>
        <tr>
            <td valign="top">Número:</td>
            <td><input name="numero" type="text" id="numero" maxlength="6"  size="6" value="<?php echo @$_POST['numero']?>" class="validate[required]" onKeyPress="return sonumero(event)"  />*</td>
        </tr>
        <tr>
            <td valign="top">Complemento:</td>
            <td><input name="complemento" type="text" id="complemento" size="30" maxlength="45" value="<?php echo @$_POST['complemento']?>"  /></td>
        </tr>
        <tr>
            <td valign="top">Bairro:</td>
            <td><input name="bairro" type="text" id="bairro" size="30" maxlength="50" value="<?php echo @$_POST['bairro']?>" class="validate[required]"/>*</td>
        </tr>
        <tr>
            <td valign="top">Cidade:</td>
            <td><input name="cidade" type="text" id="cidade" size="30" value="<?php echo @$_POST['cidade']?>" class="validate[required]"/>*</td>
        </tr>
        <tr>
            <td valign="top">Estado:</td>
            <td><input name="estado" type="text" id="estado" maxlength="2" size="2" value="<?php echo @$_POST['estado']?>" class="validate[required]"/>*</td>
        </tr>
        <tr>
            <td valign="top">Telefone:</td>
            <td><input name="ddd" type="text" id="ddd" size="2" maxlength="2" value="<?php echo @$_POST['ddd']?>" class="validate[required]" onKeyPress="return sonumero(event)" onkeyup="autoTab(2, this, telefone) "/>
                -
                <input name="telefone" type="text" id="telefone" size="9" maxlength="9" value="<?php echo @$_POST['telefone']?>"  class="validate[required]"/>*</td>
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
             <input name="id" type="hidden" value="<?php echo @$_POST['id']?>" /><input type="button" name="enviar2" id="" value="Voltar" onClick="self.location='principal.php?acao=empresas'">


            </td>
        </tr>
    </table>
</form>
