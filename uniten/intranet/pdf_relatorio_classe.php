<?php
ini_set('memory_limit', '100M');
require_once 'util/config.php';
//Security::admSecurity();
//$disciplina = new Disciplina ();

/*$agenda = $disciplina->escape($_REQUEST['agenda']);
$aluno = $disciplina->escape($_REQUEST['aluno']);
$status = $disciplina->escape($_REQUEST['status']);*/


$html = getHTTP(BASEURL . "/intranet/modelo/relatorio-classe.php?agenda=49");


//die($html);




require_once("util/dompdf/dompdf_config.inc.php");

$dompdf = new DOMPDF();
$dompdf->load_html(utf8_decode($html));
$dompdf->set_paper('a4', 'landscape');
$dompdf->render();


$dompdf->stream("declaracao.pdf");

exit(0);
?>