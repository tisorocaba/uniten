<?php
require_once 'util/config.php';
Security::admSecurity();

$empresas = new Empresa ();
$empresas->alias ('p')->order ('p.nome ASC')->find ();
logDao::gravaLog($user->id, 'gastos', $_REQUEST ['acao'], $_REQUEST);

logDao::gravaLog($user->login, 'gastos', 'Acessou: Controle de Gastos',$_REQUEST);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="intranet.css" rel="stylesheet" type="text/css">
<link href="css/validationEngine.jquery.css" rel="stylesheet" type="text/css">

<link href="js/css/jquery-ui.css" rel="stylesheet" type="text/css">
<link href="js/css/ui.theme.css" rel="stylesheet" type="text/css">

<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>



<script src="js/jquery.ui.core.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.ui.widget.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.ui.datepicker.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/gastos.js"></script>
<table width="100%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Controle de Gastos</strong></p>
        </td>
    </tr>
    <tr>
        <td>
            <form action="principal.php?acao=gastosPesquisa" method="post" name="form1" id="form1">
              <table width="100%" border="0" cellspacing="3" cellpadding="1">
                    <tr>
                        <td colspan="2"><strong>Emitir relatório de gastos com cursos.</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr />
                        </td>
                    </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td width="10%"><strong>Empresa:</strong></td>
                          <td width="90%"><select name="empresa" id="cbEmpresas">
                            <?php echo Lumine_Util::buildOptions($empresas, 'id', 'fantasia', $cbemp); ?>
                          </select></td>
                        </tr>
                        <tr>
                          <td><strong>Data Inicial:</strong></td>
                          <td><label for="textfield"></label>
                          <input type="text" name="data_inicio" id="inicio" class="validate[required]" />
                          *</td>
                        </tr>
                        <tr>
                          <td><strong>Data Final:</strong></td>
                          <td><input type="text" name="data_fim" id="fim" class="validate[required]" />
                            *</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><input type="submit" name="button" id="button" value="Emitir" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td> * campos obrigatórios</td>
                        </tr>
                
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
              </table>
            </form>

        </td>
    </tr>
</table>

