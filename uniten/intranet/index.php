<?php
include './util/mobile/Mobile_Detect.php';
$detect = new Mobile_Detect;

// Any mobile device (phones or tablets).
if ($detect->isMobile()) {
    die("<script>self.location='loginMobile.php'</script>");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="robots" content="noindex">
        <title>UNITE - Intranet Login</title>
        <link href="intranet.css" rel="stylesheet" type="text/css">
        <link media="screen" rel="stylesheet" href="colorbox.css" />
        <script src="js/jquery-1.5.min.js"></script>
        <script src="colorbox/jquery.colorbox.js"></script>
        <script src="scripts/index.js"></script>
    </head>

    <body>
        <form name="form1" method="post" action="verificaLogin.php">
            <table border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="300" align="right"><img src="imagens/logotipo_intranet.gif" width="250" height="80" alt="UNITE"></td>
                </tr>
            </table>
            <table width="301" border="0" align="center" cellpadding="4" cellspacing="1">
                <tr>
                    <td colspan="2" align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>Login do sistema de Intranet da UNITEN</strong></td>
                </tr>
                <tr>
                    <td align="right">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="39%" align="right">Usuário:</td>
                    <td width="61%"><input type="text" name="login" id="login"></td>
                </tr>
                <tr>
                    <td align="right">Senha:</td>
                    <td><input type="password" name="senha" id="senha"></td>
                </tr>
                <tr>
                    <td align="right">&nbsp;</td>
                    <td><input type="submit" name="button" id="btLogar" value="Entrar"></td>
                </tr>
                <tr>
                    <td align="right">&nbsp;</td>
                    <td><a href="reenvia_senha_form.php" id="reenviaSenha">Esqueci minha senha</a></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><a href="reenvia_senha_form.php"></a></td>
                </tr>
            </table>
            <p>&nbsp;</p>
        </form>
    </body>

</html>
