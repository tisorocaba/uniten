<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>UNITEN - SOROCABA</title>
<link rel="stylesheet" href="../css/style_login_mobile.css" type="text/css" />
</head>

<body class="login">

<div id="ad" style="width:100%">

</div>
<div class="loginbox radius">
<h2 style="color:#FFF; text-align:center">Login</h2>
	<div class="loginboxinner radius">
    	<div class="loginheader">
    		
        	<div class="logo"><img src="imagens/logotipo_intranet.gif" width="80"  alt="UNITE"></div>
    	</div><!--loginheader-->
        
        <div class="loginform">
                	
        	<form name="form1" method="post" action="verificaLogin.php">
            	<p>
                	<label for="username" class="bebas">Usuário</label>
                    <input type="text" id="login" name="login" value="" class="radius2" />
                </p>
                <p>
                	<label for="password" class="bebas">Senha</label>
                    <input type="password" id="senha" name="senha"  class="radius2" />
                </p>
                <p>
                	<button class="radius title" name="client_login">Login</button>
                </p>
            </form>
           <a href="reenvia_senha_form.php" id="reenviaSenha">Esqueci minha senha</a>
        </div><!--loginform-->
    </div><!--loginboxinner-->
</div><!--loginbox-->




</body>

</html>
