<?php
require_once '../util/config.php';
Security::cursoSecurity();
$obj = new Usuario();
$user = unserialize($_SESSION['USER']);


if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
         

        case 'alterarsenha' :
            if (!empty($_REQUEST ['id']) && $obj->get($_REQUEST ['id']) == 1) {
                try {
                   
                    $obj->senha =  criptografaSenha($_REQUEST ['senha']);
                    $obj->empresa = $_REQUEST ['empresa'];
                    $obj->save();
                    logDao::gravaLog($user->login, 'usuarioLogic','Alterou: senha de acesso', $_REQUEST);
                    msg('OK: Senha alterada com sucesso!');
                    gotox("principal.php?acao=senhaCadastro");
                } catch (Exception $exc) {
                    logDao::gravaLog($user->login, 'usuarioLogic', $_REQUEST ['acao'], $_REQUEST, $exc);
                    msg('ATENÇÃO: Não foi possível alterar a senha');
                    gotox("principal.php?acao=senhaCadastro");
                }
            }
            break;
    }
}