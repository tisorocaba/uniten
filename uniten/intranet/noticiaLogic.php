<?php

require_once 'util/config.php';
Security::admSecurity();
$obj = new Noticia();
$user = unserialize($_SESSION['USER']);



if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
        case 'gravar' :
            if ($obj->get(@$_POST ['id']) == 0) {
                unset($_POST ['id']);
                $msg = "OK: Notícia incluído com sucesso!";
                $msgLog = "Gravou:  noticia";
            } else {
                $msg = "OK: Notícia alterado com sucesso!";
                $msgLog = "Alterou:  noticia";
            }

         
           
            
            if (!empty($_FILES['foto1']['name'])) {
                
                
              /* if(($_FILES['foto1']['type'] != 'image/jpeg') && ($_FILES['foto1']['type'] != 'image/jpg')){
                      logDao::gravaLog($user->login, 'noticiaLogic', 'Tipo de imagem invalido: '.$_FILES['foto1']['type'], $_REQUEST);
                      msg('Imagem invalida! Utilize arquivos com extensão JPG');
                      gotox("principal.php?acao=noticiaCadastro");
                }*/
                $parts = explode('.', $_FILES['foto1']['name']);
                $ext = strtolower(array_pop($parts));
                $name = date("Ymdhis") . "_noticia" . '.' . $ext;
                $obj->redimensionar($_FILES ['foto1'] ['tmp_name'], 500, 500, BASEFILE . $name);
                $obj->foto1 = $name;
            }
            
             if (!empty($_FILES['foto2']['name'])) {
                $parts = explode('.', @$_FILES['foto2']['name']);
                $ext = strtolower(array_pop($parts));
                $name = date("Ymdhis") . "_noticia" . '.' . $ext;
                $obj->redimensionar($_FILES ['foto2'] ['tmp_name'], 500, 500, BASEFILE . $name);
                $obj->foto2 = $name;
            }
            
             if (!empty($_FILES['foto3']['name'])) {
                $parts = explode('.', @$_FILES['foto3']['name']);
                $ext = strtolower(array_pop($parts));
                $name = date("Ymdhis") . "_noticia" . '.' . $ext;
                $obj->redimensionar($_FILES ['foto3'] ['tmp_name'], 500, 500, BASEFILE . $name);
                $obj->foto3 = $name;
            }
             if (!empty($_FILES['foto4']['name'])) {
                $parts = explode('.', @$_FILES['foto4']['name']);
                $ext = strtolower(array_pop($parts));
                $name = date("Ymdhis") . "_noticias" . '.' . $ext;
                $obj->redimensionar($_FILES ['foto4'] ['tmp_name'], 500, 500, BASEFILE . $name);
                $obj->foto4 = $name;
            }


           

        
            $obj->_setFrom($_POST);


            $obj->save();
            
            logDao::gravaLog($user->login, 'noticiaLogic', $msgLog, $_REQUEST, '', 'Noticia: ' . $obj->id);
     
            
            unset($obj);
            msg($msg);
            
          
            gotox("principal.php?acao=noticias");
            break;

        case 'remover' :
            if (!empty($_GET ['id']) && $obj->get($_GET ['id']) == 1) {
                try {
                    @unlink(BASEFILE . $obj->foto1);
                    @unlink(BASEFILE . $obj->foto2);
                    @unlink(BASEFILE . $obj->foto3);
                    @unlink(BASEFILE . $obj->foto4);
                    $obj->delete();
                    logDao::gravaLog($user->login, 'noticiaLogic', 'Removeu: noticia', $_REQUEST, '', 'Noticia: ' . $_GET ['id']);
                    msg('OK: Notícias removido com sucesso!');
                    gotox("principal.php?acao=noticias");
                } catch (Exception $exc) {
                    
                    logDao::gravaLog($user->login, 'noticiasLogic', 'ERRO(remover)', $_REQUEST, $exc);
                    
                    msg('ATENÇÃO: Não foi possível remover essa noticia devido à informações vinculadas a esse \r\n Utilize a opção de desativar');
                    gotox("principal.php?acao=noticias");
                }
            }
            break;
       
    }
}