<?php
require_once '../util/config.php';
Security::admSecurity();

$locais = new Local();
$locais->alias('l')->where('l.ativo=1')->order('l.local ASC')->find();

$cursos = new Curso();
$cursos->alias('c')->order('c.nome ASC')->find();

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'formDesistencia.php', 'Acessou: Pesquisa de relatório de percentual de desistencia', $_REQUEST);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../intranet.css" rel="stylesheet" type="text/css">
<link href="../css/validationEngine.jquery.css" rel="stylesheet" type="text/css">
<link href="../js/css/jquery-ui.css" rel="stylesheet" type="text/css">
<link href="../js/css/ui.theme.css" rel="stylesheet" type="text/css">
<script src="../js/jquery-1.6.2.min.js"></script>
<script src="../js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.ui.core.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.ui.widget.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.ui.datepicker.js" type="text/javascript" charset="utf-8"></script>

<script src="scripts/formAlunoGeral.js"></script>

<table width="100%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Relatórios</strong></p>
        </td>
    </tr>
    <tr>
        <td>
            <form action="resultadoDesistencia.php" method="post" name="form1" id="form1">
              <table width="100%" border="0" cellspacing="3" cellpadding="1">
                    <tr>
                        <td colspan="2"><strong>Emitir relatório de percentual de desistência.</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr />
                        </td>
                    </tr>
                        <tr>
                          <td width="10%"><strong>Local:</strong></td>
                          <td width="90%">
                          
                           		<select name="local" id="local" >
								 <?php echo Lumine_Util::buildOptions($locais,'id','local', @$_POST['local']['id']); ?>
                               </select>
                          
                          </td>
                        </tr>
                        <tr>
                          <td><strong>Curso:</strong></td>
                          <td>
                           <select name="curso" id="curso">
                                 <option value="T">TODOS</option>
								 <?php echo Lumine_Util::buildOptions($cursos,'id','nome', (int)$_POST['curso']['id']); ?>
                            </select>
                           </td>
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
                          <td>Obs: Somente serão computados as agendas finalizadas</td>
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

