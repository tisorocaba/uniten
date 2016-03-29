<?php
require_once 'util/config.php';
require_once 'dao/agendaCursoDao.php';
Security::admSecurity();
$user = unserialize($_SESSION['USER']);
$diarioDao = new DiarioClasse();
$agenda = new AgendaCurso();

$id = $diarioDao->escape($_POST['grade']);

$diarioDao->agenda = $_SESSION['CODAGENDA'];
$diarioDao->id = $id;

if ($diarioDao->find(true) >0) {
     try {
         $diarioDao->delete();
         logDao::gravaLog($user->login, 'ajax_grade_agenda_remover', 'Removeu: diario de classe', $_REQUEST, '', 'Agenda: ' . $_SESSION['CODAGENDA'] );
         die($id."|1|OK");
    } catch (Exception $exc) {
         die($id."|0|ERRO: Este diário já está preenchido pelo professor, por esse motivo, ele não pode ser removido");
    }
   
 }else{
    die($id."|0|ERRO: Diario não localizado");
}