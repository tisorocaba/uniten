<?php

require_once 'util/config.php';
Security::admSecurity();
$disciplina = new Disciplina ();

$agenda = $disciplina->escape($_REQUEST['agenda']);
$aluno = $disciplina->escape($_REQUEST['aluno']);
$status = $disciplina->escape($_REQUEST['status']);

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'pdf_declaracao', 'Emitiu: Declaracao', $_REQUEST,'','Aluno: '.$_REQUEST['aluno'].' Agenda: '.$_REQUEST['agenda']);


$html = getHTTP(BASEURL . "/intranet/modelo/declaracao.php");
$html = str_replace('{ALUNO}', Aluno::staticGet($aluno)->nome, $html);
$html = str_replace('{RG}', Aluno::staticGet($aluno)->rg, $html);
//$html = str_replace('{CPF}', Aluno::staticGet($aluno)->cpf, $html);

if ($status == 0) {
    $txt = " está matriculado no curso de " . AgendaCurso::staticGet($agenda)->curso->nome;
} elseif ($status == 1) {
    $txt = " está cursando " . AgendaCurso::staticGet($agenda)->curso->nome;
} else {
    $txt = " concluiu o curso " . AgendaCurso::staticGet($agenda)->curso->nome;
}
$html = str_replace('{CURSO}', $txt, $html);

$html = str_replace('{DATAINI}', data_br(AgendaCurso::staticGet($agenda)->dataInicio), $html);
$html = str_replace('{DATAFIM}', data_br(AgendaCurso::staticGet($agenda)->dataTermino), $html);

$html = str_replace('{HORAINI}', AgendaCurso::staticGet($agenda)->horarioInicial, $html);
$html = str_replace('{HORAFIM}', AgendaCurso::staticGet($agenda)->horarioFinal, $html);

$html = str_replace('{LOCAL}', AgendaCurso::staticGet($agenda)->local->local, $html);
$html = str_replace('{ENDERECO}', AgendaCurso::staticGet($agenda)->local->endereco, $html);
$html = str_replace('{NUMERO}', AgendaCurso::staticGet($agenda)->local->numero, $html);
$html = str_replace('{BAIRRO}', AgendaCurso::staticGet($agenda)->local->bairro, $html);


$disciplinas = AgendaCurso::staticGet($agenda)->curso->getLink('disciplinas');


$total = 0;
$cont = '<p class="texto"> <table class="texto" style="width:550px" >';

foreach ($disciplinas as $disciplina) {
    $cont .= '<tr><td> - ' . $disciplina->nome . '</td><td>' . $disciplina->cargaHoraria . ' horas <td></tr>';
    $total += $disciplina->cargaHoraria;
}
$cont .= '<tr><td align="right">  TOTAL </td><td>' . $total . ' horas <td></tr>
    </table></p>';

$html = str_replace('{CARGA}', $total, $html);



$html = str_replace('{DATA}', dataEscrita(date('Y'), date('m'), date('d')), $html);




require_once("util/dompdf/dompdf_config.inc.php");

$dompdf = new DOMPDF();
$dompdf->load_html(utf8_decode($html));
$dompdf->set_paper('a4', 'portrait');
$dompdf->render();


$dompdf->stream("declaracao.pdf");

exit(0);
?>