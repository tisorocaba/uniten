<?php
require_once 'util/config.php';
Security::admSecurity();

if(!empty($_GET['id']))
{
   $obj = new Banner();
   $obj->get($_GET['id']);
   $_POST = $obj->toArray();
   logDao::gravaLog($user->login, 'bannerCadastro', 'Acessou: Cadastro de Banner(alteracao)', $_REQUEST,'','Banner: '.$_GET['id']);
}else{
   logDao::gravaLog($user->login, 'bannerCadastro', 'Acessou: cadastro de curso(novo) ', $_REQUEST);
}

?>
<br />
<link href="css/validationEngine.jquery.css" rel="stylesheet" type="text/css">
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/bannerCadastro.js"></script>
<form action="bannerLogic.php" name="form" id="form1" method="post" enctype="multipart/form-data">
 <?php if(!empty($_GET['id'])){ ?>
  <input type="hidden" name="id" id="id" value="<?php echo $_GET['id']?>">
  <?php } ?>
  <br />

  <br />
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                      <tr>
                                        <td valign="top" class="conheca_titulo_1"><span class="conheca_titulo_2"><strong>BANNER &raquo; CADASTRO</strong></span>
                                          <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1">
                                        <tr>
                                          <td width="24%" bgcolor="#E1E1E1" class="normal_home"><strong>Nome do Banner: </strong></td>
                                          <td width="76%" bgcolor="#F3F3F3" class="normal_home">
                                          <input name="titulo" type="text"  id="titulo" value="<?php echo @$_POST['titulo']?>" class="validate[required]" size="70" maxlength="120" />
*</td>
                                        </tr>
                                        <tr style="display: none">
                                          <td bgcolor="#E1E1E1" class="normal_home"><strong>Link: </strong></td>
                                          <td bgcolor="#F3F3F3" class="normal_home"><input name="url" type="text"  id="url" value="<?php echo @$_POST['url']?>" size="70" class="validate[required]" maxlength="110" />
</td>
                                        </tr>
                                        <tr style="display: none">
                                          <td bgcolor="#E1E1E1" class="normal_home"><strong>Posi��o: </strong></td>
                                          <td bgcolor="#F3F3F3" class="normal_home">
                                          <input name="posicao" type="text" class="internas_normal" id="posicao" value="<?php echo @$_POST['posicao']?>" size="1" maxlength="1" />

                                          </td>
                                        </tr>
                                        
                                         <tr>
                                          <td bgcolor="#E1E1E1" class="normal_home"><strong>Imagem: </strong></td>
                                          <td bgcolor="#F3F3F3" class="normal_home">
                                          <input name="imagem" type="file"  id="imagem" value="<?php echo @$_POST['imagem']?>" size="50" class="validate[required]" maxlength="50" />
                                          * (jpg) (570 x 320)

                                          </td>
                                        </tr>
                                        
                                        <?php if(!empty($_POST['imagem'])){ ?>
                                         <tr>
                                          <td bgcolor="#F3F3F3" class="normal_home" colspan="2" align="right">
                                          <img src="../thumbs.php?img=<?php echo $_POST['imagem']?>&w=100&h=100">
                                          </td>
                                         
                                         </tr>
                                         <?php } ?>
                                        
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
