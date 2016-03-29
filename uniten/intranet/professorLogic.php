<?php

require_once 'util/config.php';
Security::admSecurity();
$obj = new Professor();
$user = unserialize($_SESSION['USER']);


if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
        case 'gravar' :
            if ($obj->get(@$_POST ['id']) == 0) {
                /**** verificando se usuario já esta cadastrado ****/
                 if ($obj->get('email', $_POST ['email'])) {
                    msg("ERRO: Já existe um usuário ou monitor cadastrado com esse email!");
                    gotox("principal.php?acao=professorCadastro");
                    die;
                } 
                unset($_POST ['id']);
                $msg = "OK: Professor incluído com sucesso!";
                $msgLog = "Gravou: novo professor";
                
            } else {
                $obj->removeAll('disciplinas');
                $msg = "OK: Professor alterado com sucesso!";
                $_POST['dataAtualizacao'] = time();
                $msgLog = "Alterou: professor";
            }
            try {
                $obj->setFrom($_POST);
                $obj->disciplinas = empty($_POST['disciplinas']) ? array() : $_POST['disciplinas'];
                $obj->save();

                //xdebug();
                /********* cadastro usuario para o professor ***************************/
                $userNew = new Usuario();
                if ($userNew->get('professor', $obj->id) == 0) {
                    /*************************  gerando o login ************************/
                    $userPesq = new Usuario();
                    $userPesq->alias('u')->order(' id DESC')->where('u.empresa = ? ', $_POST['empresa'])->limit(0,1)->find();
                    $userPesq->current();
                    $novoLogin = $_POST['empresa'] . "00" . str_pad($userPesq->id+1, 3, "0", STR_PAD_LEFT);
                    
                    //var_dump($novoLogin);
                    //die();
                   
                    /** *****************************************************************/
                    
                    
                    /************************gerando a senha**************************/
                    $tempSenha = geraSenha();
                    $userNew->senha = criptografaSenha($tempSenha);
                    /*****************************************************************/

                    /************************capturando as inforacoes basicas*********/
                    $userNew->empresa      = $_POST['empresa'];
                    $userNew->email        = $_POST['email'];
                    $userNew->nome         = $_POST['nome'];
                    $userNew->login        = $novoLogin;
                    $userNew->ativo        = 1;
                    $userNew->dataCadastro = time();
                    $userNew->tipoLogin    = 2;
                    $userNew->professor    = $obj->id;
                    $userNew->menus        = array(0=>6);
                    
                    
                    $userNew->save();
                    
                    /***********************enviando email com senha**************************/
                    enviaSenhaUsuario($userNew->nome, $novoLogin, $tempSenha, $userNew->email);
                    
                   
                   
                }else{
                    $userNew->empresa      = $_POST['empresa'];
                    $userNew->email        = $_POST['email'];
                    $userNew->nome         = $_POST['nome'];
                    $userNew->save();
                    
                    
                }



                logDao::gravaLog($user->login, 'professorLogic', $msgLog, $_REQUEST, '', 'Professor: ' . $obj->id);
            
                msg($msg);
                gotox("principal.php?acao=professores");
            } catch (Exception $exc) {
                logDao::gravaLog($user->login, 'professorLogic', 'ERRO(gravar)', $_REQUEST, $exc);
                msg('ERRO: Não foi possível cadastrar esse professor');
                gotox("principal.php?acao=professores");
            }

            break;

        case 'remover' :
            if (!empty($_GET ['id']) && $obj->get($_GET ['id']) == 1) {
                try {
                    
                    $obj->removeAll('disciplinas');
                    $obj->delete();
                    $userNew = new Usuario();
                    if ($userNew->get('professor', $_GET ['id']) > 0) {
                        $userNew->ativo = 0;
                        $userNew->empresa = -1;
                        $userNew->update();
                    }
                    
                    logDao::gravaLog($user->login, 'professorLogic', 'Removeu: professor', $_REQUEST,'','Professor: '.$_GET ['id']);
                    msg('OK: Disciplina removida com sucesso!');
                    gotox("principal.php?acao=professores");
                } catch (Exception $exc) {
                     logDao::gravaLog($user->login, 'professorLogic', 'ERRO(remover)', $_REQUEST, $exc);
                    msg('ATENÇÃO: Não foi possível remover esse Professor devido à informações vinculadas a ele \r\n Utilize a opção de desativar');
                    gotox("principal.php?acao=professores");
                }
            }
            break;
        case 'ativacao' :
            if (!empty($_GET ['id']) && $obj->get($_GET ['id']) == 1) {
                try {
                    //$obj->curso = (int) $obj->curso->id;
                    $obj->ativo = $_GET ['ativo'];
                    $obj->update();
                    
                  
                    $userNew = new Usuario();
                    if ($userNew->get('professor', $_GET ['id']) > 0) {
                        $userNew->ativo = $_GET ['ativo'];
                        $userNew->empresa = $obj->empresa;
                        $userNew->update();
                    }
                    
                    logDao::gravaLog($user->login, 'professorLogic', 'Alterou: status de ativacao', $_REQUEST,'','Professor: '.$_GET ['id'].' Status: '.$_GET ['ativo']);
             
                    gotox("principal.php?acao=professores");
                } catch (Exception $exc) {
                     logDao::gravaLog($user->login, 'professorLogic', 'ERRO(ativacao)', $_REQUEST, $exc);
                    msg('ATENÇÃO: Não foi possível desativar esse Professor');
                    gotox("principal.php?acao=professores");
                }
            }
            break;
    }
}