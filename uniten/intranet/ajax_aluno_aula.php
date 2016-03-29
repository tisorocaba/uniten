<?php
require_once 'util/config.php';
require_once 'dao/agendaCursoDao.php';
Security::admSecurity();
$agendaDao = new AgendaCursoDao();
$agendaDao->alteraStatus($_REQUEST['agenda'], $_REQUEST['aluno'], $_REQUEST['status']);
$user = unserialize($_SESSION['USER']);
if((int)$_REQUEST['status']===1){
   $agendaDao->gravaMatricula($_REQUEST['agenda'], $_REQUEST['aluno'], $user->id); 
}

echo $_REQUEST['status'];


logDao::gravaLog($user->login, 'ajax_aluno_aula', 'Alterou: status candidato', $_REQUEST,'','Aluno: '.$_REQUEST['aluno'].' Status: '.$_REQUEST['status']);
?>