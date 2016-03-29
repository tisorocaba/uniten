<?php
require_once 'util/config.php';
Security::admSecurity();
$obj = new Local();
$user = unserialize($_SESSION['USER']);


if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
        case 'gravar' :
            if ($obj->get(@$_POST ['id']) == 0) {
                unset($_POST ['id']);
                if($obj->get('local',$_POST ['local'])){
                    msg("ERRO: Já existe um local cadastrado com esse nome!");
                    gotox("principal.php?acao=localCadastro");
                    die;
                }
                $msg = "OK: Local incluído com sucesso!";
                $msgLog = "Gravou: novo local";
            } else {
                $msg = "OK: Local alterado com sucesso!";
                $msgLog = "Alterou: local";
            }
            try{
                 $obj->setFrom($_POST);
                 $obj->save();
                 logDao::gravaLog($user->login, 'localLogic', $msgLog,$_REQUEST,'','Local: ',$obj->id);
                 msg($msg);
                 gotox("principal.php?acao=locais");

            }catch (Exception $exc) {
                 logDao::gravaLog($user->id, 'localLogic', 'ERRO(gravar): Sistema emitiu erro',$_REQUEST,$exc);
                 msg('ERRO: Não foi possível cadastrar esse local');
                 gotox("principal.php?acao=locais");
            }
            
           
            
            break;

        case 'remover' :
            if (!empty($_GET ['id']) && $obj->get($_GET ['id']) == 1) {
                try {
                    $obj->delete();
                    logDao::gravaLog($user->login, 'localLogic', 'Removeu: local',$_REQUEST,'','Local: '.$_GET ['id']);
                    msg('OK: local removido com sucesso!');
                    gotox("principal.php?acao=locais");

                } catch (Exception $exc) {
                    logDao::gravaLog($user->login, 'localLogic', 'ERRO(remover): Sistema emitiu erro',$_REQUEST,$exc);
                    msg('ATENÇÃO: Não foi possível remover esse local devido à informações vinculadas a esse local \r\n Utilize a opção de desativar');
                    gotox("principal.php?acao=locais");
                }
            }
            break;
        case 'ativacao' :
            if (!empty($_GET ['id']) && $obj->get($_GET ['id']) == 1) {
                try {
                    $obj->ativo = $_GET ['ativo'];
                    $obj->update();
                     logDao::gravaLog($user->login, 'localLogic', 'Alterou: status de ativo', $_REQUEST, '', 'Local: '.$_GET ['id'].'Status: ' . $_GET ['ativo']);
                    gotox("principal.php?acao=locais");
                } catch (Exception $exc) {
                    logDao::gravaLog($user->id, 'localLogic', 'ERRO(ativacao): Sistema emitiu um erro', $_REQUEST, $exc);
                     msg('ATENÇÃO: Não foi possível desativar esse local');
                    gotox("principal.php?acao=locais");
                }
            }
            break;
    }
}