<?php
require_once 'util/config.php';
Security::admSecurity();
$menus = array();
if(!empty($_GET['id']))
{
   //xdebug();
   $obj = new Usuario();
   $obj->get($_GET['id']);
   $_POST = $obj->toArray();
   $lbBotao = "Alterar";
   $i=0;
   foreach ($obj->getLink('menus') as $menu) {
       $menus[$i]= $menu->id;
       $i++;
   }
 logDao::gravaLog($user->login, 'projetoUsuario', 'Acessou: cadastro de usuario(alteracao)', $_REQUEST,'','Usuario: '.$_GET['id']);
}else{
   $lbBotao = "Gravar";
   logDao::gravaLog($user->login, 'projetoUsuario', 'Acessou: cadastro de usuario(novo)', $_REQUEST);
}


?>
<link href="css/validationEngine.jquery.css" rel="stylesheet" type="text/css">
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/usuarioCadastro.js"></script>
<p><span class="titulo">Usuário &raquo; Cadastro</span><br>
</p>

<form name="form1" id="form1" method="post" action="usuarioLogic.php">
<input name="idEmpresa" type="hidden" id="idEmpresa" value="<?php echo @$_POST['empresa']['id']?>" />
<input name="idLocal" type="hidden" id="idLocal" value="<?php echo @$_POST['local']?>" />
<input name="id" type="hidden" id="id" value="<?php echo @$_POST['id']?>" />
<table width="100%" cellpadding="3" cellspacing="1">
  <tr>
    <td valign="top">Típo empresa: </td>
    <td>
    <select name="status" class="validate[required]" id="cbStatus" >
                    <option value="">Selecione...</option>
                    <option value="1" <?php if(@$_POST['empresa']['status']==1) echo "selected"?>>Aplica Prova</option>
                    <option value="2" <?php if(@$_POST['empresa']['status']==2) echo "selected"?>>Aplica Cursos</option>
                    <option value="3" <?php if(@$_POST['empresa']['status']==3) echo "selected"?>>Gestora</option>
   </select>
               &nbsp; <span id="lbEmpresas"></span>
    </td>
  </tr>
  <tr id="linhaEmpresa" style="display:none">
    <td valign="top">Empresa:</td>
    <td><span id="spanEmpresa"></span>* &nbsp;<span id="lbLocal"></span></td>
  </tr>
  <tr id="linhaTipoLogin" style="display:none">
    <td valign="top"  >Típo:</td>
    <td>
     <select name="tipoLogin" id="cbUsuarioTipo">
             <option value="1" <?php if(@(int)$_POST['tipoLogin']==1) echo "selected" ?>>COODENADOR</option>
             <option value="2" <?php if(@(int)$_POST['tipoLogin']==2) echo "selected" ?>>MONITOR</option>
        </select>
    </td>
  </tr>
  <tr id="linhaLocal" style="display:none">
    <td valign="top"  >Local:</td>
    <td><span id="spanLocal"></span></td>
  </tr>
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
          <td height="26" valign="top">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr id="linhaNivel" >
          <td height="91" colspan="2" valign="top"><span id="spNivel"></span></td>
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
