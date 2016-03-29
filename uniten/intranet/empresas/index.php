<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">
<title>UNITE EMPREGA - Intranet Login</title>
<link href="../intranet.css" rel="stylesheet" type="text/css">
<link media="screen" rel="stylesheet" href="../colorbox.css" />
<script src="../js/jquery-1.5.min.js"></script>
<script src="../colorbox/jquery.colorbox.js"></script>
<script src="scripts/index.js"></script>
<script src="../js/funcoes.js"></script>
</head>

<body>
    <form name="formLogin" id="formLogin" method="post" action="verificaLogin.php">
<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="300" align="right"><img src="../imagens/logotipo_intranet.gif" width="250" height="80" alt="UNITE"></td>
  </tr>
</table>
<table width="378" border="0" align="center" cellpadding="4" cellspacing="1">
  <tr>
    <td colspan="2" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><strong>ACESSO RESTRITO A EMPRESAS CADASTRADAS</strong></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="39%" align="right">CNPJ:</td>
    <td width="61%"><input type="text" name="cnpj" id="cnpj" maxlength="14" onKeyPress="return sonumero(event)"></td>
  </tr>
  <tr>
    <td align="right">SENHA:</td>
    <td><input type="password" name="senha" id="senha"></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>
      <input type="button" name="btLogar" id="btLogar" value="Acessar">
      <input type="button" name="btLogar" id="btRenviarSenha" value="Renviar Senha"></td>
  </tr>
  
  <tr>
    <td colspan="2" align="center"></td>
  </tr>
  <tr>
    <td colspan="2" align="center"></td>
  </tr>
</table>

</form>
</body>

</html>
