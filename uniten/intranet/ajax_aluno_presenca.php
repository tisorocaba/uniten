<?php

require_once 'util/config.php';
require_once 'dao/diarioClasseDao.php';
require_once 'dao/agendaCursoDao.php';
Security::admSecurity();

if (count($_POST) > 0) {
    $diarioDao = new DiarioClasseDao();
    $diario = $diarioDao->escape($_POST['diario']);
    $aluno = $diarioDao->escape($_POST['aluno']);
    $presenca = $diarioDao->escape($_POST['presenca']);

    $diarioDao->alteraPresenca($diario, $aluno, $presenca);

    // incluindo o passe
    $agendaDao = new AgendaCursoDao();
    
    
    if ((int)$presenca === 1) {
        $diarioDao->alteraVale($diario, $aluno, $agendaDao->getPasse($_SESSION['CODAGENDA'], $aluno));
    }else{
        $diarioDao->alteraVale($diario, $aluno, 0);
    }
} else {
    echo "ERRO";
}
?>