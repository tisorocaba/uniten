<?php
require_once '../util/config.php';
require_once '../dao/diarioClasseDao.php';
Security::cursoSecurity();

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'sair', 'Logout: saiu do sistema',$_REQUEST);


unset($_SESSION['USER']);
unset($_SESSION['CODAGENDA']);

gotox('../index.php');

?>