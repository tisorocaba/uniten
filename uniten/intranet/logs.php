<?php
require_once 'util/config.php';
Security::admSecurity();

$empresas = new Empresa ();
$empresas->alias ('e')->order ('e.nome ASC')->find ();
//logDao::gravaLog($user->id, 'controleVT', $_REQUEST ['acao'], $_REQUEST);
logDao::gravaLog($user->login, 'logs', 'Acessou: pesquisa de logs', $_REQUEST);



?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="intranet.css" rel="stylesheet" type="text/css">
<link href="../css/validationEngine.jquery.css" rel="stylesheet" type="text/css">

<link href="js/css/jquery-ui.css" rel="stylesheet" type="text/css">
<link href="js/css/ui.theme.css" rel="stylesheet" type="text/css">

<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>



<script src="js/jquery.ui.core.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.ui.widget.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.ui.datepicker.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/logs.js"></script>
<table width="100%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Log de Acesso</strong></p>
        </td>
    </tr>
    <tr>
        <td>
            <form action="principal.php?acao=logsPesquisa" method="post" name="form1" id="form1">
              <table width="100%" border="0" cellspacing="3" cellpadding="1">
                        <tr>
                          <td colspan="2"> <hr /></td>
                        </tr>
                        <tr>
                          <td colspan="2">O Sistema  armazena somente logs dos últimos 3 meses</td>
                        </tr>
                        <tr>
                          <td width="10%"><strong>Empresa:</strong></td>
                          <td width="90%">
                          <select name="empresa" id="cbEmpresas" class="validate[required]">
                                  <option value="">Selecione...</option>
                                          
                            <?php echo Lumine_Util::buildOptions($empresas, 'id', 'fantasia', ''); ?>
                          </select>
                          <span id="lbUsuarios"></span>
                          </td>
                        </tr>
                        <tr id="linhaUsuario" >
                          <td><strong>Usuários:</strong></td>
                          <td>
                          <span id="spanUsuario">
                          <select name="usuario" id="usuario" class="validate[required]">
                          <option value="">Selecione...</option>*
                          </select>
                          </span>
                          *</td>
                        </tr>
                        <tr>
                          <td><strong>Ações:</strong></td>
                          <td><label for="select"></label>
                            <select name="acao1" id="acao1">
                              <option value=''>TODAS</option>
                              <option value="LoginOK">LOGIN</option>
                              <option value="Acessou">ACESSOU</option>
                              <option value="Visualizou">VISUALIZOU</option>
                              <option value="Removeu">REMOVEU</option>
                              <option value="Gravou">GRAVOU</option>
                              <option value="Exportou">EXPORTOU</option>
                          </select></td>
                        </tr>
                        <tr>
                          <td><strong>Data Inicial:</strong></td>
                          <td><label for="textfield"></label>
                          <input type="text" name="data_inicio" id="inicio" class="validate[required]" value="<?php echo @data_br($_SESSION['DATAINICIO'])?>" />
                          *</td>
                        </tr>
                        <tr>
                          <td><strong>Data Final:</strong></td>
                          <td><input type="text" name="data_fim" id="fim" class="validate[required]" value="<?php echo @data_br($_SESSION['DATAFINAL'])?>" />
                            *</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><input type="submit" name="button" id="button" value="Pesquisar" /></td>
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

