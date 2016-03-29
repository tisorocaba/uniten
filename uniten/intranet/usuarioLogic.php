<?php
require_once 'util/config.php';
Security::admSecurity();
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



                /*                 * ********************** gerando a senha ************************ */
                $tempSenha = geraSenha();
                $_POST['senha'] = criptografaSenha($tempSenha);
                /*                 * ************************************************************** */

              
                /*************************  gerando o login *********************** */
                $userCont = new Usuario();
                $userCont->alias('u')->order(' id DESC')->where('u.empresa = ? ', $_POST['empresa'])->limit(0,1)->find();
                $userCont->current();
                $novoLogin = $_POST['empresa'] . "00" . str_pad($userCont->id+1, 3, "0", STR_PAD_LEFT);
                $_POST['login'] = $novoLogin;
               
                
                /****************************************************************** */
                $_POST['ativo'] = 1;
                $_POST['dataCadastro'] = time();
                $msg = "OK: Usuário incluído com sucesso!";
                $msgLog = "Gravou: novo usuario";
            } else {
                $obj->removeAll('menus');
                $msg = "OK: Usuário alterado com sucesso!";
                $msgLog = "Alterou: alterar usuario";
            }
            try {
                $obj->setFrom($_POST);
                if((int)$_POST['status']===3){
                    $obj->menus = empty($_POST['menu']) ? array() : $_POST['menu'];
                }else{
                    $obj->menus = array(0=>5);
                }
                
                $obj->save();

                if (!empty($_POST['senha'])) {
                    enviaSenhaUsuario($obj->nome, $novoLogin, $tempSenha, $obj->email);
                }
                logDao::gravaLog($user->login, 'usuarioLogic', $msgLog, $_POST,'','Usuario: '.@$_POST ['id']);
                msg($msg);
                gotox("principal.php?acao=usuarios");
            } catch (Exception $exc) {
                logDao::gravaLog($user->login, 'usuarioLogic', 'ERRO(gravar)', $_POST, $exc);
                msg('ERRO: Não foi possível cadastrar esse usuário');
                gotox("principal.php?acao=usuarios");
            }

            break;

        case 'remover' :
            if (!empty($_GET ['id']) && $obj->get($_GET ['id']) == 1) {
                try {

                    $obj->_getConnection()->executeSQL('UPDATE usuario SET ativo = 0 WHERE id ='.$obj->escape($_GET ['id']));
                   

                    /*$obj->removeAll('menus');
                    $obj->delete();*/
                    logDao::gravaLog($user->login, 'usuarioLogic', 'Removeu: usuario', $_REQUEST,'','Usuario: '.$_GET ['id']);
                    msg('OK: Usuário removido com sucesso!');
                    gotox("principal.php?acao=usuarios&empresa=".$obj->empresa->id);
                } catch (Exception $exc) {
                    logDao::gravaLog($user->login, 'usuarioLogic', 'ERRO(remover)', $_POST, $exc);
                    msg('ATENÇÃO: Não foi possível remover esse usuário devido à informações vinculadas a ele \r\n Utilize a opção de desativar');
                    gotox("principal.php?acao=usuarios");
                }
            }
            break;

        case 'alterarsenha' :
            if (!empty($_REQUEST ['id']) && $obj->get($_REQUEST ['id']) == 1) {
                try {

                    $obj->senha = criptografaSenha($_REQUEST ['senha']);
                    $obj->empresa = $_REQUEST ['empresa'];
                    $obj->save();
                    logDao::gravaLog($user->login, 'usuarioLogic', $_REQUEST ['acao'], $_REQUEST);
                    msg('OK: Senha alterada com sucesso!');
                    gotox("principal.php?acao=senhaCadastro");
                } catch (Exception $exc) {
                    logDao::gravaLog($user->login, 'usuarioLogic', 'ERRO(alterarsenha)', $_POST, $exc);
                    msg('ATENÇÃO: Não foi possível alterar a senha');
                    gotox("principal.php?acao=senhaCadastro");
                }
            }
            break;
            
            case 'alterarsenhauser' :
            if (!empty($_REQUEST ['id']) && $obj->get($_REQUEST ['id']) == 1) {
                try {

                    $obj->senha = criptografaSenha($_REQUEST ['senha']);
                    $obj->empresa = $_REQUEST ['empresa'];
                    $obj->save();
                    logDao::gravaLog($user->login, 'usuarioLogic', 'Alterou: senha de acesso', $_REQUEST,'','Usuario: '.$obj->nome);
                    msg('OK: Senha alterada com sucesso!');
                    gotox("principal.php?acao=senhaUsuarioCadastro&id=".$obj->id);
                } catch (Exception $exc) {
                    logDao::gravaLog($user->login, 'usuarioLogic', 'ERRO(alterarsenhausuario)', $_POST, $exc);
                    msg('ATENÇÃO: Não foi possível alterar a senha');
                    gotox("principal.php?acao=senhaUsuarioCadastro");
                }
            }
            break;
            
            
            
    }
}