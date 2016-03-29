<?php

require_once 'util/config.php';

Security::admSecurity();
$user = unserialize($_SESSION['USER']);
$obj = new Galeria;

if (!empty($_REQUEST['acao'])) {
    switch ($_REQUEST['acao']) {
        case 'gravar':
            if ($obj->get(@$_POST['id']) == 0) {
                unset($_POST['id']);
                $logMsg = "Gravou:  evento";
                $msg ='OK: Evento inserido com sucesso';
            }else{
                $logMsg = "Alterou:  evento";
                $msg ='OK: Evento alterado com sucesso';
            }

            if (!empty($_FILES['foto']['name'])) {
                $parts = explode('.', @$_FILES['foto']['name']);
                $ext = array_pop($parts);
                $name = date("Ymdhis") . "_imagem" . '.' . $ext;
                //copy(@$_FILES ['foto'] ['tmp_name'], BASEFILE . $name);
                $obj->redimensionar($_FILES ['foto'] ['tmp_name'], 500, 500, BASEFILE . $name);
                chmod(BASEFILE . $name, 0777);
                $obj->foto = $name;
            }

            $obj->setFrom($_POST);
            $obj->save();
            logDao::gravaLog($user->login, 'eventoCadastro', $logMsg , $_REQUEST,'','Evento: '.$obj->id);
            msg($msg);
            gotox("principal.php?acao=eventos");
            break;


        case 'remover':
            if (!empty($_GET['id']) && $obj->get($_GET['id']) == 1) {
                try {
                    $obj->delete();
                    logDao::gravaLog($user->login, 'eventoCadastro', 'Removeu: evento', $_REQUEST,'','Evento: '.$_GET['id']);
                    msg('OK: Evento removido com sucesso');
                    gotox("principal.php?acao=eventos");
                } catch (Exception $e) {
                    msg('ERRO: Não é possível remover esse evento');
                    gotox("principal.php?acao=eventos");
                }
            }
            break;
    }
}
?>
