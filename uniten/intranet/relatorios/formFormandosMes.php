<?php
require_once '../util/config.php';
require_once '../dao/agendaCursoDao.php';
Security::admSecurity();
$user = unserialize($_SESSION['USER']);

$agendaDao = new AgendaCursoDao();


logDao::gravaLog($user->login, 'formCursoGeral.php', 'Acessou: Pesquisa de Curso Geral', $_REQUEST);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../intranet.css" rel="stylesheet" type="text/css">
<link href="../css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">
<link href="../js/css/jquery-ui.css" rel="stylesheet" type="text/css">
<link href="../js/css/ui.theme.css" rel="stylesheet" type="text/css">
<script src="../js/jquery-1.6.2.min.js"></script>

<table width="100%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Relatórios</strong></p>
        </td>
    </tr>
    <tr>
        <td>
            <form action="resultadoFormandosMes.php" method="post" name="form1" id="form1">
              <table width="100%" border="0" cellspacing="3" cellpadding="1">
                    <tr>
                        <td colspan="2"><strong>Emitir relatório de cursos.</strong></td>
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
                          <td><strong>Mês :</strong></td>
                          <td>
                            <select name="mes" class="validate[requerid] checkbox">
                            
                              <option value="1">Janeiro</option>
                              <option value="2">Fevereiro</option>
                              <option value="3">Março</option>
                              <option value="4">Abril</option>
                              <option value="5">Maio</option>
                              <option value="6">Junho</option>
                              <option value="7">Julho</option>
                              <option value="8">Agosto</option>
                              <option value="9">Setembro</option>
                              <option value="10">Outubro</option>
                              <option value="11">Novembro</option>
                              <option value="12">Dezembro</option>
                             
                            </select>
                            /
                            <select name="ano" class="validate[requerid] checkbox">
                            <?php foreach ($agendaDao->agendaAnos() as $ano) {?>
                               <option value="<?php echo $ano?>"><?php echo $ano?></option>
                           <?php } ?>
                          </select>
                        
                          </td>
                        </tr>
                        
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><input type="submit" name="button" id="button" value="Emitir" /></td>
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

