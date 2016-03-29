<?php
require_once 'util/config.php';
Security::admSecurity();
if(!empty($_GET['id']))
{
   $obj = new Projeto();
   $obj->get($_GET['id']);
   $_POST = $obj->toArray();
   $lbBotao = "Alterar";
   logDao::gravaLog($user->login, 'projetoCadastro', 'Acessou: cadastro de projeto(alteracao)', $_REQUEST,'','Projeto: '.$_GET['id']);
}else{
   logDao::gravaLog($user->login, 'projetoCadastro', 'Acessou: cadastro de projeto(novo)', $_REQUEST);
   $lbBotao = "Gravar";
}

            
?>
<p><span class="titulo">Projeto &raquo; Cadastro</span><br> 
</p>
<script src="scripts/projetoCadastro.js"></script>
<script type="text/javascript" src="util/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="util/ckeditor/adapters/jquery.js"></script>

<script language="javascript" type="text/javascript">
	function clear_form_elements(ele) {

    $(ele).find(':input').each(function() {
        switch(this.type) {
            case 'password':
            case 'select-multiple':
            case 'select-one':
            case 'text':
            case 'textarea':
                $(this).val('');
                break;
	        case 'txtarea':
                $(this).val('');
                break;
            case 'checkbox':
            case 'radio':
                this.checked = false;
        }
    });

}
				   
$(function()
{


	var config = {
		
	  extraPlugins : 'uicolor',
	  uiColor: '#9AB8F3',
		toolbar:
		[
           /*['Cut','Copy','Paste','PasteText','PasteFromWord','-','SpellChecker', 'Scayt'],*/
           ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
          /* ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],*/
	       ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','Link','Unlink','Anchor'],
           /*['Image','Flash','Table','HorizontalRule','SpecialChar'],['Link','Unlink','Anchor'],*/
           ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
           ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
          
           /*['Styles','Format','Font','FontSize'],*/
           ['TextColor','BGColor'],
           /*['Maximize', 'ShowBlocks','-']*/
		]
	};
	 //  Un comment the below line if you wish to add your templates css to the editor.	
    //	config.contentsCss = 'http://localhost/admin/templates/template 2/styles.css';

	// Initialize the editor.
	// Callback function can be passed and executed after full instance creation.
	$('.descricao').ckeditor(config);
});


</script>
<form name="form1" method="post" action="projetoLogic.php" id="form" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo @$_POST['id']?>"  />
<table width="100%" cellpadding="3" cellspacing="1">
        <tr>
          <td width="17%" valign="top">Projeto:*</td>
          <td width="83%">
              <input name="nome" type="text" id="nome" size="50" maxlength="85" value="<?php echo @$_POST['nome']?>"></td>
        </tr>
        <tr>
          <td valign="top">Publicar no Site:</td>
          <td align="left"> <select name="publicar" id="publicar">
              <option value="1" <?php if(@$_POST['publicar']==1) echo "selected"; ?>>Sim</option>
              <option value="0" <?php if(@$_POST['publicar']==0) echo "selected"; ?>>Não</option>
          </select></td>
        </tr>
        <tr>
          <td valign="top">Imagem:</td>
          <td><input name="imagem" type="file" id="imagem" size="50"  /></td>
        </tr>
        <?php if(!empty($_POST['imagem'])) { ?>
        <tr>
          <td valign="top">&nbsp;</td>
          <td><img alt=""  src="../thumbs.php?img=<?php echo $_POST['imagem']?>&w=80&h=80"/></td>
        </tr>
        <?php } ?>
        <tr>
          <td valign="top">&nbsp;</td>
          <td align="left">
             <textarea name="descricao" class="descricao"  cols="20" rows="4" wrap="virtual"><?php echo @$_POST['descricao']?></textarea></td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td align="left">
              <input type="hidden" name="acao" value="gravar">
           <input type="button" name="btGravar" id="btGravar" value="<?php echo $lbBotao?>">
          <input type="button" name="enviar" id="" value="Voltar" onClick="self.location='principal.php?acao=projetos'"></td>
        </tr>
      </table>
</form>
