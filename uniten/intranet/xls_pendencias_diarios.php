<?php
/*setlocale(LC_TIME,"portuguese");
$data_completa = strftime("Hoje é %A, %d de %B de %Y");
echo $data_completa;*/
require_once 'util/config.php';
Security::admSecurity();
$user = unserialize($_SESSION['USER']);
$obj = new AgendaCurso ();

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'xls_pendencias_diarios', 'Exportou: lista de agendas sem diarios', $_REQUEST, '', '');

if ($user->local == 1) {
    $sql = /*"select 
                        LC.id as cod,
                        (select nome from curso C where LC.curso_id = C.id ) as curso,
                        (select local from local L where LC.local_id = L.id ) as local,
                         periodo,
                        (select fantasia from empresa E where LC.empresa_curso_id = E.id ) as empresa,
                       
                        DATE_FORMAT(data_inicio,'%d/%m/%Y') as inicio,
                        DATE_FORMAT(data_termino,'%d/%m/%Y') as termino
					 from local_curso LC 
					 where data_inicio < DATE_SUB(CURDATE(),INTERVAL 1 DAY)
					 and data_termino > CURDATE()
                                         and status = 1
					 and id not in (select local_curso_id from diario_classe where data_aula = DATE_SUB(CURDATE(),INTERVAL 1 DAY))
					 and empresa_curso_id = ".$_REQUEST['cod'];*/
					 
					" SELECT 
                        LC.id as cod,
                        local,
                        nome,
                        (select fantasia from empresa E where empresa_curso_id = E.id ) as empresa,
                        DATE_FORMAT(data_inicio,'%d/%m/%Y') as inicio,
                        DATE_FORMAT(data_inicio,'%d/%m/%Y')  as termino
                    FROM local_curso LC, local L, curso C
                            WHERE  local_id = L.id
                            AND curso_id = C.id
                            AND LC.status <> 3
                            AND LC.id NOT IN(SELECT local_curso_id  FROM diario_classe)
                            ORDER BY data_inicio desc
";
    
    
}else{
    $sql =/* "select 
                        LC.id as cod,
                        (select nome from curso C where LC.curso_id = C.id ) as curso,
                        (select local from local L where LC.local_id = L.id ) as local,
                         periodo,
                        (select fantasia from empresa E where LC.empresa_curso_id = E.id ) as empresa,
                         DATE_FORMAT(DATE_SUB(CURDATE(),INTERVAL 1 DAY),'%d/%m/%Y') as data_do_diario,
                        DATE_FORMAT(data_inicio,'%d/%m/%Y') as inicio,
                        DATE_FORMAT(data_termino,'%d/%m/%Y') as termino
					 from local_curso LC 
					 where data_inicio < DATE_SUB(CURDATE(),INTERVAL 1 DAY)
					 and data_termino > CURDATE()
                                         and status = 1
					 and id not in (select local_curso_id from diario_classe where data_aula = DATE_SUB(CURDATE(),INTERVAL 1 DAY))
					 and empresa_curso_id = ".$_REQUEST['cod']."
                    and local_curso_id = " . $user->local . "    
                    order by local_curso_id DESC";*/
					
					" SELECT 
                        LC.id as cod,
                        local,
                        nome,
                        (select fantasia from empresa E where empresa_curso_id = E.id ) as empresa,
                        DATE_FORMAT(data_inicio,'%d/%m/%Y') as inicio,
                        DATE_FORMAT(data_inicio,'%d/%m/%Y')  as termino
                    FROM local_curso LC, local L, curso C
                            WHERE  local_id = L.id
                            AND curso_id = C.id
                            AND LC.status <> 3
                            AND LC.id NOT IN(SELECT local_curso_id  FROM diario_classe)
                            ORDER BY data_inicio desc
                            local_id = " . $user->local . " 
";
}



$rs = $obj->_getConnection()->executeSQL($sql);

exportMysqlToCsv($rs);

function exportMysqlToCsv($result, $filename = 'agendasSemDiarios.csv') {

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