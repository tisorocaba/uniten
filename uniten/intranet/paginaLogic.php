<?php
require_once 'util/config.php';
Security::admSecurity();
$obj = new Pagina();
$user = unserialize($_SESSION['USER']);



if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
        case 'gravar' :
            if ($obj->get(@$_POST ['id']) == 0) {
                 msg('ERRO: Não foi possível atualizar essa página!');
            	 gotox("principal.php?acao=paginas");
            } else {
                $msg = "OK: Página alterado com sucesso!";
            }
            logDao::gravaLog($user->login, 'paginaLogic', 'Alterou: conteudo da pagina',$_REQUEST,'','Pagina: '.$_POST ['id']);
            $obj->setFrom($_POST);
            $obj->save();
            msg('Página alterada com sucesso!');
            gotox("principal.php?acao=paginas");
            break;

    }
}