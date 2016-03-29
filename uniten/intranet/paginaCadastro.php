<?php
require_once 'util/config.php';


if(!empty($_GET['id']))
{
   $obj = new Pagina();
   $obj->get($_GET['id']);
   $_POST = $obj->toArray();
   $lbBotao = "Alterar";
}




logDao::gravaLog($user->login, 'PaginaCadastro', 'Acessou: lista de paginas do site', $_REQUEST,'','Pagina: '.$_GET['id']);

?>
<p><span class="titulo">Página &raquo; Cadastro</span><br> 
<link href="css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>


<script type="text/javascript" src="util/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="util/ckeditor/adapters/jquery.js"></script>

</p>

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
           /*['Image','Flash','Table','HorizontalRule','SpecialChar'],*/
           ['Link','Unlink','Anchor'],
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
	$('.texto').ckeditor(config);
});


</script>

<form name="form1" id="form1" method="post" action="paginaLogic.php">
<input type="hidden" name="id" value="<?php echo @$_POST['id']?>"  />
<table width="100%" cellpadding="3" cellspacing="1">
        <tr>
          <td width="17%" valign="top">Página:</td>
          <td width="83%"><?php echo @$_POST['titulo']?></td>
        </tr>
        <tr>
          <td colspan="2" valign="top">
            <textarea name="texto" class="texto" style="width: 350px; height: 450px;" cols="50" rows="4"><?php echo @$_POST['texto']?></textarea>          </td>
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
           
           <input type="button" name="enviar2" id="" value="Voltar" onClick="self.location='principal.php?acao=paginas'">
          </td>
        </tr>
      </table>
</form>
