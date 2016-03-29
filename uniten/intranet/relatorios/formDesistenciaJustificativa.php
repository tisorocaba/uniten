<?php
require_once '../util/config.php';
Security::admSecurity();

$user = unserialize($_SESSION['USER']);


logDao::gravaLog($user->login, 'formCursoGeral.php', 'Acessou: Pesquisa de Curso Geral', $_REQUEST);
$locais = new Local();
$locais->alias('l')->where('l.ativo=1')->order('l.local ASC')->find();

$programas = new Projeto();
$programas->alias('P')->where('P.ativo=1')->order('P.nome ASC')->find();

$cursos = new Curso();
$cursos->alias('c')->where('c.ativo=1')->order('c.nome ASC')->find();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../intranet.css" rel="stylesheet" type="text/css">
<link href="../css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">
<link href="../js/css/jquery-ui.css" rel="stylesheet" type="text/css">
<link href="../js/css/ui.theme.css" rel="stylesheet" type="text/css">
<script src="../js/jquery-1.6.2.min.js"></script>
<script src="../js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.ui.core.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.ui.widget.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.ui.datepicker.js" type="text/javascript" charset="utf-8"></script>

<script src="scripts/formDesistenciaJustificativa.js"></script>

<table width="100%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Relatórios</strong></p>
        </td>
    </tr>
    <tr>
        <td>
            <form action="resultadoDesistenciaJustificativa.php" method="post" name="form1" id="form1">
              <table width="100%" border="0" cellspacing="3" cellpadding="1">
                    <tr>
                        <td colspan="2"><strong>Emitir relatório justificativa de desistência.</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr />
                        </td>
                    </tr>
                        <tr>
                          <td width="10%">&nbsp;</td>
                          <td width="90%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td><strong>Data Inicial:</strong></td>
                          <td>
                          <input type="text" name="data_inicio" id="inicio" class="validate[required]" />
                          *</td>
                        </tr>
                        <tr>
                          <td><strong>Data Final:</strong></td>
                          <td><input type="text" name="data_fim" id="fim" class="validate[required]" />
                            *</td>
                        </tr>
                        
                        <tr>
                          <td><strong>Filtrar por :</strong></td>
                          <td>
                              <input type="radio" name="filtro" id="filtroL" value="L" class="cRadio"> Local 
                              <input type="radio" name="filtro" id="filtroP" value="P" class="cRadio"> Programa
                              <input type="radio" name="filtro" id="filtroC" value="C" class="cRadio"> Cursos
                          </td>
                        </tr>
                        
                        
                        <tr id="linhaLocal" style="display: none">
                          <td><strong>Local:</strong></td>
                          <td>
                            <select name="local" id="local" >
                                 <option value="0">TODOS...</option>
                           		<?php echo Lumine_Util::buildOptions($locais,'id','local', ''); ?>
                            </select>
                          </td>
                        </tr>
                        
                        <tr id="linhaPrograma" style="display: none">
                          <td><strong>Programa:</strong></td>
                          <td>
                            <select name="programa" id="programa" >
                              <option value="0">TODOS...</option>
                              <?php echo Lumine_Util::buildOptions($programas,'id','nome', ''); ?>
                            </select>
                          </td>
                        </tr>
                        
                        <tr id="linhaCurso" style="display: none">
                          <td><strong>Curso:</strong></td>
                          <td><select name="curso" id="curso" >
                            <option value="0">TODOS...</option>
                            <?php echo Lumine_Util::buildOptions($cursos,'id','nome', ''); ?>
                          </select></td>
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

