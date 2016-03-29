<?php

require_once 'util/config.php';
Security::admSecurity();
$disciplina = new Disciplina ();

$agenda = $disciplina->escape($_REQUEST['agenda']);
$aluno = $disciplina->escape($_REQUEST['aluno']);


$html = getHTTP(BASEURL . "/intranet/modelo/certificado/certificado.php");
$html = str_replace('{ALUNO}', Aluno::staticGet($aluno)->nome, $html);
$html = str_replace('{RG}', Aluno::staticGet($aluno)->rg, $html);

$curso = str_replace('(MANHÃ)', '', AgendaCurso::staticGet($agenda)->curso->nome);
$curso = str_replace('(TARDE)', '', AgendaCurso::staticGet($agenda)->curso->nome);
$curso = str_replace('(NOITE)', '', AgendaCurso::staticGet($agenda)->curso->nome);

$curso = str_replace('(NOITE)', '', AgendaCurso::staticGet($agenda)->curso->nome);
$curso = str_replace('(TARDE)', '', AgendaCurso::staticGet($agenda)->curso->nome);
$curso = str_replace('(MANHÃ)', '', AgendaCurso::staticGet($agenda)->curso->nome);


$curso = str_replace('- A', '', $curso);

$html = str_replace('{CURSO}',$curso, $html);




$disciplinas = AgendaCurso::staticGet($agenda)->curso->getLink('disciplinas');

$total = 0;

foreach ($disciplinas as $disciplina) {
     $total += $disciplina->cargaHoraria;
}

$html = str_replace('{CARGA}', $total, $html);



$html = str_replace('{DATA}', dataEscrita(date('Y'), date('m'), date('d')), $html);



require_once("util/dompdf/dompdf_config.inc.php");

$dompdf = new DOMPDF();
$dompdf->load_html(utf8_decode($html));
$dompdf->set_paper('a4', 'portrait');
$dompdf->render();


$dompdf->stream("certificado.pdf");

exit(0);
?>