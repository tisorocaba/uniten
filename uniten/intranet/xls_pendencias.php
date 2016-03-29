<?php
session_start();


if($_REQUEST['cod']==1){
   $data = $_SESSION['diariosSemPresencas']; 
   $filename = "Quantidade_de_diarios_sem_lancamentos_de_presencas.xls";
}elseif($_REQUEST['cod']==2){
   $data = $_SESSION['agendasSemMonitores'];
   $filename = "Cursos_sem_monitor.xls";
}elseif($_REQUEST['cod']==3){
    $data = $_SESSION['agendasPoucoAlunos'];
    $filename = "Cursos_com_pouco_ou_sem_alunos.xls";
}elseif($_REQUEST['cod']==4){
    $data = $_SESSION['agendasSemLancamentoAvaliacao'];
    $filename = "Cursos_sem_lancamento_de_avaliacao.xls";
}elseif($_REQUEST['cod']==5){
    $data = $_SESSION['agendasSemValorVale'];
    $filename = "Cursos_sem_lancamento_de_VT.xls";
}elseif($_REQUEST['cod']==6){
    $data = $_SESSION['agendasSemValor'];
    $filename = "Cursos_sem_lancamento_de_valor.xls";
    
}



header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel; charset=UTF-16LE");


$flag = false;
foreach ($data as $row) {
    if (!$flag) {
        echo implode("\t", array_keys($row)) . "\r\n";
        $flag = true;
    }
    
    array_walk($row, 'cleanData');
   
    echo implode("\t", array_values($row)) . "\r\n";
}

exit;

/* function cleanData(&$str) {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"'))
        $str = '"' . str_replace('"', '""', $str) . '"';
}*/

function cleanData(&$str) {
    if ($str == 't')
        $str = 'TRUE';
    if ($str == 'f')
        $str = 'FALSE';
    if (preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
        $str = "'$str";
    }
    if (strstr($str, '"'))
        $str = '"' . str_replace('"', '""', $str) . '"'; $str = mb_convert_encoding($str, 'UTF-16LE', 'UTF-8');
}

