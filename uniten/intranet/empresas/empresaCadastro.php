<?php
require_once '../util/config.php';
Security::uniteempregaSecurity();
$obj = new UniteEmprega();
$obj->get($empresa->id);

//logDao::gravaLog($user->id, 'cursoCadastro', '',$_REQUEST);
?>
<p><span class="titulo">Empresa &raquo; Cadastro</span><br>
</p>
<link href="../css/validationEngine.jquery.css" rel="stylesheet" type="text/css">
<script src="../js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/empresaCadastro.js"></script>

<form name="form1" id="form1" method="post" action="empresaLogic.php">
  <input type="hidden" name="acao" value="gravar" />
  <input type="hidden" name="id" value="<?php echo $empresa->id ?>" />
  <table width="100%" border="0" cellspacing="1" cellpadding="5">
    <tr>
      <td><strong>Sobre a empresa</strong></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><hr /></td>
    </tr>
    <tr>
      <td>Razão Social:</td>
      <td><input name="razao" type="text" id="razao" maxlength="80" size="50" value="<?php echo $obj->razao ?>" class="validate[required]" style="text-transform:uppercase" />
        *</td>
    </tr>
    <tr>
      <td>Nome Fantasia:</td>
      <td><input name="fantasia" type="text" id="fantasia" maxlength="40" size="40" value="<?php echo $obj->fantasia ?>" class="validate[required]" style="text-transform:uppercase"  />
        *</td>
    </tr>
    <tr>
      <td>CNPJ:</td>
      <td><input name="cnpj" onkeypress="return sonumero(event)"  type="text" class="validate[required]" id="cnpj" value="<?php echo $obj->cnpj; ?>" size="15" maxlength="14" readonly="readonly" />
        *</td>
    </tr>
    <tr>
      <td>Ramo da Atividade:</td>
      <td><select name="atividade" id="atividade" class="validate[required]" >
        
        <option value="1" <?php if($obj->atividade==1) echo "selected" ?>>Administrativo</option>
        <option value="2" <?php if($obj->atividade==2) echo "selected" ?>>Alimentos</option>
        <option value="3" <?php if($obj->atividade==3) echo "selected" ?>>Beleza</option>
        <option value="4" <?php if($obj->atividade==4) echo "selected" ?>>Comercio</option>
        <option value="5" <?php if($obj->atividade==5) echo "selected" ?>>Informática</option>
        <option value="6" <?php if($obj->atividade==6) echo "selected" ?>>Eletrônica</option>
        <option value="7" <?php if($obj->atividade==7) echo "selected" ?>>Metal Mecânica</option>
      </select>
        *</td>
    </tr>
    <tr>
      <td>Porte da Empresa:</td>
      <td><select name="porte" id="porte" class="validate[required]" >
        <option value="1" <?php if($obj->porte==1) echo "selected" ?>>Micro</option>
        <option value="2" <?php if($obj->porte==2) echo "selected" ?>>Pequena</option>
        <option value="3" <?php if($obj->porte==3) echo "selected" ?>>Média</option>
        <option value="4" <?php if($obj->porte==4) echo "selected" ?>>Grande</option>
      </select>
        *</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><strong>Endereço</strong></td>
    </tr>
    <tr>
      <td colspan="2"><hr/></td>
    </tr>
    <tr>
      <td>CEP:</td>
      <td><input name="cep" type="text" size="9" maxlength="9" id="cep" value="<?php echo $obj->cep; ?>"  />
        <input name="btPesquisarCep" type="button" id="btPesquisarCep" value="pesquisar"  />
        <span id="lbCep">*</span></td>
    </tr>
    <tr>
      <td>Endereço:</td>
      <td><input name="endereco" type="text" size="35" maxlength="120" id="endereco" value="<?php echo $obj->endereco; ?>" class="validate[required]"  style="text-transform:uppercase"  />
        * Nº:
        <input name="numero" type="text" onkeypress="return sonumero(event)" size="5" maxlength="5" id="numero" value="<?php echo $obj->numero; ?>" class="validate[required]" />
        *</td>
    </tr>
    <tr>
      <td>Complemento:</td>
      <td><input name="complemento" type="text" size="30" maxlength="45" id="complemento" value="<?php echo $obj->complemento; ?>"  style="text-transform:uppercase"  /></td>
    </tr>
    <tr>
      <td>Bairro:</td>
      <td><input name="bairro" type="text" size="40" maxlength="50" id="bairro" value="<?php echo $obj->bairro; ?>" class="validate[required]"  style="text-transform:uppercase"  />
        *</td>
    </tr>
    <tr>
      <td>Cidade:</td>
      <td><input name="cidade" type="text" size="40" maxlength="50" id="cidade" value="<?php echo $obj->cidade; ?>"  class="validate[required]"  style="text-transform:uppercase" />
        *</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><strong>Contato</strong></td>
    </tr>
    <tr>
      <td colspan="2"><hr/></td>
    </tr>
    <tr>
      <td>Nome do Responsável:</td>
      <td><input name="responsavel" type="text" id="responsavel" size="50" value="<?php echo $obj->responsavel;?>" class="validate[required]"  style="text-transform:uppercase"  />
        *</td>
    </tr>
    <tr>
      <td>Email:</td>
      <td><input name="email" type="text" id="email" size="50" value="<?php echo $obj->email;?>" class="validate[required]"  style="text-transform:uppercase"  />
        *</td>
    </tr>
    <tr>
      <td>Telefone</td>
      <td><input name="ddd" type="text" class="validate[required]" id="ddd" value="<?php echo $obj->ddd; ?>" size="2" maxlength="2" />
        -
        <input name="telefone" type="text" class="validate[required]" id="telefone" value="<?php echo $obj->telefone ?>" size="8" maxlength="8" />
        *</td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td><input name="alterar" value="alterar" id="btEnviar" type="submit" />
        &nbsp;&nbsp;
        </td>
    </tr>
  </table>
</form>
