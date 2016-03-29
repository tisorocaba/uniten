<?php
require_once 'util/config.php';
$obj = new Empresa();
$user = unserialize($_SESSION['USER']);

Security::admSecurity();

if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
        case 'gravar' :
            if ($obj->get(@$_POST ['id']) == 0) {
                unset($_POST ['id']);
                if ($obj->get('nome', $_POST ['nome'])) {
                    msg("ERRO: Já existe uma empresa cadastrada com esse nome!");
                    gotox("principal.php?acao=empresaCadastro");
                    die;
                }
                $msg = "OK: Empresa incluída com sucesso!";
                $msgLog = "Gravou: nova empresa";
            } else {
                $msg = "OK: Empresa alterada com sucesso!";
                $_POST['dataAtualizacao'] = time();
                $msgLog = "Alterou: empresa";
            }
            try {
                $obj->setFrom($_POST);
                $obj->save();
                logDao::gravaLog($user->login, 'empresaLogic', $msgLog, $_REQUEST, '', 'Empresa: ' . $obj->id);
                msg($msg);
                gotox("principal.php?acao=empresas");
            } catch (Exception $exc) {
               
                logDao::gravaLog($user->login, 'empresaLogic', 'ERRO(gravar)', $_REQUEST, $exc);
                msg('ERRO: Não foi possível cadastrar esse empresa');
                gotox("principal.php?acao=empresas");
            }

            break;

        case 'remover' :
            if (!empty($_GET ['id']) && $obj->get($_GET ['id']) == 1) {
                try {
                    $obj->delete();
                      logDao::gravaLog($user->login, 'empresaLogic', 'Removeu: empresa', $_REQUEST,'','Empresa: '.$_GET ['id']);
              
                    msg('OK: empresa removida com sucesso!');
                    gotox("principal.php?acao=empresas");
                } catch (Exception $exc) {
                    logDao::gravaLog($user->login, 'empresaLogic', 'ERRO(remover)', $_REQUEST, $exc);
                    msg('ATENÇÃO: Não foi possível remover essa empresa devido à informações vinculadas a ela \r\n Utilize a opção de desativar');
                    gotox("principal.php?acao=empresas");
                }
            }
            break;
        case 'ativacao' :
            if (!empty($_GET ['id']) && $obj->get($_GET ['id']) == 1) {
                  try {
                    $obj->ativo = $_GET ['ativo'];
                    $obj->update();
                      logDao::gravaLog($user->login, 'empresaLogic', 'Alterou: status ativar da empresa ', $_REQUEST,'','Professor: '.$_GET ['id'].' Status: '.$_GET ['ativo']);
                      gotox("principal.php?acao=empresas");
                } catch (Exception $exc) {
                    logDao::gravaLog($user->login, 'empresaLogic', 'ERRO(ativacao)', $_REQUEST, $exc);
                    msg('ATENÇÃO: Não foi possível desativar essa empresa');
                    gotox("principal.php?acao=empresas");
                }
            }
            break;
    }
}