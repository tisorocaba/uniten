<?php

require_once 'util/config.php';
Security::admSecurity();
$obj = new Professor();

if(!empty ($_REQUEST['empresa'])){
    $sql = 'select nome, email,cpf,fone_ddd as ddd, fone_numero as fone, (select fantasia from empresa where id = empresa_id) as empresa from professor where empresa_id = '.$_REQUEST['empresa'].' and ativo = 1 order by nome asc';
}else{
    $sql = 'select nome, email,cpf,fone_ddd as ddd, fone_numero as fone, (select fantasia from empresa where id = empresa_id) as empresa  from professor where ativo = 1 order by nome asc';
}


$rs = $obj->_getConnection()->executeSQL($sql);

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'xls_professores', 'Exportou: lista de professores', $_REQUEST);


exportMysqlToCsv($rs);

function exportMysqlToCsv($result, $filename = 'professores.csv') {

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