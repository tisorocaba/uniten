<?php
require_once 'util/config.php';
Security::admSecurity();

//Lumine_Log::setLevel( Lumine_Log::ERROR );
//Lumine_Log::setOutput( Lumine_Log::BROWSER );


$obj = new Formulario();
$user = unserialize($_SESSION['USER']);

if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
        case 'gravar' :
            if ($obj->get(@$_POST ['id']) == 0) {
                unset($_POST ['id']);
            }
            if (!empty($_FILES ['arquivo'] ['tmp_name'])) {

                if (is_uploaded_file(@$_FILES ['arquivo'] ['tmp_name']) && is_writable(BASEFILE)) {

                  

                    /*if (fileIsOk($_FILES ['arquivo'] ['name']) == false) {
                        msg('Erro: Arquivo inválido');
                        gotox("principal.php?acao=bannerCadastro");
                    }*/

                    $parts = explode('.', @$_FILES ['arquivo'] ['name']);
                    $ext = array_pop($parts);
                    $name = date("Ymdhis") . "_arquivo" . '.' . $ext;
                    move_uploaded_file($_FILES ['arquivo'] ['tmp_name'], BASEFILE . $name);
                    //$obj->redimensionar(@$_FILES ['arquivo'] ['tmp_name'], 990, 300, BASEFILE . $name);
                    $obj->arquivo = $name;
                } else {
                    msg('Erro: nao consegui regravar o arquivo');
                    gotox("principal.php?acao=arquivoCadastro");
                }
            }

            $obj->setFrom($_POST);

            $obj->save();
            logDao::gravaLog($user->login, 'formularioLogic', 'Gravou: formulario', $_REQUEST, '', 'Formulario: ' .$obj->id);

            msg('OK: Formulario inserido com sucesso');
            gotox("principal.php?acao=formularios");
            break;

        case 'remover' :
            if (!empty($_GET ['id']) && $obj->get($_GET ['id']) == 1) {
                try {

                    if ($obj->arquivo != '' && file_exists(BASEFILE . $obj->arquivo) && is_writable(BASEFILE . $obj->arquivo)) {
                        unlink(BASEFILE . $obj->arquivo);
                    }
                    $obj->delete();
                    logDao::gravaLog($user->login, 'formularioLogic', 'Removeu: formulario', $_REQUEST);
                    msg('OK: Arquivo removido com sucesso');
                    gotox("principal.php?acao=formularios");
                } catch (Exception $e) {
                    
                }
            }
            break;
    }
}
?>
