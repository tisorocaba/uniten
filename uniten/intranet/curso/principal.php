<?php
require_once '../util/config.php';
Security::cursoSecurity();
$user = unserialize($_SESSION['USER']);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta   charset=utf-8 />

        <title>UNITE - Intranet</title>

        <link media="screen" rel="stylesheet" href="../colorbox.css" />
        <link media="screen" rel="stylesheet" href="../intranet.css" />
        <script type="text/javascript"  src="../js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript"  src="../js/jquery.maskedinput.js"></script>
        <script type="text/javascript"  src="../js/funcoes.js"></script>
        <script type="text/javascript"  src="../colorbox/jquery.colorbox.js"></script>

    </head>

    <body>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td><img src="../imagens/logotipo_intranet.gif" width="250" height="80" alt="UNITE"></td>
                <td align="right" valign="top"><?php echo $user->nome ?>, voc&ecirc; est&aacute; acessando a Intranet da UNITE.<br>
                    <script language="JavaScript">
				var hoje = new Date()
				
				var dia = hoje.getDate();
				var dias = hoje.getDay();
				var mes = hoje.getMonth();
				var ano = hoje.getFullYear();
                                var hora = hoje.getHours();
                                var min =  hoje.getMinutes();
					if (dia < 10){
						dia = "0" + dia;
					}
					if (ano < 2000){
						ano = "19" + ano;
					}
				
				function CriaArray (n)
				{
				this.length = n
				}
				NomeDia = new CriaArray(7)
				NomeDia[0] = "Domingo"
				NomeDia[1] = "Segunda-feira"
				NomeDia[2] = "Ter�a-feira"
				NomeDia[3] = "Quarta-feira"
				NomeDia[4] = "Quinta-feira"
				NomeDia[5] = "Sexta-feira"
				NomeDia[6] = "S�bado"
				
				NomeMes = new CriaArray(12)
				NomeMes[0] = "janeiro"
				NomeMes[1] = "fevereiro"
				NomeMes[2] = "mar�o"
				NomeMes[3] = "abril"
				NomeMes[4] = "maio"
				NomeMes[5] = "junho"
				NomeMes[6] = "julho"
				NomeMes[7] = "agosto"
				NomeMes[8] = "setembro"
				NomeMes[9] = "outubro"
				NomeMes[10] = "novembro"
				NomeMes[11] = "dezembro"
				
				document.write ("Sorocaba, " + dia + " de " + NomeMes[mes] + " de " + ano);
										
				</script> <?php //echo date("H:i")?>
                    </br></td>
                <td width="50" align="right" valign="top"><a href="sair.php" class="sair"><img src="../imagens/icon_logout.gif" alt="Logout" width="30" height="30" border="0"><br>
                        SAIR</a></td>
            </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="10">
            <tr>
                <td width="150" valign="top">

                    <?php include('menu.php') ?>

                </td>
                <td valign="top">

                    <?php
                    try {
                        if (!empty($_REQUEST['acao'])) {
                            $file = $_REQUEST['acao'] . ".php";
                            if (file_exists($file)) {
                                include($file);
                            }else{
                                die('ERRO: Não foi possível acessar a página desejada');
                            }
                            
                        } else {
                            include("relatoriosClasses.php");
                        }
                    } catch (Exception $exc) {

                        die('ERRO: Não foi possível acessar a página desejada');
                    }
                    ?>

                </td>
            </tr>
        </table>
        <p align="center"><a href="http://www.splicenet.com.br" target="_blank" class="splicenet">Desenvolvimento SpliceNet &copy;</a></p>
    </body>
</html> 
