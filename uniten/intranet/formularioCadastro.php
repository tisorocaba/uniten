<?php
require_once 'util/config.php';
Security::admSecurity();


logDao::gravaLog($user->login, 'formularioCadastro', 'Acessou: cadastro de formulario(novo)', $_REQUEST);
?>

<link href="css/validationEngine.jquery.css" rel="stylesheet" type="text/css">
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/formularioCadastro.js"></script>
<form action="formularioLogic.php" name="form" id="form1" method="post" enctype="multipart/form-data">
 


  <br />
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                      <tr>
                                        <td valign="top" class="conheca_titulo_1"><span class="conheca_titulo_2"><strong>FORMULÁRIO &raquo; CADASTRO</strong></span>
                                          <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1">
                                        <tr>
                                          <td width="24%" bgcolor="#E1E1E1" class="normal_home"><strong>Formulário: </strong></td>
                                          <td width="76%" bgcolor="#F3F3F3" class="normal_home">
                                          <input name="nome" type="text"  id="nome" value="<?php echo @$_POST['nome']?>" class="validate[required]" size="70" maxlength="120" />
*</td>
                                        </tr>
                                        
                                         <tr>
                                          <td bgcolor="#E1E1E1" class="normal_home"><strong>Arquivo: </strong></td>
                                          <td bgcolor="#F3F3F3" class="normal_home">
                                          <input name="arquivo" type="file"  id="arquivo" value="<?php echo @$_POST['arquivo']?>" size="50" class="validate[required]" maxlength="50" />
                                          *</td>
                                        </tr>
                                        
                                       
                                        
                                            <tr>
                                              <td height="40" colspan="2" align="center" class="normal_home"><br />
                                                <span class="noticia_normal">* Campos obrigat&oacute;rios </span>&nbsp;<br />
                                                <br />
                                                <input type="submit" name="acao" id="btGravar" value="gravar" />
                                              <input type="button" name="acao" id="btVoltar" value="&laquo; voltar" onclick="history.go(-1);" /></td>
                                            </tr>
                                          </table>
                                          
                                        </td>
    </tr>
</table>
</form>
<br />
<br />
<br />
<br />
<br />
