<?php
require_once 'util/config.php';
require_once 'dao/alunoDao.php';
Security::admSecurity();
$dao  = new AlunoDao();
if (empty($_REQUEST['limit'])) {
            $_REQUEST['limit'] = 8;
}

$ret = $dao->pesquisaPorNome($_REQUEST['searchTerm'], $_REQUEST['page'], $_REQUEST['sidx'], $_REQUEST['sord'], $_REQUEST['limit']);
echo json_encode($ret);
die;

?>