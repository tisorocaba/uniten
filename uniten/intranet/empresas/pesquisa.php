<?php
require_once '../util/config.php';
Security::uniteempregaSecurity();
$cursos = new Curso();
$cursos->alias ('c')->where('c.ativo = 1')->order ('c.nome ASC')->find ();

/*$empresas = new Empresa ();
$empresas->alias ('p')->order ('p.nome ASC')->find ();
logDao::gravaLog($user->id, 'gastos', $_REQUEST ['acao'], $_REQUEST);*/

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="intranet.css" rel="stylesheet" type="text/css">
<link href="../css/validationEngine.jquery.css" rel="stylesheet" type="text/css">


<script src="../js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>




<link href="../js/css/jquery-ui.css" rel="stylesheet" type="text/css">
<link href="../js/css/ui.theme.css" rel="stylesheet" type="text/css">
<script src="../js/jquery-1.6.2.min.js"></script>
<script src="../js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.ui.core.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.ui.widget.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.ui.datepicker.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/pesquisa.js"></script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Pesquisa de alunos</strong></p>
        </td>
    </tr>
    <tr>
        <td><form id="form1" name="form1" method="post" action="principal.php?acao=resultadoPesquisa">
          <table width="100%" border="0" cellspacing="3" cellpadding="1">
            <tr>
              <td colspan="2"><hr /></td>
            </tr>
            <tr>
              <td width="14%">&nbsp;</td>
              <td width="86%">&nbsp;</td>
            </tr>
            <tr>
              <td><strong>Curso:</strong></td>
              <td><select name="curso" id="curso">
                <?php echo Lumine_Util::buildOptions($cursos,'id','nome', ''); ?>
              </select></td>
            </tr>
            <tr>
              <td><strong>Sexo:</strong></td>
              <td>
              <select name="sexo">
                <option value="A">Ambos</option>
                <option value="M">Masculino</option>
                <option value="F">Feminino</option>
              </select>
              
              </td>
            </tr>
            <tr>
              <td><strong>Período do curso:</strong></td>
              <td><select name="periodo">
                <option value="Q">Qualquer</option>
                <option value="M">Manhã</option>
                <option value="T">Tarde</option>
                <option value="N">Noite</option>
              </select></td>
            </tr>
            <!--   <tr>
            <td><strong>Data Inicial:</strong></td>
            <td><label for="textfield"></label>
              <input type="text" name="data_inicio" id="inicio" class="validate[required]" />
              *</td>
          </tr>
          <tr>
            <td><strong>Data Final:</strong></td>
            <td><input type="text" name="data_fim" id="fim" class="validate[required]" />
              *</td>
          </tr> -->
            <tr>
              <td>&nbsp;</td>
              <td><input type="submit" name="button" id="button" value="pesquisar" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
          </table>
        </form></td>
    </tr>
</table>

