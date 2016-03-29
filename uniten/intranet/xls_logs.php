<?php

require_once 'util/config.php';
Security::admSecurity();
$obj = new AgendaCurso ();
$sql = $_SESSION['SQL'];
//unset($_SESSION['SQL']);
$rs = $obj->_getConnection()->executeSQL($sql);

exportMysqlToCsv($rs);

function exportMysqlToCsv($result, $filename = 'logs.csv') {

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
                   
                    if($j===5){
                        $posHora = $j-1;
                        $posCompletas = $j+1;
                        $row [$j] = converterHoraValor($row [$posHora],$row[$posCompletas]);
                       
                    }
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