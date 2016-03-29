<?php
require_once 'util/config.php';
Security::admSecurity();

$disciplina = new Disciplina();
$disciplina->alias('d')->where('d.ativo=1')->order('d.nome ASC')->find();

$segmentos = new Segmento();
$segmentos->alias('s')->where('s.ativo=1')->order('s.nome ASC')->find();


$disciplinacol2 = new Disciplina();
$disciplinacol2->alias('d')->where('d.ativo=1')->order('d.nome ASC')->find();


if (!empty($_GET['id'])) {
    $obj = new Curso();
    $obj->get($_GET['id']);
    $_POST = $obj->toArray();
    $list = $obj->getLink('disciplinas');
    foreach ($list as $item) {
        $_POST['disciplinas'][] = $item->id;
    }
    $lbBotao = "Alterar";
    logDao::gravaLog($user->login, 'cursoCadastro', 'Acessou: cadastro de curso(alteracao) ', $_REQUEST, '', 'Curso: ' . $_GET['id']);
} else {
    $lbBotao = "Gravar";
    logDao::gravaLog($user->login, 'cursoCadastro', 'Acessou: cadastro de curso(novo) ', $_REQUEST);
}
?>
<style>
    UL.col3
    {
        PADDING-RIGHT: 0px;
        PADDING-LEFT: 0px;
        FLOAT: left;
        PADDING-BOTTOM: 0px;
        MARGIN: 15px 0px;
        WIDTH: 100%;
        PADDING-TOP: 0px;
        LIST-STYLE-TYPE: none
    }

    UL.col3 LI
    {
        PADDING-RIGHT: 2px;
        DISPLAY: inline;
        PADDING-LEFT: 2px;
        FLOAT: left;
        PADDING-BOTTOM: 2px;
        WIDTH: 30%;
        PADDING-TOP: 2px
    }

</style>
<p><span class="titulo">Cursos &raquo; Cadastro</span><br>
</p>
<link href="css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/cursoCadastro.js"></script>

<script type="text/javascript" src="util/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="util/ckeditor/adapters/jquery.js"></script>

<script language="javascript" type="text/javascript">
    function clear_form_elements(ele) {

        $(ele).find(':input').each(function() {
            switch (this.type) {
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
            height: 250,
            width:700,
            extraPlugins: 'uicolor',
            uiColor: '#9AB8F3',
            toolbar:
                    [
                        /*['Cut','Copy','Paste','PasteText','PasteFromWord','-','SpellChecker', 'Scayt'],*/
                        ['Undo', 'Redo', '-', 'Find', 'Replace', '-', 'SelectAll', 'RemoveFormat'],
                        /* ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],*/
                        ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
                        /*['Image','Flash','Table','HorizontalRule','SpecialChar'],['Link','Unlink','Anchor'],*/
                        ['Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript'],
                        ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'Blockquote'],
                        /*['Styles','Format','Font','FontSize'],*/
                        ['TextColor', 'BGColor'],
                                /*['Maximize', 'ShowBlocks','-']*/
                    ]
        };
        //  Un comment the below line if you wish to add your templates css to the editor.	
        //	config.contentsCss = 'http://localhost/admin/templates/template 2/styles.css';

        // Initialize the editor.
        // Callback function can be passed and executed after full instance creation.
       // $('.requisitos1').ckeditor(config);
    });


</script>
<form name="form1" id="form1" method="post" action="cursoLogic.php">
    <input type="hidden" name="id" value="<?php echo @$_POST['id'] ?>"  />
    <table width="100%" cellpadding="3" cellspacing="1">
        <tr>
            <td width="16%" valign="top">Nome do Curso:*</td>
            <td width="84%"><input name="nome" type="text" id="nome" size="70" class="validate[required]" value="<?php echo @$_POST['nome'] ?>" /></td>
        </tr>
        <tr>
            <td valign="top">Segmento: </td>
            <td align="left">
                <select name="segmento" id="segmento" class="validate[required]">
                    <option value="">selecione...</option>
<?php echo Lumine_Util::buildOptions($segmentos, 'id', 'nome', @$_POST['segmento']['id']); ?>
                </select>

            </td>
        </tr>
        <tr>
            <td valign="top">Destaque Site: </td>
            <td align="left">
                <select name="destaque" id="destaque" class="validate[required]">
                    <option value="1" <?php if (@$_POST['destaque'] == 1) {
    echo "selected=\"selected\"";
} ?> >Sim</option>
                    <option value="0" <?php if (@$_POST['destaque'] == 0) {
    echo "selected=\"selected\"";
} ?>>Não</option>
                    <select></td>
                        </tr>
                        <tr>
                            <td valign="top">Requisitos:</td>
                            <td align="left">
                                <textarea name="requisitos" class="requisitos"  cols="60" rows="8" wrap="virtual"><?php echo @$_POST['requisitos'] ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">Disciplinas:*</td>
                            <td align="left">


                                <table width="100%" border="0" cellspacing="0" cellpadding="0">


                                    <tr>
                                      
                                        <td class="normal" width="100%" >
                                          <ul class="col3">
    <?php while ($disciplinacol2->fetch()) { ?>
												<li>
                                                <?php
                                                printf('<input type="checkbox" name="disciplinas[]" class="validate[minCheckbox[1]]" id="disciplinas" value="%d" %s  /> %s <br />', $disciplinacol2->id, !empty($_POST['disciplinas']) && in_array($disciplinacol2->id, $_POST['disciplinas']) ? 'checked="checked"' : '', $disciplinacol2->nome);
                                                ?>
                                                
                                                   </li>                                





<?php } ?>

                                          
											</ul> 
                                        </td>
                                    </tr>
                                </table>



                            </td>
                        </tr>
                        <tr>
                            <td valign="top">&nbsp;</td>
                            <td align="left">
                                <input type="hidden" name="acao" value="gravar">
                                <input type="submit" name="btGravar" id="btGravar" value="<?php echo $lbBotao ?>">
                                <input type="button" name="enviar2" id="" value="Voltar" onClick="self.location = 'principal.php?acao=cursos'"></td>


                        </tr>
                        </table>
                        </form>
