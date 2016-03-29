<?php
require_once '../util/config.php';
Security::cursoSecurity();
$obj = new Usuario();
$user = unserialize($_SESSION['USER']);


if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
         case 'gravar' :
            if ($obj->get(@$_POST ['id']) == 0) {
                unset($_POST ['id']);
                if ($obj->get('email', $_POST ['email'])) {
                    msg("ERRO: Já existe um usuario cadastrado com esse email!");
                    gotox("principal.php?acao=usuarioCadastro");
                    die;
                }
                /************************ gerando a senha ************************ */
                $tempSenha = geraSenha();
                $_POST['senha'] = criptografaSenha($tempSenha);
                /**************************************************************** */

                /*************************  gerando o login *********************** */
                $user = new Usuario();
                $user->alias('u')->where('u.empresa = ? ', $_POST['empresa'])->find();
                $totalUser = $user->count();
                $novoLogin = $_POST['empresa'] . "" . str_pad($totalUser, 2, "0", STR_PAD_LEFT);
                $_POST['login'] = $novoLogin;
                /*                 * **************************************************************** */
                $_POST['ativo'] = 1;
                $_POST['dataCadastro'] = time();
                $msg = "OK: Usuário incluído com sucesso!";
            } else {
                $obj->removeAll('menus');
                $msg = "OK: Usuário alterado com sucesso!";
            }
            try {
                $obj->setFrom($_POST);
                $obj->menus = empty($_POST['menu']) ? array() : $_POST['menu'];
                $obj->save();

                if (!empty($_POST['senha'])) {
                    enviaSenhaUsuario($obj->nome, $novoLogin, $tempSenha, $obj->email);
                }


                logDao::gravaLog($user->login, 'usuarioLogic', $_REQUEST ['acao'], $_POST);
                msg($msg);
                gotox("principal.php?acao=usuarios");
            } catch (Exception $exc) {
                logDao::gravaLog($user->login, 'usuarioLogic', $_REQUEST ['acao'], $_POST, $exc);
                msg('ERRO: Não foi possível cadastrar esse usuário');
                gotox("principal.php?acao=usuarios");
            }

            break;

        case 'remover' :
            if (!empty($_GET ['id']) && $obj->get($_GET ['id']) == 1) {
                try {
                    $obj->removeAll('menus');
                    $obj->delete();
                    logDao::gravaLog($user->login, 'usuarioLogic', $_REQUEST ['acao'], $_REQUEST);
                    msg('OK: Usuário removido com sucesso!');
                    gotox("principal.php?acao=usuarios");
                } catch (Exception $exc) {
                    logDao::gravaLog($user->login, 'professorLogic', $_REQUEST ['acao'], $_REQUEST, $exc);
                    msg('ATENÇÃO: Não foi possível remover esse usuário devido à informações vinculadas a ele \r\n Utilize a opção de desativar');
                    gotox("principal.php?acao=usuarios");
                }
            }
            break;

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