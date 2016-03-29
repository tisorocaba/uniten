<?php
require_once '../util/config.php';
require_once 'dao/processoDao.php';
Security::uniteempregaSecurity();
$processoDao = new ProcessoDao();
$empresa= unserialize($_SESSION['EMPRESA']);


$id = $processoDao->escape($_REQUEST['id']);
$processoDao->removerProcesso($id);


msg('Processo removido com sucesso!');
gotox('principal.php?acao=processos');

?>