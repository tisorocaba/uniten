<?php

require_once '../util/config.php';
require_once '../dao/perguntaDao.php';
Security::admEcurso();
$perguntaDao = new PerguntaDao();
$user = unserialize($_SESSION['USER']);

// verificando se o aluno esta identificado
if (!empty($_POST['aluno'])) {
    $aluno = (int) $_POST['aluno'];
    unset($_POST['aluno']);
    // verificando se ja nao tem formulario preenchido
    if ($perguntaDao->getProtocolo($_SESSION['CODAGENDA'], $aluno) !== 0) {
        logDao::gravaLog($user->login, 'pesquisaLogic', 'ERRO: Já existe um formulário cadastrado para esse aluno',$_REQUEST);

        msg("ERRO: Já existe um formulário cadastrado para esse aluno!");
        gotox("pesquisaCadastro.php");
        die;
    }
} else {
    $aluno = 0;
}

// gerando o protocolo
$_SESSION['PROTOCOLOQUESTIONARIO'] = $perguntaDao->gravaProtocolo($_SESSION['CODAGENDA'],$aluno);


if(!empty($_POST['comentario'])){
    $comentario = $perguntaDao->escape($_POST['comentario']);
    $perguntaDao->gravaComentario($_SESSION['PROTOCOLOQUESTIONARIO'], $comentario);
    unset($_POST['comentario']);
}

foreach ($_POST as $key => $value) {
    if (is_numeric($key)) {
        //echo "Chave:" . $key . " Valor: " . $value . "<br>";
        $perguntaDao->gravaResposta($_SESSION['PROTOCOLOQUESTIONARIO'], $key, $value);
    }
} 
logDao::gravaLog($user->login, 'pesquisaLogic', 'Gravou: pesquisa do aluno',$_REQUEST);
gotox("pesquisaProtocolo.php");
