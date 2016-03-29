<?php
require_once 'util/config.php';
Security::admSecurity();
if(!empty($_GET['id']))
{
   $obj = new Noticia();
   $obj->get($_GET['id']);
   $_POST = $obj->toArray();
   $_POST['data'] = data_br($_POST['data']);
   $lbBotao = "Alterar";
   logDao::gravaLog($user->login, 'noticiaCadastro', 'Acessou: cadastro de noticia(alterar)', $_REQUEST, '', 'Noticia: ' . $_GET['id']);
}else{
   $lbBotao = "Gravar";
   logDao::gravaLog($user->login, 'noticiaCadastro', 'Acessou: cadastro de noticia(novo)', $_REQUEST);
}

?>

<p><span class="titulo">Notícia &raquo; Cadastro</span><br>
</p>
<link href="css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">
<link href="css/datepicker.css" rel="stylesheet" type="text/css">
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/datepicker.js" type="application/javascript"></script>
<script src="js/datepicker-pt-BR.js" type="application/javascript"></script>
<script type="text/javascript" src="scripts/noticiaCadastro.js"></script>


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
	       ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
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

<form name="form1" id="form1" method="post" action="noticiaLogic.php" enctype="multipart/form-data">
 <input type="hidden" name="id" value="<?php echo @$_POST['id']?>"  />
<table width="100%" cellpadding="3" cellspacing="1">
  <tr>
          <td width="17%" valign="top">Data:</td>
          <td width="83%"><input type="text" name="data" value="<?php echo @$_POST['data']?>" id="data" size="12"  maxlength="12" class="validate[required]" >*</td>
        </tr>
        <tr>
          <td valign="top">Título da Notícia:</td>
          <td><input name="titulo" type="text" id="titulo" size="80" value="<?php echo @$_POST['titulo']?>" maxlength="150" class="validate[required]" >*</td>
        </tr>
        <tr>
          <td valign="top">Texto:</td>
          <td><textarea name="descricao" id="descricao"    cols="78" rows="15" ><?php echo @$_POST['descricao']?></textarea></td>
        </tr>
        <tr>
          <td valign="top">Foto 1:</td>
          <td>
           
           <?php if(!empty($_POST['foto1'])){ ?>
             <input name="foto1" type="file" id="foto" size="30"  /> 
             <img alt=""  src="../thumbs.php?img=<?php echo $_POST['foto1']?>&amp;w=80&amp;h=80"/>
          <?php }else{ ?>
          	<input name="foto1" type="file" id="foto" size="30"  class="validate[required]" /> somente (JPG) *
          <?php } ?>
          </td>
        </tr>
        
         <tr>
          <td valign="top">Foto 2:</td>
          <td><input name="foto2" type="file" id="foto" size="30"  /> somente (JPG) 
           <?php if(!empty($_POST['foto2'])){ ?>
             <img alt=""  src="../thumbs.php?img=<?php echo $_POST['foto2']?>&amp;w=80&amp;h=80"/>
          <?php } ?>
          </td>
        </tr>
         <tr>
          <td valign="top">Foto 3:</td>
          <td><input name="foto3" type="file" id="foto" size="30"  /> somente (JPG) 
           <?php if(!empty($_POST['foto3'])){ ?>
             <img alt=""  src="../thumbs.php?img=<?php echo $_POST['foto3']?>&amp;w=80&amp;h=80"/>
          <?php } ?>
          </td>
        </tr> <tr>
          <td valign="top">Foto 4:</td>
          <td><input name="foto4" type="file" id="foto" size="30"  /> somente (JPG) 
           <?php if(!empty($_POST['foto4'])){ ?>
             <img alt=""  src="../thumbs.php?img=<?php echo $_POST['foto4']?>&amp;w=80&amp;h=80"/>
          <?php } ?>
          </td>
        </tr>
       
        <tr>
          <td valign="top">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        
        <tr>
          <td valign="top">&nbsp;</td>
          <td>&nbsp;</td>
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
           <input type="button" name="enviar2" id="" value="Voltar" onClick="self.location='principal.php?acao=noticias'"></td>
       


          </td>
        </tr>
      </table>
</form>
