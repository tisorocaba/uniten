<?php
require_once 'util/config.php';
Security::admSecurity();

if(empty($_REQUEST['agenda']) || empty($_REQUEST['op'])){
	gotox("principal.php?acao=agendacursos");
}

if (!empty($_SESSION['LOCAL'])) {
  $url = "principal.php?acao=".$_SESSION['ORIGEM']."&local=" . $_SESSION['LOCAL']."&offset=".$_SESSION['OFFSET'];
} elseif (!empty($_SESSION['BUSCA'])) {
  $url ="principal.php?acao=".$_SESSION['ORIGEM']."&busca=" . $_SESSION['BUSCA']."&offset=".$_SESSION['OFFSET'];
} else {
  $url ="principal.php?acao=".$_SESSION['ORIGEM']."&offset=".$_SESSION['OFFSET'];
}

?>
<link href="intranet.css" rel="stylesheet" type="text/css" />

<p><span class="titulo">Agenda de Cursos  &raquo; Confirmação de Cadastro</span><br> 
<link href="css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">
<link href="css/datepicker.css" rel="stylesheet" type="text/css">
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/datepicker.js" type="application/javascript"></script>
<script src="js/datepicker-pt-BR.js" type="application/javascript"></script>
<script src="js/jquery.number_format.1.0.js"></script>
<script src="scripts/agendaCursoMensagem.js"></script>
</p>

<input  id="hdnAgenda" type="hidden" value="<?php echo $_REQUEST['agenda']?>" />
<table width="100%" cellpadding="3" cellspacing="1">
        <tr>
          <td colspan="2" valign="top" align="center"> <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <?php if($_REQUEST['op']==1){ ?>
            	<span class="sobreTitulo">Inclusão realizada com sucesso</span>.<br />
            <?php }else{  ?>
               <span class="sobreTitulo">Alteração realizada com sucesso.</span><br />
            <?php } ?>
            </span></td>
        </tr>
      
        <tr>
          <td valign="top">&nbsp;</td>
          <td align="left"></td>
        </tr>
        <tr>
          <td width="40%" valign="top">&nbsp;</td>
          <td width="60%" align="left"></td>
        </tr>
        <tr>
          <td colspan="2" valign="top"><table width="40%" border="0" align="center">
            <tr>
                <!-- <td><input type="submit" name="btnMonitores" id="btnMonitores" value="Cadastrar monitores" /></td> -->
                <td width="56%"><input type="button" name="btnGrade" id="btnGrade" value="Cadastrar ou alterar a grade de aulas" /></td>
                <td width="44%"><input type="submit" name="btnVoltar" id="btnVoltar" value="Voltar" onclick="self.location='<?php echo $url?>'" /></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td align="left"></td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td align="left"></td>
        </tr>
      </table>
