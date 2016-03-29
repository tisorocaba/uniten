<?php
require_once 'util/config.php';
$cursos = new Curso();
$cursos->alias('c')->order('c.nome ASC')->find();

if(!empty($_GET['id']))
{
   $obj = new Disciplina();
   $obj->get($_GET['id']);
   $_POST = $obj->toArray();
   $lbBotao = "Alterar";
   logDao::gravaLog($user->login, 'disciplinaCadastro', 'Acessou: cadastro de disciplina(alteracao) ', $_REQUEST,'','Disciplina: '.$_GET['id']);

}else{
   $lbBotao = "Gravar";
   logDao::gravaLog($user->login, 'disciplinaCadastro', 'Acessou: cadastro de disciplina(novo) ', $_REQUEST);
   if(empty($_GET['curso']))
       $cursosel = 0;
    else
       $cursosel = $_GET['curso'];
	   
}

?>
<p><span class="titulo">Disciplina &raquo; Cadastro</span><br> 
<link href="css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/disciplinaCadastro.js"></script>

<script type="text/javascript" src="js/ckeditor4.4/ckeditor.js"></script>
<script type="text/javascript" src="js/ckeditor4.4/adapters/jquery.js"></script>

</p>


<form name="form1" id="form1" method="post" action="disciplinaLogic.php">
<input type="hidden" name="id" value="<?php echo @$_POST['id']?>"  />
<table width="100%" cellpadding="3" cellspacing="1">
        <tr>
         <!-- <td valign="top"> Curso:</td>
          <td align="left">
           <select name="curso" id="curso">
            <?php echo Lumine_Util::buildOptions($cursos,'id','nome', $cursosel); ?>
           </select>
           </td> -->
        </tr>
        <tr>
          <td width="17%" valign="top">Disciplina:</td>
          <td width="83%">
              <input name="nome" type="text" id="nome" size="75" value="<?php echo @$_POST['nome']?>" maxlength="75" class="validate[required]">*</td>
        </tr>
        <tr>
          <td valign="top">Carga Horária:</td>
          <td><input name="cargaHoraria" type="text" id="cargaHoraria" value="<?php echo @$_POST['cargaHoraria']?>"  size="4" maxlength="4" class="validate[required]" onKeyPress="return sonumero(event)"/>*
            (ex: 180) horas</td>
        </tr>
        <tr>
          <td valign="top">Conhecimentos:</td>
          <td align="left">
          <textarea name="conhecimento" class="conhecimento" style="width: 350px; height: 650px;" cols="50" rows="4"><?php echo @$_POST['conhecimento']?></textarea>
          
          </td>
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
           <input name="id" type="hidden" value="<?php echo @$_POST['id']?>" /><input type="button" name="enviar2" id="" value="Voltar" onClick="self.location='principal.php?acao=disciplinas'">
          </td>
        </tr>
      </table>
</form>
