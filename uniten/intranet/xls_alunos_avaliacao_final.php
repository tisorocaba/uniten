<?php

require_once 'util/config.php';
Security::admSecurity();
$obj = new AgendaCurso ();
$agenda = $obj->escape($_REQUEST['agenda']);

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'xls_alunos_avaliacao_final', 'Exportou: lista de avaliacao final', $_REQUEST, '', 'Agenda: ' .$agenda);

$rs = $obj->_getConnection()->executeSQL('SELECT   aluno_id as id,
                               (SELECT nome FROM aluno WHERE id = aluno_id ) as aluno,
                               (SELECT concat(ddd, " - ", telefone) FROM aluno WHERE id = aluno_id ) as telefone,
                               (SELECT bolsa_familia FROM aluno WHERE id = aluno_id ) as bolsa_familia,
                               (SELECT cpf FROM aluno WHERE id = aluno_id ) as cpf,
                               (SELECT rg FROM aluno WHERE id = aluno_id ) as rg,
                               (SELECT email FROM aluno WHERE id = aluno_id ) as email,
                               (SELECT endereco FROM aluno WHERE id = aluno_id ) as endereco,
                               (SELECT numero FROM aluno WHERE id = aluno_id ) as numero,
                               DATE_FORMAT((SELECT data_nascimento FROM aluno WHERE id = aluno_id ),"%d/%m/%Y") as data_nascimento,
                               (SELECT bairro FROM aluno WHERE id = aluno_id ) as bairro,
                               (SELECT cidade FROM aluno WHERE id = aluno_id ) as cidade,

                               (SELECT ctps FROM aluno WHERE id = aluno_id ) as ctps,
                               (SELECT serie FROM aluno WHERE id = aluno_id ) as serie,

                               classificacao,nota,
                               (CASE status
                                     WHEN 1 THEN "Cursando"
                                     WHEN 2 THEN "Aprovado"
                                     WHEN 3 THEN "Reprovado"
                                     WHEN 4 THEN "Desistiu"
                                END) as status,
                               DATE_FORMAT(data_cadastro, "%d/%m/%Y") data
                      FROM local_curso_aluno
                      WHERE local_curso_id = ' . $agenda . ' AND status >= 1 AND  status < 4  ORDER BY classificacao ASC, aluno ASC ');



exportMysqlToCsv($rs);

function exportMysqlToCsv($result, $filename = 'alunos_avaliacao_final.csv') {

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