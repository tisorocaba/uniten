<?php
if (!empty($_POST)) {
    
    require_once 'util/config.php';
   
    $obj = new Usuario();
    $email = $obj->escape($_POST['email']);
   
    //xdebug();
    if ($obj->get('email', $email) == 1 && $obj->ativo ==1) {
        $tempSenha = geraSenha();
        $senha = criptografaSenha($tempSenha);
        $obj->_getConnection()->executeSQL('UPDATE usuario SET senha = "'.$senha.'" WHERE email = "'.$email.'" ');
        enviaSenhaUsuario($obj->nome, $obj->login, $tempSenha, $obj->email);
        msg('OK: Senha enviada com sucesso');
    }else{
        msg('O e-mail informado não está cadastrado ou o cadastro está inativo');
    }
}
?>


<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="robots" content="noindex">
        <title>UNITEN - Intranet Login</title>
        <link href="css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">
        <link href="intranet.css" rel="stylesheet" type="text/css">
        <link media="screen" rel="stylesheet" href="colorbox.css" />
        <script src="js/jquery-1.5.min.js"></script>
        <script src="colorbox/jquery.colorbox.js"></script>
        <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>

        <script src="scripts/reenvia_senha_form.js"></script>
    </head>

    <body>
        <form name="form1" id="form1" method="post" action="reenvia_senha_form.php">
            <table width="420" border="0" align="center" cellpadding="4" cellspacing="1">
                <tr>
                    <td colspan="2" align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><strong>Reenvio de Senha</strong></td>
                </tr>
                <tr>
                    <td align="right">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="21%" align="right">Email:</td>
                    <td width="79%"><input name="email" type="text" id="email" size="50" maxlength="150" class="validate[required,custom[email]]"></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><input type="submit" name="button" id="btLogar" value="Enviar"></td>
                </tr>
            </table>
            <p>&nbsp;</p>
        </form>
    </body>

</html>
