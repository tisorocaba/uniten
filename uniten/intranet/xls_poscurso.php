<?php

require_once 'util/config.php';
Security::admSecurity();
$obj = new AgendaCurso ();
$agenda = $obj->escape($_SESSION['CODAGENDA']);
$rs = $obj->_getConnection()->executeSQL('SELECT  
                               (SELECT nome FROM aluno WHERE id = aluno_id ) as aluno,
                               (CASE trabalhando
                                     WHEN 1 THEN "Sim"
                                     WHEN 0 THEN "Não"
                                END) as trabalhando,

                                (CASE registrado
                                     WHEN 1 THEN "Sim"
                                     WHEN 0 THEN "Não"
                                END) as registrado,
                                empresa,
                                funcao,
                                 (CASE estava_empregado
                                     WHEN 1 THEN "Sim"
                                     WHEN 0 THEN "Não"
                                END) as estava_empregado,
                                 (CASE era_area
                                     WHEN 1 THEN "Sim"
                                     WHEN 0 THEN "Não"
                                END) as era_na_area,
                                 (CASE curso_ajudou
                                     WHEN 1 THEN "Sim"
                                     WHEN 0 THEN "Não"
                                END) as curso_ajudou,
                                obs,

                               DATE_FORMAT(data_cadastro, "%d/%m/%Y") data
                      FROM poscurso p
                      WHERE local_curso_id = ' . $agenda . ' ORDER BY aluno ASC');

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'xls_certificado', 'Exportou: lista de alunos pos-curso', $_REQUEST, '', 'Agenda: ' .$_SESSION['CODAGENDA']);

exportMysqlToCsv($rs);

function exportMysqlToCsv($result, $filename = 'poscurso.csv') {

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