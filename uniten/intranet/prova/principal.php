<?php
require_once '../util/config.php';
Security::provaSecurity();
$user = unserialize($_SESSION['USER']);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset=utf-8 />

        <title>UNITE - Intranet</title>
        
        <link media="screen" rel="stylesheet" href="../colorbox.css" />
        <link media="screen" rel="stylesheet" href="../intranet.css" />
        <script src="../js/jquery-1.6.2.min.js"></script>
        <script src="../js/jquery.maskedinput.js"></script>
        <script src="../js/funcoes.js"></script>
        <script src="../colorbox/jquery.colorbox.js"></script>
        
	</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="../imagens/logotipo_intranet.gif" width="250" height="80" alt="UNITE"></td>
    <td align="right" valign="top"><?php echo $user->nome?>, voc&ecirc; est&aacute; acessando a Intranet da UNITE.</td>
    <td width="50" align="right" valign="top"><a href="sair.php" class="sair"><img src="../imagens/icon_logout.gif" alt="Logout" width="30" height="30" border="0"><br>
      SAIR</a></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td width="150" valign="top">
    
    <?php include('menu.php')?>
    
    </td>
    <td valign="top">

    <?php 
		
		include("agendacursos.php");
		
    ?>
    
    </td>
  </tr>
</table>
<p align="center"><a href="http://www.splicenet.com.br" target="_blank" class="splicenet">Desenvolvimento SpliceNet &copy;</a></p>
</body>
</html>
