<?php

require_once 'util/config.php';
Security::admSecurity();
$obj = new UniteEmprega();
$user = unserialize($_SESSION['USER']);



//xdebug();
//var_dump($_POST['disciplinas']);
if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
        case 'gravar' :
            if (ValidateCNPJ::execute($_REQUEST['cnpj']) === false) {
                msg("ERRO: CNPJ INVALIDO!");
                gotox("principal.php?acao=uniteempregaEmpresaCadastro");
                die;
            }
            if ($obj->get(@$_POST ['id']) == 0) {
                unset($_POST ['id']);

                $msg = "OK: Empresa incluído com sucesso!";
            } else {
                $obj->removeAll('disciplinas');
                $msg = "OK: Empresa alterado com sucesso!";
            }
            try {
                $obj->setFrom($_POST);
                $obj->save();
                logDao::gravaLog($user->id, 'uniteempregaEmpresaLogic', $_REQUEST ['acao'], $_REQUEST);
                msg($msg);
                gotox("principal.php?acao=uniteemprega");
            } catch (Exception $exc) {
                logDao::gravaLog($user->id, 'uniteempregaEmpresaLogic', $_REQUEST ['acao'], $_REQUEST, $exc);
                msg('ERRO: Não foi possível cadastrar esse empresa');
                gotox("principal.php?acao=uniteemprega");
            }



            break;

        case 'remover' :
            if (!empty($_GET ['id']) && $obj->get($_GET ['id']) == 1) {
                try {
                    $obj->delete();
                    logDao::gravaLog($user->id, 'uniteempregaEmpresaLogic', $_REQUEST ['acao'], $_REQUEST);
                    msg('OK: Empresa removido com sucesso!');
                    gotox("principal.php?acao=uniteemprega");
                } catch (Exception $exc) {
                    logDao::gravaLog($user->id, 'uniteempregaEmpresaLogic', $_REQUEST ['acao'], $_REQUEST, $exc);
                    msg('ATENÇÃO: Não foi possível remover esse empresa devido à informações vinculadas a esse curso \r\n Utilize a opção de desativar');
                    gotox("principal.php?acao=uniteemprega");
                }
            }
            break;
        case 'ativacao' :

            if (!empty($_GET ['id']) && $obj->get($_GET ['id']) == 1) {
                try {

                    $obj->status = $_GET ['ativo'];

                    if ((int) $_GET ['ativo'] === 1) {
                        $senha = geraSenha();
                        $obj->senha = criptografaSenha($senha);
                        enviaSenhaEmpresa($obj->responsavel, $obj->cnpj, $senha, $obj->email);
                    }

                    $obj->update();
                    logDao::gravaLog($user->id, 'uniteempregaEmpresaLogic', $_REQUEST ['acao'], $_REQUEST);
                    gotox("principal.php?acao=uniteemprega");
                } catch (Exception $exc) {
                    logDao::gravaLog($user->id, 'uniteempregaEmpresaLogic', $_REQUEST ['acao'], $_REQUEST, $exc);
                    msg('ATENÇÃO: Não foi possível desativar esse empresa');
                    gotox("principal.php?acao=uniteemprega");
                }
            }
            break;
    }
}