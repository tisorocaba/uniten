<?php
require_once 'util/config.php';
Security::admSecurity();
$obj = new GaleriaFoto();
$user = unserialize($_SESSION['USER']);

if (!empty($_REQUEST['acao'])) {
    switch ($_REQUEST['acao']) {
        case 'gravar':
            if ($obj->get(@$_POST['id']) == 0) {
                unset($_POST['id']);
            }
            $parts = explode('.', @$_FILES['foto']['name']);
            $ext = array_pop($parts);

            $name = date("Ymdhis") . "_foto" . '.' . $ext;
            
            
           // copy ( @$_FILES ['foto'] ['tmp_name'], BASEFILE . $name );
            
           /* $img = new Imagick($_FILES['foto']['tmp_name']);
            $img->thumbnailImage(500 , 500 , TRUE);
            $img->writeImage(BASEFILE . $name);*/
            
             $obj->redimensionar($_FILES ['foto'] ['tmp_name'], 500, 500, BASEFILE . $name);
           
            
            //chmod(BASEFILE . $name, 0777);

            $obj->foto = $name;

            $obj->setFrom($_POST);

            $obj->save();

            logDao::gravaLog($user->login, 'fotoLogic', 'Gravou: foto', $_REQUEST,'','Evento: '.$_REQUEST['galeria']);

            gotox("principal.php?acao=fotoCadastro&id=" . @$_POST['galeria']);
            break;


        case 'remover':
            if (!empty($_GET['id']) && $obj->get($_GET['id']) == 1) {
                try {
                    $obj->delete();
                    logDao::gravaLog($user->login, 'fotoLogic', 'Removeu: foto', $_REQUEST);
                    msg('OK: Foto removida com sucesso');
                    gotox("principal.php?acao=eventos");
                } catch (Exception $e) {
                    msg('ERRO: Não é possível remover esta foto!');
                    gotox("principal.php?acao=eventos");
                }
            }
            break;


        case 'destacar':
            //echo "entrou";
            
            logDao::gravaLog($user->login, 'fotoLogic', 'Destagou: foto', $_REQUEST,'','Evento: '.@$_REQUEST['evento']);

            $objV = new GaleriaFoto();
            $objV->alias('ev')
                    ->where('ev.galeria=? and ev.capa=1', @$_REQUEST['evento'])
                    ->find("ev.capa=0");
            $objV->capa = 0;
            $objV->update();

            $obj->get(@$_REQUEST['foto']);
            $obj->capa = 1;
            //$obj->fot_id = $_GET['foto'];
            $obj->update();


            break;



        case 'excluirfoto':
           
            $objV = new GaleriaFoto();
            $objV->get($_REQUEST['foto']);
            $objV->delete();
            echo $_REQUEST['foto'];
            logDao::gravaLog($user->login, 'fotoLogic', 'Removeu: foto', $_REQUEST,'','Evento: '.$objV->galeria);

            break;
    }
}
?>
