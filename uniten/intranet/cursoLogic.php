<?php
require_once 'util/config.php';
Security::admSecurity();
$obj = new Curso();
$user = unserialize($_SESSION['USER']);

//xdebug();
//var_dump($_POST['disciplinas']);
if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
        case 'gravar' :
            if ($obj->get(@$_POST ['id']) == 0) {
                unset($_POST ['id']);
                if($obj->get('nome',$_POST ['nome'])){
                    msg("ERRO: Já existe um cursp cadastrado com esse nome!");
                    gotox("principal.php?acao=cursoCadastro");
                    die;
                }
                $msg = "OK: Curso incluído com sucesso!";
                $msgLog = "Gravou: novo curso";
            } else {
                $obj->removeAll('disciplinas');
                $msg = "OK: Curso alterado com sucesso!";
                $msgLog = "Alterou:  curso";
                $_POST['dataAlteracao'] = time();
            }
            try{
                 $obj->setFrom($_POST);
                 $obj->disciplinas = empty($_POST['disciplinas']) ? array() : $_POST['disciplinas'];
                 $obj->save();
            	 logDao::gravaLog($user->login, 'cursoLogic',$msgLog , $_REQUEST,'','Curso: '.$obj->id);
                 msg($msg);
                 gotox("principal.php?acao=cursos");

            }catch (Exception $exc) {
                 logDao::gravaLog($user->id, 'cursoLogic', 'ERRO(gravar)',$_REQUEST,$exc);
                 msg('ERRO: Não foi possível cadastrar esse curso');
                 gotox("principal.php?acao=cursos");
            }
            
           
            
            break;

        case 'remover' :
            if (!empty($_GET ['id']) && $obj->get($_GET ['id']) == 1) {
                try {
                    $obj->delete();
                    logDao::gravaLog($user->login, 'cursoLogic', 'Removeu: curso',$_REQUEST,'','Curso: '.$_GET ['id']);
                    msg('OK: curso removido com sucesso!');
                    gotox("principal.php?acao=cursos");

                } catch (Exception $exc) {
                    logDao::gravaLog($user->login, 'cursoLogic','ERRO(remover)',$_REQUEST,$exc);
                    msg('ATENÇÃO: Não foi possível remover esse curso devido à informações vinculadas a esse curso \r\n Utilize a opção de desativar');
                    gotox("principal.php?acao=cursos");
                }
            }
            break;
        case 'ativacao' :
            if (!empty($_GET ['id']) && $obj->get($_GET ['id']) == 1) {
                try {
                    $obj->ativo = $_GET ['ativo'];
                    $obj->update();
                    logDao::gravaLog($user->login, 'cursoLogic', 'Alterou: curso',$_REQUEST,'','Curso: '.$_GET ['id'].' Status: '.$_GET ['ativo']);
                    gotox("principal.php?acao=cursos");
                } catch (Exception $exc) {
                    logDao::gravaLog($user->login, 'cursoLogic', 'ERRO(ativacao)',$_REQUEST,$exc);
                     msg('ATENÇÃO: Não foi possível desativar esse curso');
                    gotox("principal.php?acao=cursos");
                }
            }
            break;
            
          case 'desativos_ativacao' :
            if (!empty($_GET ['id']) && $obj->get($_GET ['id']) == 1) {
                try {
                    $obj->ativo = $_GET ['ativo'];
                    $obj->update();
                    logDao::gravaLog($user->login, 'cursoLogic', 'Alterou: curso',$_REQUEST,'','Curso: '.$_GET ['id'].' Status: '.$_GET ['ativo']);
                    gotox("principal.php?acao=cursosinativos");
                } catch (Exception $exc) {
                    logDao::gravaLog($user->login, 'cursoLogic', 'ERRO(ativacao)',$_REQUEST,$exc);
                     msg('ATENÇÃO: Não foi possível desativar esse curso');
                    gotox("principal.php?acao=cursosinativos");
                }
            }
            break;
            
    }
}