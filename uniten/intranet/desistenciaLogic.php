<?php
require_once 'util/config.php';
require_once 'dao/agendaCursoDao.php';

Security::admSecurity();
$agendaDao = new AgendaCursoDao();
$user = unserialize($_SESSION['USER']);

$obj = new Desistencia();

if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
        case 'gravar' :
            if ($obj->get(@$_POST ['id']) == 0) {
                unset($_POST ['id']);
                $msg = 'Informação inserida com sucesso!';
                $msgLog = "Gravou: nova desistencia";
            } else {
                $msg = 'Informação alterada com sucesso!';
                $msgLog = "Alterou: desistencia";
            }



            if ($_POST['tipo'] == 1) {
                $obj->setFrom($_POST);
                $obj->agenda = $_SESSION['CODAGENDA'];
                $obj->save();
            } else {
                if ($obj->get(@$_POST ['id']) > 0) {
                    $obj->delete();
                }
            }
            $agendaDao = new AgendaCursoDao();
            $agendaDao->alteraStatus($_SESSION['CODAGENDA'], $_POST['aluno'], 4);
            
            logDao::gravaLog($user->login, 'desistenciaLogic', $msgLog, $_REQUEST, '', 'Aluno: ' . $_POST['aluno']);
            
            msg($msg);
            gotox("alunosDesistentes.php");
            break;

        case 'remover' :
            $agendaDao->alteraStatus($_SESSION['CODAGENDA'], $_GET['aluno'], 1);
            $obj->_getConnection()->executeSQL('delete from desistencia where local_curso_id = '.$_SESSION['CODAGENDA'].' and aluno_id='.$_GET['aluno']);
            logDao::gravaLog($user->login, 'desistenciaLogic', 'Removeu: desistencia', $_REQUEST, '', 'Aluno: ' . $_GET['aluno']);
            msg('OK: alteração realizada com sucesso!');
            gotox("alunosDesistentes.php");

            break;
    }
}
?>
