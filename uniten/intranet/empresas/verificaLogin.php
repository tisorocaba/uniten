<?php

require_once '../util/config.php';


$obj = new UniteEmprega();
$senha = criptografaSenha($obj->escape($_POST['senha']));
$login = $obj->escape($_POST['cnpj']);
$islogin = $obj->alias('u')->where('u.cnpj=? and senha=? and status = 1', $login, $senha)->find();



if ($islogin === 1) {
    session_regenerate_id();
    $empresa = new UniteEmprega();
    $empresa->get('cnpj', $login);
    $_SESSION['EMPRESA'] = serialize($empresa);
    
      
    $browser = getBrowser();
    $_REQUEST['brouser'] = $browser['name'];
    $_REQUEST['version'] = $browser['version'];
    
    
    //logDao::gravaLog($user->id, 'verificando o login', 'loginOK',$_REQUEST);
    gotox('principal.php');
   
} else {
    logDao::gravaLog(-1, 'verificando o login', 'loginERRO',$_REQUEST);
    msg('ERRO: CNPJ ou senha invalido!!');
    gotox('index.php');
}
?>