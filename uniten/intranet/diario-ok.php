<?php
require_once 'util/config.php';
Security::admSecurity();
$cod = @$_SESSION['CODAGENDA'];
unset($_SESSION['CODAGENDA']);
unset($_SESSION['CODDIARIO']);


?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="intranet.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Diário de Classe</strong></p>
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="3" cellpadding="1">
                    <tr>
                        <td colspan="2"><strong>Confirmação</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr />
                        </td>
                    </tr>
                    <tr>
                        <td width="42%">&nbsp;</td>
                        <td width="58%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center">Diário de classe inserido com sucesso!!!</td>
                        </tr>
               
                <tr>
                    <td colspan="2">&nbsp;
                    
                     </td>
                </tr>
                <tr>
                    <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;&nbsp;&nbsp;
                  <input name="Continuar" type="button" value="Voltar" onclick="self.location='diarios.php?agenda=<?php echo $cod?>'"  /></td>
                </tr>
            </table>

        </td>
    </tr>
</table>

<p>&nbsp;</p>
