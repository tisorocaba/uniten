<?php

require_once '../util/config.php';
require_once 'dao/processoDao.php';
Security::uniteempregaSecurity();
$processoDao = new ProcessoDao();
$empresa = unserialize($_SESSION['EMPRESA']);

if (checaData($_REQUEST['data']) === false) {
    msg('ERRO: Data inválida!');
    if ($_REQUEST['id'] == '') {
        gotox('principal.php?acao=entrevistaForm&cod=' . $_REQUEST['aluno']);
    } else {
        gotox('principal.php?acao=processoCadastro&cod=' . $_REQUEST['id']);
    }
}

if ($_REQUEST['status'] == 1) {
    $hora = $processoDao->escape($_REQUEST['hora']);
    if (checktime($hora) !== true) {
        msg('ERRO: Por favor corrija a hora da entrevista!');
        gotox('principal.php?acao=entrevistaForm&cod='.$_REQUEST['aluno']);
    }
    $data = data_us($processoDao->escape($_REQUEST['data']));

    $aluno = $processoDao->escape($_REQUEST['aluno']);
    $proc = $processoDao->gravaProcesso($data, $hora, $empresa->id, $aluno, 1);
    $processoDao->registraAlteracaoStatus($aluno, $empresa->id, $data, 0, 1, $proc);
    msg('Entrevista agendada com sucesso');
    gotox('principal.php?acao=resultadoPesquisa');
} else {
    $id = $processoDao->escape($_REQUEST['id']);
    $aDados = $processoDao->recuperaProcesso($id);

    $sdate = strtotime($aDados['data']);
    $edate = strtotime(data_us($_REQUEST['data']));

    if ($edate === false) {
        msg('ERRO: Por favor, verifique a data informada');
        gotox('principal.php?acao=processos');
    }

    if (($edate - $sdate) <= 0) {
        msg('ERRO: A data informada e menor do que a data da agenda anterior');
        gotox('principal.php?acao=processos');
    }



    $data = data_us($processoDao->escape($_REQUEST['data']));
    $setor = $processoDao->escape(@$_REQUEST['setor']);
    $aluno = $processoDao->escape($_REQUEST['aluno']);
    $status = $processoDao->escape($_REQUEST['status']);

    $processoDao->gravaProcesso($data, '', $empresa->id, $aluno, $status, $setor, $id);

    $processoDao->registraAlteracaoStatus($aluno, $empresa->id, $data, $_SESSION['STATUSENTRE'], $_REQUEST['status'], $id);

    msg('Ação realizada com sucesso!');
    gotox('principal.php?acao=processos');
}

function checktime($time) {
    list($hour, $minute) = explode(':', $time);
    if ($hour > -1 && $hour < 24 && $minute > -1 && $minute < 60) {
        return true;
    }
}

?>