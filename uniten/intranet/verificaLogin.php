<?php

require_once 'util/config.php';


$obj = new Usuario();
$senha = criptografaSenha($obj->escape($_POST['senha']));
$login = $obj->escape($_POST['login']);
$islogin = $obj->alias('u')->where('u.login=? and senha=? and ativo = 1', $login, $senha)->find();

if ($islogin === 1) {
    session_regenerate_id();
    $user = new Usuario();
    $user->get('login', $login);
    $_SESSION['USER'] = serialize($user);
    
    // capturando o browse
   
    
    /*$browser = getBrowser();
    $_REQUEST['brouser'] = $browser['name'];
    $_REQUEST['version'] = $browser['version'];*/
    
        
   // logDao::gravaLog($user->login, 'verificaLogin', 'loginOK',$_REQUEST);
    
    
   
    
    switch ($user->empresa->status) {
        case 1:
            gotox('prova/principal.php');
            break;
        case 2:
            gotox('cursos2/principal.php');
            break;
        default:
            gotox('principal.php');
            break;
    }
} else {
    logDao::gravaLog(-1, 'verificaLogin', 'Erro(Autenticacao)',$_REQUEST);
    msg('ERRO: Usuário ou senha invalido!!');
    gotox('index.php');
}
?>