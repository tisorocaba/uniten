<?php
require_once '../util/config.php';

$obj = new UniteEmprega();
//$empresa = unserialize($_SESSION['EMPRESA']);

//Security::admSecurity();

if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
        case 'gravar' :
                Security::uniteempregaSecurity();
                $msg = "OK: Empresa alterada com sucesso!";
                $_POST['dataAtualizacao'] = time();
            
            try {
                $obj->setFrom($_POST);
                $obj->save();
                //logDao::gravaLog($user->id, 'localLogic', $_REQUEST ['acao'], $_REQUEST);
                msg($msg);
                gotox("principal.php?acao=empresaCadastro");
            } catch (Exception $exc) {
                //logDao::gravaLog($user->id, 'empresaLogic', $_REQUEST ['acao'], $_REQUEST, $exc);
                msg('ERRO: Não foi possível cadastrar esse empresa');
                gotox("principal.php?acao=empresaCadastro");
            }

            break;

       
        case 'alterarsenha' :
            Security::uniteempregaSecurity();
            if (!empty($_REQUEST ['id']) && $obj->get($_REQUEST ['id']) == 1) {
                  try {
                   
                    $obj->senha = criptografaSenha($_REQUEST['senha']);
                    $obj->update();
                    msg('OK: Senha alterada com sucesso!');
                    gotox("principal.php?acao=senhaCadastro");
                } catch (Exception $exc) {
                    //logDao::gravaLog($user->id, 'empresaLogic', $_REQUEST ['acao'], $_REQUEST, $exc);
                    msg('ATENÇÃO: Não foi possível alterar a senha');
                    gotox("principal.php?acao=senhaCadastro");
                }
            }
            break;
            
            
            case 'reenviarsenha' :
            $cnpj = $_REQUEST ['cnpj']; 
            if (!empty($cnpj) && $obj->get('cnpj',$cnpj) == 1) {
                  try {
                    $senha = geraSenha();
                    $obj->senha = criptografaSenha($senha);
                    $obj->update();
                    reenviaSenhaEmpresa($obj->responsavel, $cnpj, $senha, $obj->email);
                    echo 1;
                } catch (Exception $exc) {
                    echo 0;
                }
            }else{
                echo 0;
            }
            break;
            
    }
    
    
    
    
}