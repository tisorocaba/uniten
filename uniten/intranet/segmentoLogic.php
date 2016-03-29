<?php
require_once 'util/config.php';
Security::admSecurity();
$obj = new Segmento();
$user = unserialize($_SESSION['USER']);

//xdebug();
//var_dump($_POST['disciplinas']);
if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
        case 'gravar' :
            if ($obj->get(@$_POST ['id']) == 0) {
                unset($_POST ['id']);
                if($obj->get('nome',$_POST ['nome'])){
                    msg("ERRO: Já existe um segmento cadastrado com esse nome!");
                    gotox("principal.php?acao=segmentoCadastro");
                    die;
                }
                $msg = "OK: Segmento incluído com sucesso!";
                $msgLog = "Gravou:  noticia";
            } else {
                $obj->removeAll('disciplinas');
                $msg = "OK: Segmento alterado com sucesso!";
                $msgLog = "Alterou:  segmento";
               
            }
            try{
                 $obj->setFrom($_POST);
                 $obj->save();
                
                 logDao::gravaLog($user->login, 'segmentoLogic', $msgLog, $_REQUEST, '', 'SEgmento: ' .$obj->id);

                 msg($msg);
                 gotox("principal.php?acao=segmentos");

            }catch (Exception $exc) {
                 logDao::gravaLog($user->login, 'segmentoLogic', 'ERRO(gravar)',$_REQUEST,$exc);
                 msg('ERRO: Não foi possível cadastrar esse segmento');
                 gotox("principal.php?acao=segmentos");
            }
            
           
            
            break;

        case 'remover' :
            if (!empty($_GET ['id']) && $obj->get($_GET ['id']) == 1) {
                try {
                    $obj->delete();
                    logDao::gravaLog($user->login, 'segmentoLogic', 'Removeu: segmento', $_REQUEST, '', 'SEgmento: ' .$_GET ['id']);
                    msg('OK: Segmento removido com sucesso!');
                    gotox("principal.php?acao=segmentos");

                } catch (Exception $exc) {
                    logDao::gravaLog($user->login, 'segmentoLogic', 'ERRO(remover)',$_REQUEST,$exc);
                    msg('ATENÇÃO: Não foi possível remover esse segmento devido à informações vinculadas a esse curso \r\n Utilize a opção de desativar');
                    gotox("principal.php?acao=segmentos");
                }
            }
            break;
        case 'ativacao' :
            if (!empty($_GET ['id']) && $obj->get($_GET ['id']) == 1) {
                try {
                    $obj->ativo = $_GET ['ativo'];
                    $obj->update();
                    logDao::gravaLog($user->login, 'segmentoLogic', 'Alterou: status de ativo', $_REQUEST, '', 'SEgmento: ' .$_GET ['id'].' Status: '.$_GET ['ativo']);
                    gotox("principal.php?acao=segmentos");
                } catch (Exception $exc) {
                    logDao::gravaLog($user->login, 'segmentoLogic', 'ERRO(aticacao)',$_REQUEST,$exc);
                     msg('ATENÇÃO: Não foi possível desativar esse segmento');
                    gotox("principal.php?acao=segmentos");
                }
            }
            break;
    }
}