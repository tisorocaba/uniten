<?php
require_once 'util/config.php';
Security::admSecurity();



$obj = new Poscurso();
$user = unserialize($_SESSION['USER']);
if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
        case 'gravar' :
            if ($obj->get(@$_POST ['id']) == 0) {
                unset($_POST ['id']);
                $msg = 'OK: Pesquisa inserida com sucesso';
                 $msgLog = "Gravou:  pos-curso";
            }else{
                $msg = 'OK: Pesquisa alterada com sucesso';
                 $msgLog = "Alterou:  agenda";
            }
           

            $obj->setFrom($_POST);

            $obj->save();
            
            logDao::gravaLog($user->login, 'posCursoLogic', $msgLog, $_REQUEST, '', 'Poscurso: ' . $obj->id);
            $obj->_getConnection()->executeSQL('delete  from poscurso_ausente where local_curso_id = '.$_REQUEST['agenda'].' and aluno_id ='.$_REQUEST['aluno']);
                
            msg($msg);
            gotox("poscurso.php");
            break;

      case 'ausente' :
       
            if(!empty($_REQUEST['agenda'])){
                   $obj->_getConnection()->executeSQL('insert into poscurso_ausente(local_curso_id,aluno_id) values('.$_REQUEST['agenda'].','.$_REQUEST['aluno'].')');
                   logDao::gravaLog($user->login, 'posCursoLogic', 'Registrando aluno ausente na pesquisa pos-curso', $_REQUEST, '', 'Aluno: ' . $_REQUEST['aluno'].' Agenda: '.$_REQUEST['agenda']);
                   msg('OK: Cadastro realizado com sucesso!');
                   gotox("poscurso.php?agenda=".$_REQUEST['agenda']);
            }else{
                 msg('ERRO: Não foi possivel cadastrar essa ausencia!');
                 gotox("principal.php?acao=agendacursosfinalizados");
            }
        
          break;
    }
}
?>
