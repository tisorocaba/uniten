<?php

require_once 'util/config.php';
Security::admSecurity();
$obj = new AgendaCurso ();

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->id, 'diarioCadastro', '',$_REQUEST);

$rs = $obj->_getConnection()->executeSQL('SELECT  
                               (SELECT upper(nome) FROM aluno WHERE id = aluno_id ) as aluno,
                               (SELECT nome FROM local_curso LC, curso C WHERE LC.id = local_curso_id and C.id = curso_id ) as curso,
                                DATE_FORMAT((SELECT data_termino FROM local_curso WHERE id = local_curso_id ),"%d/%m/%Y") as data_termino,
                               (select sum(carga_horaria) from disciplina D, curso_disciplina CD, local_curso LC  
                                 where  LC.id = LCA.local_curso_id
                                 and LC.curso_id = CD.curso_id 
                                 and CD.disciplina_id = D.id  ) as carga_horaria
                                 
      
                      FROM local_curso_aluno LCA
                      WHERE local_curso_id = '.$_SESSION['CODAGENDA'].' AND status = 2 ORDER BY aluno ASC ');

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'xls_certificado', 'Exportou: lista de candidatos para certificado', $_REQUEST, '', 'Agenda: ' .$_SESSION['CODAGENDA']);


exportMysqlToCsv($rs);

function exportMysqlToCsv($result, $filename = 'alunos.csv') {

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