<?php

require_once 'util/config.php';
Security::admSecurity();
$obj = new AgendaCurso ();

if ($_REQUEST['busca'] == '' && $_REQUEST['local'] == '') {

    if ($_REQUEST['status'] == 0) {
        $sql = "select LC.id as cod, C.nome as curso, L.local, periodo, DATE_FORMAT(data_inicio, '%d/%m/%Y') as inicio, DATE_FORMAT(data_termino, '%d/%m/%Y') as termino, 
                (SELECT
                        SEC_TO_TIME(sum(TIME_TO_SEC(CAST(horas AS TIME))))
                FROM 
                        diario_classe  DC
                where local_curso_id = LC.id
                )  as horas_ministradas,
                          ((select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 0) +
(select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 1)+
(select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 2) + 
(select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 3) + 
(select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 4)) as inscritos,

((select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 1)+
(select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 2) + 
(select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 3) + 
(select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 4)) as matriculados,
                (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 2) as formados,
                vagas,
(select fantasia from empresa where id = LC.empresa_curso_id) as empresa
         from local_curso LC, curso C, local L 
         where status  > '" . $_REQUEST['status'] . "'
         and local_id = L.id
         and curso_id = C.id order by LC.id  desc";
    } else {
        $sql = "select LC.id as cod, C.nome as curso, L.local, periodo, DATE_FORMAT(data_inicio, '%d/%m/%Y') as inicio, DATE_FORMAT(data_termino, '%d/%m/%Y') as termino, 
(SELECT
                        SEC_TO_TIME(sum(TIME_TO_SEC(CAST(horas AS TIME))))
                FROM 
                        diario_classe  DC
                where local_curso_id = LC.id
                )  as horas_ministradas,
                           ((select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 0) +
(select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 1)+
(select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 2) + 
(select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 3) + 
(select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 4)) as inscritos,

((select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 1)+
(select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 2) + 
(select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 3) + 
(select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 4)) as matriculados,
                (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 2) as formados ,  
                vagas,
(select fantasia from empresa where id = LC.empresa_curso_id) as empresa

from local_curso LC, curso C, local L 
         where status = " . $_REQUEST['status'] . "
         and local_id = L.id
         and curso_id = C.id order by LC.id  desc";
    }
} else {
    if ($_REQUEST['busca'] != '') {

        if ($_REQUEST['status'] == 0) {
            $sql = "select LC.id as cod, C.nome as curso, L.local, periodo, DATE_FORMAT(data_inicio, '%d/%m/%Y') as inicio, DATE_FORMAT(data_termino, '%d/%m/%Y') as termino, 
                (SELECT
                        SEC_TO_TIME(sum(TIME_TO_SEC(CAST(horas AS TIME))))
                FROM 
                        diario_classe  DC
                where local_curso_id = LC.id
                )  as horas_ministradas,
                          ((select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 0) +
                            (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 1)+
                            (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 2) + 
                            (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 3) + 
                            (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 4)) as inscritos,

                            ((select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 1)+
                            (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 2) + 
                            (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 3) + 
                            (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 4)) as matriculados,
                            vagas,
                            (select fantasia from empresa where id = LC.empresa_curso_id) as empresa,
                (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 2) as formandos
                from local_curso LC, curso C, local L 
         where status > " . $_REQUEST['status'] . "
         and local_id = L.id
         and curso_id = C.id
         and (C.nome like '%" . $_REQUEST['busca'] . "%' or LC.id = '" . $_REQUEST['busca'] . "')
         order by LC.id desc";
        } else {
            $sql = "select LC.id as cod, C.nome as curso, L.local, periodo, DATE_FORMAT(data_inicio, '%d/%m/%Y') as inicio, DATE_FORMAT(data_termino, '%d/%m/%Y') as termino, (SELECT
                        SEC_TO_TIME(sum(TIME_TO_SEC(CAST(horas AS TIME))))
                FROM 
                        diario_classe  DC
                where local_curso_id = LC.id
                )  as horas_ministradas,
                          ((select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 0) +
                            (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 1)+
                            (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 2) + 
                            (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 3) + 
                            (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 4)) as inscritos,

                            ((select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 1)+
                            (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 2) + 
                            (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 3) + 
                            (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 4)) as matriculados,
                            vagas,
                            (select fantasia from empresa where id = LC.empresa_curso_id) as empresa,
                (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 2) as formandos from local_curso LC, curso C, local L 
         where status = " . $_REQUEST['status'] . "
         and local_id = L.id
         and curso_id = C.id
         and (C.nome like '%" . $_REQUEST['busca'] . "%' or LC.id = '" . $_REQUEST['busca'] . "')
         order by LC.id desc";
        }
    } else {
        if ($_REQUEST['status'] == 0) {
            $sql = "select LC.id as cod, C.nome as curso, L.local, periodo, DATE_FORMAT(data_inicio, '%d/%m/%Y') as inicio, DATE_FORMAT(data_termino, '%d/%m/%Y') as termino, (SELECT
                        SEC_TO_TIME(sum(TIME_TO_SEC(CAST(horas AS TIME))))
                FROM 
                        diario_classe  DC
                where local_curso_id = LC.id
                )  as horas_ministradas,
                         ((select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 0) +
                        (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 1)+
                        (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 2) + 
                        (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 3) + 
                        (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 4)) as inscritos,

                        ((select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 1)+
                        (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 2) + 
                        (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 3) + 
                        (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 4)) as matriculados,
                        vagas,
                        (select fantasia from empresa where id = LC.empresa_curso_id) as empresa,
                (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 2) as formandos from local_curso LC, curso C, local L 
         where status > " . $_REQUEST['status'] . "
         and local_id = L.id
         and curso_id = C.id
         and LC.local_id =" . $_REQUEST['local'] . " order by LC.id desc";
        }else{
            $sql = "select LC.id as cod, C.nome as curso, L.local, periodo, DATE_FORMAT(data_inicio, '%d/%m/%Y') as inicio, DATE_FORMAT(data_termino, '%d/%m/%Y') as termino, 
                (SELECT
                        SEC_TO_TIME(sum(TIME_TO_SEC(CAST(horas AS TIME))))
                FROM 
                        diario_classe  DC
                where local_curso_id = LC.id
                )  as horas_ministradas,
                            ((select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 0) +
                            (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 1)+
                            (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 2) + 
                            (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 3) + 
                            (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 4)) as inscritos,

                            ((select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 1)+
                            (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 2) + 
                            (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 3) + 
                            (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 4)) as matriculados,
                            vagas,
                            (select fantasia from empresa where id = LC.empresa_curso_id) as empresa,
                (select count(aluno_id) from local_curso_aluno where local_curso_id = LC.id and status = 2) as formandos from local_curso LC, curso C, local L 
         where status = " . $_REQUEST['status'] . "
         and local_id = L.id
         and curso_id = C.id
         and LC.local_id =" . $_REQUEST['local'] . " order by LC.id desc";
        }
        
    }
}

//die($sql);

unset($_SESSION['SQL']);

$rs = $obj->_getConnection()->executeSQL($sql);

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'xls_relatorios_agendas', 'Exportou: lista de relatorios agendas', $_REQUEST, '', 'Status: ' . $_REQUEST['status']);


exportMysqlToCsv($rs);

function exportMysqlToCsv($result, $filename = 'relatorios_agendas.csv') {

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
    exit();
}

?>