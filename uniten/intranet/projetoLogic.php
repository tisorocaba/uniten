<?php

require_once 'util/config.php';
Security::admSecurity();
$objProj = new Projeto();
$user = unserialize($_SESSION['USER']);



if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
        case 'gravar' :
            if ($objProj->get(@$_POST ['id']) == 0) {
                unset($_POST ['id']);
                /* if($obj->get('nome',$_POST ['nome'])){
                  msg("ERRO: Já existe um projeto cadastrado com esse nome!");
                  gotox("principal.php?acao=projetoCadastro");
                  die;
                  } */
                $msg = "OK: Programa incluído com sucesso!";
                $logMsg = "Gravou: novo programa";
            } else {
                $msg = "OK: Programa alterado com sucesso!";
                $logMsg = "Alterou:  programa";
            }



            if (!empty($_FILES['imagem']['name'])) {
                $parts = explode('.', @$_FILES['imagem']['name']);
                $ext = array_pop($parts);
                $name = date("Ymdhis") . "_imagem" . '.' . $ext;
                copy(@$_FILES ['imagem'] ['tmp_name'], BASEFILE . $name);
                chmod(BASEFILE . $name, 0777);
                $objProj->imagem = $name;
            }





            $objProj->_setFrom($_POST);
           
            $objProj->save();
            
            logDao::gravaLog($user->login, 'projetoLogin', $logMsg, $_REQUEST, '', 'Programa: '.$objProj->id);

            
            unset($objProj);
            
            
            msg($msg);


            gotox("principal.php?acao=projetos");
            break;

        case 'remover' :
            if (!empty($_GET ['id']) && $objProj->get($_GET ['id']) == 1) {
                try {
                    @unlink(BASEFILE . $objProj->imagem);
                    $objProj->delete();
                    logDao::gravaLog($user->login, 'projetoLogin', 'Removeu: programa', $_REQUEST, '', 'Programa: '.$_GET ['id']);
                    
                    msg('OK: Programa removido com sucesso!');
                    gotox("principal.php?acao=projetos");
                } catch (Exception $exc) {
                    logDao::gravaLog($user->id, 'projetoLogic', 'ERRO: Sistema emitiu um erro', $_REQUEST, $exc);
                    msg('ATENÇÃO: Não foi possível remover esse programa devido à informações vinculadas a esse \r\n Utilize a opção de desativar');
                    gotox("principal.php?acao=projetos");
                }
            }
            break;
        case 'ativacao' :
            if (!empty($_GET ['id']) && $objProj->get($_GET ['id']) == 1) {
                try {
                    $objProj->ativo = $_GET ['ativo'];
                    $objProj->update();
                    logDao::gravaLog($user->login, 'projetoLogic', 'Alterou: status de ativo', $_REQUEST, '', 'Programa: '.$_GET ['id'].' Status: ' . $_GET ['ativo']);
                    gotox("principal.php?acao=projetos");
                } catch (Exception $exc) {
                    logDao::gravaLog($user->id, 'projetoLogic', 'ERRO: Sistema emitiu um erro', $_REQUEST, $exc);
                    msg('ATENÇÃO: Não foi possível desativar esse projeto');
                    gotox("principal.php?acao=projetos");
                }
            }
            break;
    }
}