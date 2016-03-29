<?php
require_once '../util/config.php';
require_once '../dao/diarioClasseDao.php';
Security::provaSecurity();

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'siar', 'Saiu do sistema', $_REQUEST);


unset($_SESSION['USER']);
unset($_SESSION['CODAGENDA']);

gotox('../index.php');

?>