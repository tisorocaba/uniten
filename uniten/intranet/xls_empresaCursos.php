<?php

require_once 'util/config.php';
Security::admSecurity();
$obj = new AgendaCurso ();
$empresa = $obj->escape($_REQUEST['empresa']);
if(!empty($_REQUEST['status'])){
    $status = $obj->escape($_REQUEST['status']);
}else{
    $status = 1;
}

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'xls_empresaCursos', 'Exportou: lista de cursos da empresa', $_REQUEST, '', 'Empresa: ' .$empresa);

$rs = $obj->_getConnection()->executeSQL("select 

id as cod,
(select nome from curso where curso_id = id) as Curso,
(select fantasia from empresa where id = empresa_curso_id) as Empresa,
(select local from local where local_id = id) as Local,
DATE_FORMAT(data_inicio, '%d/%m/%Y') as Inicio,
DATE_FORMAT(data_termino, '%d/%m/%Y') as Termino,
(CASE status
                                     WHEN 1 THEN 'Em andamento'
                                     WHEN 2 THEN 'Finalizado'
                                     WHEN 2 THEN 'Cancelado'
                                END) as Status

from local_curso where empresa_curso_id = '".$empresa."' and status = ".$status." ORDER BY data_inicio DESC");

exportMysqlToCsv($rs);

function exportMysqlToCsv($result, $filename = 'cursoempresas.csv') {

    global $tema;
    $csv_terminated = "\n";
    $csv_separator = ";";
    $csv_enclosed = '"';
    $csv_escaped = "\\";


    $fields_cnt = mysql_num_fields($result);

    $schema_insert = '';

    for ($i = 0; $i < $fields_cnt; $i++) {
        $l = $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, stripslashes(mysql_field_name($result, $i))) . $csv_enclosed;
        $schema_insert .= $l;
        $schema_insert .= $csv_separator;
    } // end for


    $out = trim(substr($schema_insert, 0, - 1));
    $out .= $csv_terminated;

 
    while ($row = mysql_fetch_array($result)) {




        $schema_insert = '';
        for ($j = 0; $j < $fields_cnt; $j++) {
            if ($row [$j] == '0' || $row [$j] != '') {

                if ($csv_enclosed == '') {
                    $schema_insert .= utf8_decode($row [$j]);
                } else {
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, utf8_decode($row [$j])) . $csv_enclosed;
                }
            } else {
                $schema_insert .= '';
            }

            if ($j < $fields_cnt - 1) {
                $schema_insert .= $csv_separator;
            }
        }


        $out .= $schema_insert;
        $out .= $csv_terminated;
    }


    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Length: " . strlen($out));
    header("Content-type: application/csv");
    header("Content-Disposition: attachment; filename=$filename");
    echo $out;
    exit ();
}

?>