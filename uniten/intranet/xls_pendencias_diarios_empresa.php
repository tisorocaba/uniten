<?php

require_once 'util/config.php';
Security::admSecurity();
$user = unserialize($_SESSION['USER']);
$obj = new AgendaCurso ();

if ($user->local == 1) {
    $sql = "SELECT 
                    LC.id as cod,
                                   (select nome from curso C, local_curso LC where LC.curso_id = C.id and LC.id = local_curso_id) as curso,
                                   (select local from local L, local_curso LC where LC.local_id = L.id and LC.id = local_curso_id) as local,
                                   (SELECT nome from professor where id = professor_id) as monitor,
                                   (select fantasia from empresa E, local_curso LC where LC.empresa_curso_id = E.id and LC.id = local_curso_id) as empresa,
                                   (select DATE_FORMAT(data_inicio,'%d/%m/%Y') from local_curso where id = local_curso_id ) as inicio,
                                   (select DATE_FORMAT(data_termino,'%d/%m/%Y') from local_curso where id = local_curso_id ) as termino,
                                       DATE_FORMAT(data_aula,'%d/%m/%Y') as data_do_diario


            FROM local_curso LC, diario_classe DC 
                    WHERE DC.local_curso_id = LC.id 
                    AND LC.data_inicio < CURRENT_DATE
                    AND DC.data_aula < fun_subtrai_data(CURRENT_DATE)
                    AND LC.status <= 2
                    AND DC.id NOT IN(SELECT diario_classe_id  FROM diario_classe_aluno)
                    AND  empresa_curso_id  = ".$_REQUEST['cod']."
                    ORDER 
                       BY local_curso_id DESC";
}else{
    $sql = "SELECT 
                    LC.id as cod,
                                   (select nome from curso C, local_curso LC where LC.curso_id = C.id and LC.id = local_curso_id) as curso,
                                   (select local from local L, local_curso LC where LC.local_id = L.id and LC.id = local_curso_id) as local,
                                   (SELECT nome from professor where id = professor_id) as monitor,
                                   (select fantasia from empresa E, local_curso LC where LC.empresa_curso_id = E.id and LC.id = local_curso_id) as empresa,
                                   (select DATE_FORMAT(data_inicio,'%d/%m/%Y') from local_curso where id = local_curso_id ) as inicio,
                                   (select DATE_FORMAT(data_termino,'%d/%m/%Y') from local_curso where id = local_curso_id ) as termino,
                                       DATE_FORMAT(data_aula,'%d/%m/%Y') as data_do_diario


            FROM local_curso LC, diario_classe DC 
                    WHERE DC.local_curso_id = LC.id 
                    AND LC.data_inicio < CURRENT_DATE
                    AND DC.data_aula < fun_subtrai_data(CURRENT_DATE)
                    AND LC.status <= 2
                    AND DC.id NOT IN(SELECT diario_classe_id  FROM diario_classe_aluno)
                    AND  empresa_curso_id  = ".$_REQUEST['cod']."
                    AND local_curso_id = " . $user->local . "    
                    ORDER 
                       BY local_curso_id DESC";
}


$rs = $obj->_getConnection()->executeSQL($sql);

exportMysqlToCsv($rs);

function exportMysqlToCsv($result, $filename = 'diariospendentes.csv') {

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