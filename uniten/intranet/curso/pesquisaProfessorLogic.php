<?php

require_once '../util/config.php';
require_once '../dao/perguntaDao.php';
Security::admEcurso();
$perguntaDao = new PerguntaDao();
$user = unserialize($_SESSION['USER']);

$perguntaDao->removerRespostaProfessor($_SESSION['CODAGENDA']);

foreach ($_POST as $key => $value) {
    if (is_numeric($key)) {
        //echo "Chave:" . $key . " Valor: " . $value . "<br>";
        $perguntaDao->gravaRespostaProfessor($_SESSION['CODAGENDA'], $key, $value);
    }
} 
logDao::gravaLog($user->login, 'pesquisaProfessorLogic', 'Gravou: pesquisa do professor',$_REQUEST,'','Agenda: '.$_SESSION['CODAGENDA']);
msg('Pesquisa cadastrada com sucesso');

die("<script> window.parent.location='principal.php'; </script>");
//gotox("pesquisaProfessorCadastro.php");
