<?php
require_once 'util/config.php';
Security::admSecurity();
$obj = new Feriado();
$user = unserialize($_SESSION['USER']);

//xdebug();

if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
        case 'gravar' :
            if ($obj->get(@$_POST ['id']) == 0) {
                unset($_POST ['id']);
                $msg = "OK: Feriado incluído com sucesso!";
                $msgLog = "Gravou: novo feriado";
            } else {
                $obj->removeAll('disciplinas');
                $msg = "OK: Feriado alterado com sucesso!";
                $msgLog = "Alterou:  feriado";
            }
            try{
                 $obj->setFrom($_POST);
                 $obj->save();
            	 logDao::gravaLog($user->login, 'feriadoLogic',$msgLog , $_REQUEST,'','Feriado: '.$obj->id);
                 msg($msg);
                 gotox("principal.php?acao=feriados");

            }catch (Exception $exc) {
                 logDao::gravaLog($user->id, 'feriadoLogic', 'ERRO(gravar)',$_REQUEST,$exc);
                 msg('ERRO: Não foi possível cadastrar esse feriado');
                 gotox("principal.php?acao=feriados");
            }
            break;

        case 'remover' :
            if (!empty($_GET ['id']) && $obj->get($_GET ['id']) == 1) {
                try {
                    $obj->delete();
                    logDao::gravaLog($user->login, 'feriadoLogic', 'Removeu: feriado',$_REQUEST,'','Curso: '.$_GET ['id']);
                    msg('OK: curso removido com sucesso!');
                    gotox("principal.php?acao=feriados");

                } catch (Exception $exc) {
                    logDao::gravaLog($user->login, 'feriadoLogic','ERRO(remover)',$_REQUEST,$exc);
                    msg('ATENÇÃO: Não foi possível remover esse feriado devido à informações vinculadas a esse curso \r\n Utilize a opção de desativar');
                    gotox("principal.php?acao=feriados");
                }
            }
            break;
    }
}