<?php
require_once 'util/config.php';
require_once 'dao/agendaDisciplinaProfessorDao.php';
Security::admSecurity();
$agendaDisciplinaProfessorDao = new agendaDisciplinaProfessorDao;


$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'ajax_agenda_professor_disciplina', 'Alterou: professor na disciplina', $_REQUEST, '', 'Agenda: ' . $_SESSION['CODAGENDA'].' Professor: '.$_REQUEST['professor'].' Disciplina: '.$_REQUEST['disciplina']);

$agendaDisciplinaProfessorDao->gravaProfessorAgenda($_SESSION['CODAGENDA'], $_REQUEST['professor'], $_REQUEST['disciplina']);
