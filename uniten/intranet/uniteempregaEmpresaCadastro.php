<?php
require_once 'util/config.php';
Security::admSecurity();
$empresa = new UniteEmprega();

if(!empty($_REQUEST['cod'])){
	$empresa->get($empresa->escape($_REQUEST['cod']));
	$lbBotao = "Alterar";
}else{
	$lbBotao = "Incluir";
}
 
logDao::gravaLog($user->id, 'alunoFicha', 'Ficha do Aluno', $_REQUEST);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="intranet.css" rel="stylesheet" type="text/css">
<link href="css/validationEngine.jquery.css" rel="stylesheet" type="text/css">
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/uniteempregaEmpresaCadastro.js"></script>
<table width="100%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">UNITE Emprega &raquo; Empresa &raquo; Cadastro</strong></p>
        </td>
    </tr>
    <tr>
        <td><form id="form1" name="form1" method="post" action="uniteempregaEmpresaLogic.php">
          <input name="id" type="hidden" value="<?php echo @$empresa->id?>" />
          <input name="acao" type="hidden" value="gravar" />
          <table width="100%" border="0" cellspacing="3" cellpadding="1">
            <tr>
              <td colspan="2"><strong>Dados da Empresa</strong></td>
            </tr>
            <tr>
              <td colspan="2"><hr /></td>
            </tr>
            <tr>
              <td width="21%">Razão Social:</td>
              <td width="79%"><input name="razao" type="text" id="razao" maxlength="80" size="50" value="<?php echo @$empresa->razao; ?>" class="validate[required]" style="text-transform:uppercase" /></td>
            </tr>
            <tr>
              <td>Nome Fantasia:</td>
              <td><input name="fantasia" type="text" id="fantasia" maxlength="40" size="40" value="<?php echo @$empresa->fantasia; ?>" class="validate[required]" style="text-transform:uppercase"  /></td>
            </tr>
            <tr>
              <td>CNPJ:</td>
              <td><input name="cnpj" onkeypress="return sonumero(event)"  type="text" class="validate[required]" id="cnpj" value="<?php echo @$empresa->cnpj; ?>" size="14" maxlength="14" />
              (somente números)</td>
            </tr>
            <tr>
              <td>Ramo de Atividade:</td>
              <td style="text-transform:uppercase"><select name="atividade" id="atividade" class="validate[required]" >
                <option value="" <?php if($empresa->atividade=='') {echo "selected";}?>>Selecione...</option>
                <option value="1" <?php if($empresa->atividade=='1') {echo "selected";}?>>Administrativo</option>
                <option value="2" <?php if($empresa->atividade=='2') {echo "selected";}?>>Alimentos</option>
                <option value="3" <?php if($empresa->atividade=='3') {echo "selected";}?>>Beleza</option>
                <option value="4" <?php if($empresa->atividade=='4') {echo "selected";}?>>Comercio</option>
                <option value="5" <?php if($empresa->atividade=='5') {echo "selected";}?>>Informática</option>
                <option value="6" <?php if($empresa->atividade=='6') {echo "selected";}?>>Eletrônica</option>
                <option value="7" <?php if($empresa->atividade=='7') {echo "selected";}?>>Metal Mecânica</option>
              </select></td>
            </tr>
            <tr >
              <td>Porte da Empresa:</td>
              <td style="text-transform:uppercase"><select name="porte" id="porte" class="validate[required]" >
                <option value=""    <?php if($empresa->porte=='') {echo "selected";}?>>Selecione...</option>
                <option value="1" <?php if($empresa->porte=='1') {echo "selected";}?>>Micro</option>
                <option value="2" <?php if($empresa->porte=='2') {echo "selected";}?>>Pequena</option>
                <option value="3" <?php if($empresa->porte=='3') {echo "selected";}?>>Média</option>
                <option value="4" <?php if($empresa->porte=='4') {echo "selected";}?>>Grande</option>
              </select></td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2"><strong>Endereço</strong></td>
            </tr>
            <tr>
              <td colspan="2"><hr /></td>
            </tr>
            <tr>
              <td>CEP:</td>
              <td style="text-transform:uppercase"><input name="cep" type="text" size="9" maxlength="9" id="cep" value="<?php echo @$empresa->cep; ?>"  />
                <input name="btPesquisarCep" type="button" id="btPesquisarCep" value="pesquisar"  />
                <span id="lbCep">*</span></td>
            </tr>
            <tr>
              <td>Endereço:</td>
              <td style="text-transform:uppercase"><input name="endereco" type="text" size="35" maxlength="120" id="endereco" value="<?php echo @$empresa->endereco; ?>" class="validate[required]"  style="text-transform:uppercase"  />
                * Nº:
                <input name="numero" type="text" onkeypress="return sonumero(event)" size="5" maxlength="5" id="numero" value="<?php echo @$empresa->numero; ?>" class="validate[required]" />
                *</td>
            </tr>
            <?php if(!empty($empresa->complemento)){ ?>
            <tr>
              <td>Complemento:</td>
              <td style="text-transform:uppercase"><input name="complemento" type="text" size="30" maxlength="45" id="complemento" value="<?php echo @$empresa->complemento; ?>"  style="text-transform:uppercase"  /></td>
            </tr>
            <?php } ?>
            <tr>
              <td>Bairro:</td>
              <td style="text-transform:uppercase"><input name="bairro" type="text" size="40" maxlength="50" id="bairro" value="<?php echo @$empresa->bairro; ?>" class="validate[required]"  style="text-transform:uppercase"  /></td>
            </tr>
            <tr>
              <td>Cidade:</td>
              <td style="text-transform:uppercase"><input name="cidade" type="text" size="40" maxlength="50" id="cidade" value="<?php echo @$empresa->cidade; ?>"  class="validate[required]"  style="text-transform:uppercase" /></td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2"><strong>Contato</strong></td>
            </tr>
            <tr>
              <td colspan="2"><hr /></td>
            </tr>
            <tr>
              <td>Responsável:</td>
              <td style="text-transform:uppercase"><input name="responsavel" type="text" id="responsavel" size="50" value="<?php echo @$empresa->responsavel; ?>" class="validate[required]"  style="text-transform:uppercase"  /></td>
            </tr>
            <tr>
              <td>Email:</td>
              <td style="text-transform:uppercase"><input name="email" type="text" id="email" size="50" value="<?php echo @$empresa->email; ?>" class="validate[required]"  style="text-transform:uppercase"  /></td>
            </tr>
            <tr>
              <td>Telefone:</td>
              <td style="text-transform:uppercase"><input name="ddd" type="text" class="validate[required]" id="ddd" value="<?php echo @$empresa->ddd; ?>" size="2" maxlength="2" onkeypress="return sonumero(event)"  />
                -
                <input name="telefone" type="text" class="validate[required]" id="telefone" value="<?php echo @$empresa->telefone; ?>" size="8" maxlength="8" onkeypress="return sonumero(event)" />
                *</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input name="alterar dados" type="submit" value="<?php echo $lbBotao?>" /> <input type="button" name="button" id="button" value="voltar" onclick="self.location='principal.php?acao=uniteemprega'" /></td>
            </tr>
          </table>
        </form></td>
    </tr>
</table>

<p>&nbsp;</p>
