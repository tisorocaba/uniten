<?php
require_once 'util/config.php';
Security::admSecurity();
$obj = new Disciplina();
$user = unserialize($_SESSION['USER']);


if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
        case 'gravar' :
            if ($obj->get(@$_POST ['id']) == 0) {
                unset($_POST ['id']);
                if ($obj->get('nome', $_POST ['nome'])) {
                    msg("ERRO: Já existe uma disciplina cadastrada com esse nome!");
                    gotox("principal.php?acao=disciplinaCadastro");
                    die;
                }
                $msg = "OK: Disciplina incluída com sucesso!";
                $msgLog = "Gravou: nova disciplina";
            } else {
                $msg = "OK: Disciplina alterada com sucesso!";
                $_POST['dataAtualizacao'] = time();
                $msgLog = "Alterou: disciplina";
            }
            try {
                $obj->setFrom($_POST);
                $obj->save();
                logDao::gravaLog($user->login, 'disciplinaLogic',$msgLog , $_REQUEST,'','Disciplina: '.$obj->id);
                msg($msg);
                gotox("principal.php?acao=disciplinas");
            } catch (Exception $exc) {
                logDao::gravaLog($user->id, 'disciplinaLogic', $_REQUEST ['acao'], $_REQUEST, $exc);
                msg('ERRO: Não foi possível cadastrar esse disciplina');
                gotox("principal.php?acao=disciplinas");
            }

            break;

        case 'remover' :
            if (!empty($_GET ['id']) && $obj->get($_GET ['id']) == 1) {
                try {
                    $obj->delete();
                    logDao::gravaLog($user->login, 'disciplinaLogic', 'Removeu: disciplina',$_REQUEST,'','disciplina: '.$_GET ['id']);
               
                    msg('OK: Disciplina removida com sucesso!');
                    gotox("principal.php?acao=disciplinas");
                } catch (Exception $exc) {
                    logDao::gravaLog($user->id, 'disciplinaLogic', 'ERRO(remover)', $_REQUEST, $exc);
                    msg('ATENÇÃO: Não foi possível remover essa Disciplina devido à informações vinculadas a ela \r\n Utilize a opção de desativar');
                    gotox("principal.php?acao=disciplinas");
                }
            }
            break;
        case 'ativacao' :
            if (!empty($_GET ['id']) && $obj->get($_GET ['id']) == 1) {
                try {
                    $obj->ativo = $_GET ['ativo'];
                    $obj->update();
                    logDao::gravaLog($user->login, 'disciplinaLogic', 'Alterou: status de ativo',$_REQUEST,'','Disciplina: '.$_GET ['id'].' status: '.$_GET ['ativo']);
                    gotox("principal.php?acao=disciplinas");
                } catch (Exception $exc) {
                    logDao::gravaLog($user->id, 'disciplinaLogic', 'ERRO(ativacao)', $_REQUEST, $exc);
                    msg('ATENÇÃO: Não foi possível desativar essa Disciplina');
                    gotox("principal.php?acao=disciplinas");
                }
            }
            break;
    }
}