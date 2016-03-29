<?php
require_once '../util/config.php';
require_once '../dao/agendaCursoDao.php';
Security::cursoSecurity();

$agendaDao = new AgendaCursoDao();

if(!isset ($_SESSION['CODAGENDA'])){
   die('Sua sessão expirou, faça login novamente'); 
}


$aluno = $agendaDao->escape($_POST['aluno']);
$nota = $agendaDao->escape($_POST['nota']);

$agendaDao->gravaAvaliacaoFinal($_SESSION['CODAGENDA'], $aluno, $nota);


$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'alunoCadastrAvaliacao', 'Alterou: o status do aluno',$_REQUEST,'','Aluno: '.$_REQUEST['aluno']);

gotox('alunosAvaliacaoFinal.php');


