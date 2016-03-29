<?php
require_once 'util/config.php';
require_once 'dao/diarioClasseDao.php';
Security::admSecurity();

if (count($_POST)>0) {
    $diarioDao = new DiarioClasseDao();
    $diario = $diarioDao->escape($_POST['diario']);
    $aluno = $diarioDao->escape($_POST['aluno']);
    $vale = $diarioDao->escape($_POST['vale']);

    $diarioDao->alteraVale($diario, $aluno, $vale);
}else{
    echo "ERRO";
}

?>