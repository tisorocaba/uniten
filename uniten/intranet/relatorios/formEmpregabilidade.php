<?php
require_once '../util/config.php';
Security::admSecurity();

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'formEmpregabilidade.php', 'Acessou: Pesquisa de Empregabilidade', $_REQUEST);


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

<script src="scripts/formCursoGeral.js"></script>

<table width="100%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Relatórios</strong></p>
        </td>
    </tr>
    <tr>
        <td>
            <form action="resultadoEmpregabilidade.php" method="post" name="form1" id="form1">
              <table width="100%" border="0" cellspacing="3" cellpadding="1">
                    <tr>
                        <td colspan="2"><strong>Emitir relatório de empregabilidade.</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr />
                        </td>
                    </tr>
                        <tr>
                          <td width="28%">&nbsp;</td>
                          <td width="72%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>Data Inicial:</td>
                          <td>
                          <input type="text" name="data_inicio" id="inicio" class="validate[required]" />
                          *</td>
                        </tr>
                        <tr>
                          <td>Data Final:</td>
                          <td><input type="text" name="data_fim" id="fim" class="validate[required]" />
                            *</td>
                        </tr>
                        <tr>
                          <td>Registrado:</td>
                          <td>
                            <select name="registrado" id="registrado" >
                                 <option value="">opcional</option>
                                 <option value="1">Sim</option>
                           	     <option value="0">Não</option>
                            </select>
                          </td>
                        </tr>
                         <tr>
                          <td>Autônomo:</td>
                          <td>
                            <select name="autonomo" id="autonomo" >
                                 <option value="">opcional</option>
                                 <option value="1">Sim</option>
                           	     <option value="0">Não</option>
                            </select>
                          </td>
                        </tr>
                        
                                    <tr  >
                      <td>Estava empregado antes do curso: </td>
                      <td><select name="estavaEmpregado" id="cbEstavaEmpregado" >
                        <option value="">opcional</option>
                        <option value="0" >Não</option>
                        <option value="1" >Sim</option>
                      </select></td>
                    </tr>
                    <tr  style="display:''" id="linhaArea">
                      <td>Era na área referente ao curso: </td>
                      <td><select name="eraArea" id="cbArea" >
                        <option value="">opcional</option>
                        <option value="0" >Não</option>
                        <option value="1" >Sim</option>
                      </select></td>
                    </tr>
                    <tr  style="display:''" id="linhaCursoAjudou">
                      <td>O Curso ajudou ser admintido no emprego atual: </td>
                      <td><select name="cursoAjudou" id="cbCursoAjudou" >
                        <option value="">opcional</option>
                        <option value="0" >Não</option>
                        <option value="1" >Sim</option>
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

