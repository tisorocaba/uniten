<?php
require_once '../util/config.php';
Security::provaSecurity();
$user = unserialize($_SESSION['USER']);


$obj = new AgendaCurso ();
$agenda = $obj->escape($_REQUEST['agenda']);
$obj->get($agenda);

if($obj->empresaProva!=$user->empresa->id){
    die('Acesso negado');
}


logDao::gravaLog($user->login, 'xls_candidatos', 'Exportou: lista de candidatos ', $_REQUEST,'','Agenda: '.$agenda);




$rs = $obj->_getConnection()->executeSQL('SELECT   CONCAT(local_curso_id, "-", aluno_id) as protocolo,
    (SELECT local FROM local L, local_curso LC WHERE LC.id = local_curso_id and LC.local_id = L.id ) as unidade,    
                               (SELECT periodo FROM  local_curso LC WHERE LC.id = local_curso_id ) as periodo, 
                               (SELECT UPPER(nome) FROM aluno WHERE id = aluno_id ) as aluno,
                               (SELECT concat(ddd, " - ", telefone) FROM aluno WHERE id = aluno_id ) as telefone,
                               (SELECT bolsa_familia FROM aluno WHERE id = aluno_id ) as bolsa_familia,
                               (SELECT cpf FROM aluno WHERE id = aluno_id ) as cpf,
                               (SELECT rg FROM aluno WHERE id = aluno_id ) as rg,
                               (SELECT email FROM aluno WHERE id = aluno_id ) as email,
                               (SELECT UPPER(endereco) FROM aluno WHERE id = aluno_id ) as endereco,
                               (SELECT numero FROM aluno WHERE id = aluno_id ) as numero,
                               DATE_FORMAT((SELECT data_nascimento FROM aluno WHERE id = aluno_id ),"%d/%m/%Y") as data_nascimento,
                               (SELECT bairro FROM aluno WHERE id = aluno_id ) as bairro,
                               (SELECT cidade FROM aluno WHERE id = aluno_id ) as cidade,
                               
                               (SELECT sexo FROM aluno WHERE id = aluno_id ) as sexo,
                               (SELECT cor FROM aluno WHERE id = aluno_id ) as cor,     
                               (SELECT renda FROM aluno WHERE id = aluno_id ) as renda, 
                               (SELECT pessoas_moradia FROM aluno WHERE id = aluno_id ) as pessoas_moradia, 
                               (SELECT possui_deficiencia FROM aluno WHERE id = aluno_id ) as possui_deficiencia, 
                               (SELECT tipo_deficiencia FROM aluno WHERE id = aluno_id ) as tipo_deficiencia, 
                               (SELECT condicao_especial_prova FROM aluno WHERE id = aluno_id ) as condicao_especial_prova, 
                               (SELECT condicao_especial_qual FROM aluno WHERE id = aluno_id ) as condicao_especial_qual, 

                               (SELECT ctps FROM aluno WHERE id = aluno_id ) as ctps,
                               (SELECT serie FROM aluno WHERE id = aluno_id ) as serie,
                               (SELECT serie FROM aluno WHERE id = aluno_id ) as serie,
                               classificacao,
                               DATE_FORMAT(data_cadastro, "%d/%m/%Y") data
                      FROM local_curso_aluno
                      WHERE local_curso_id = ' . $agenda . ' ORDER BY classificacao ASC, aluno ASC ');

exportMysqlToCsv($rs);



function exportMysqlToCsv($result, $filename = 'candidatos.csv') {

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