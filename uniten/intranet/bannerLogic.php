<?php
require_once 'util/config.php';
Security::admSecurity();

//Lumine_Log::setLevel( Lumine_Log::ERROR );
//Lumine_Log::setOutput( Lumine_Log::BROWSER );

$user = unserialize($_SESSION['USER']);

$obj = new Banner ();

if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
        case 'gravar' :
            if ($obj->get(@$_POST ['id']) == 0) {
                unset($_POST ['id']);
            }
            if (!empty($_FILES ['imagem'] ['tmp_name'])) {

                if (is_uploaded_file(@$_FILES ['imagem'] ['tmp_name']) && is_writable(BASEFILE)) {

                    if (fileIsOk($_FILES ['imagem'] ['name']) == false) {
                        msg('Erro: Arquivo inválido');
                        gotox("principal.php?acao=bannerCadastro");
                    }

                    $parts = explode('.', @$_FILES ['imagem'] ['name']);
                    $ext = array_pop($parts);
                    $name = date("Ymdhis") . "_banner" . '.' . $ext;
                    $obj->redimensionar(@$_FILES ['imagem'] ['tmp_name'], 990, 300, BASEFILE . $name);
                    $obj->imagem = $name;
                    
                } else {
                    msg('Erro: nao consegui regravar o arquivo');
                    gotox("principal.php?acao=bannerCadastro");
                }
            }

            $obj->setFrom($_POST);
            $obj->save();
            
            logDao::gravaLog($user->login, 'bannerLogic', 'Alterou: banner', $_REQUEST, '', 'Banner: ' . $_POST ['id']);
            
            msg('OK: Banner inserido com sucesso');
            gotox("principal.php?acao=banners");
            break;

        case 'remover' :
            if (!empty($_GET ['id']) && $obj->get($_GET ['id']) == 1) {
                try {

                    if ($obj->imagem != '' && file_exists(BASEFILE . $obj->imagem) && is_writable(BASEFILE . $obj->imagem)) {
                        unlink(BASEFILE . $obj->imagem);
                    }
                    $obj->delete();

                    logDao::gravaLog($user->login, 'bannerLogic', 'Removeu: banner', $_REQUEST, '', 'Banner: ' . $_GET ['id']);
                    msg('OK: Banner removido com sucesso');
                    gotox("principal.php?acao=banners");
                } catch (Exception $e) {
                    
                }
            }
            break;
    }
}
?>
