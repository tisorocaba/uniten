<?php

function dd($obj){
    var_dump($obj);
    die;
}


function msg($msg) {
    echo("<script>
           alert('" . $msg . "');
         </script>");
}

function gotox($url) {
    die("<script>
           self.location = '" . $url . "';
         </script>");
}

function moedaToUS($valor) {
    $valor = str_replace('.', '', $valor);
    $valor = str_replace(',', '.', $valor);
    return $valor;
}

function moedaToBR($valor) {
    return number_format($valor, 2, ',', '.');
}

function extraCampoData($data, $campo = "dia") {
    list($ano, $mes, $dia) = explode('-', $data);
    if ($campo == 'ano') {
        return $ano;
    } elseif ($campo == 'mes') {
        return $mes;
    } else {
        return $dia;
    }
}

function criptografaSenha($password) {
    $hash = base64_encode(sha1($password, true));
    return $hash;
}

function dataBR($data_us, $time = "N") {
    $div = explode(" ", $data_us);
    @list($ano, $mes, $dia) = explode("-", $div[0]);
    $data_br1 = "$dia/$mes/$ano";
    if ($time == "N") {
        return $data_br1;
    } else {
        return $data_br1 . " " . @$div[1];
    }
}

function dataUS($data_br) {
    @list($dia, $mes, $ano) = explode("/", $data_br);
    $data_br1 = "$ano-$mes-$dia";
    return $data_br1;
}

function xdebug() {
    Lumine_Log::setLevel(Lumine_Log::ERROR);
    Lumine_Log::setOutput(Lumine_Log::BROWSER);
}

function errorAlert($msg) {
    die("<script>
           alert('" . $msg . "');
           history.go(-1);    
        </script>");
}

function geraSenha() {

    $vogais = 'aeiou';
    $consoante = 'bcdfghjklmnpqrstvwxyzbcdfghjklmnpqrstvwxyz';
    $numeros = '123456789';
    $resultado = '';

    $a = strlen($vogais) - 1;
    $b = strlen($consoante) - 1;
    $c = strlen($numeros) - 1;
    for ($x = 0; $x <= 1; $x++) {
        $aux1 = rand(0, $a);
        $aux2 = rand(0, $b);
        $aux3 = rand(0, $c);

        $aux4 = rand(0, $c);
        $aux5 = rand(0, $b);
        $aux6 = rand(0, $a);


        $str1 = substr($consoante, $aux1, 1);
        $str2 = substr($vogais, $aux2, 1);
        $str3 = substr($numeros, $aux3, 1);

        $str4 = substr($numeros, $aux4, 1);
        $str5 = substr($numeros, $aux5, 1);


        $resultado .= $str1 . $str2 . $str3 . $str4 . $str5;

        $resultado = trim($resultado);
    }


    return $resultado;
}

function validaCPF($cpf) {

    /*     * ****************************
      Calculando o primeiro digito
     * **************************** */
    $cpf = preg_replace('@\D@', '', $cpf);    // remove caracteres que n�o s�o n�meros

    if (strlen($cpf) != 11) {        // se for diferente de 11 caracteres
        return false;         // inv�lido
    }

    if (preg_match('@(\d{1})\1{10}@', $cpf)) {    // se a pessoa digitiou 11 numeros iguais
        return false;         // inv�lido
    }

    $dv_informado = substr($cpf, 9, 2);     // pega o digido verificador informado

    $soma = 0;         // soma para calculo do primeiro digito
    $multiplicador = 10;

    for ($i = 0; $i < 9; $i++) {        // para cada um dos 9 primeiros digitos
        $numeroatual = substr($cpf, $i, 1);    // pega o desejado
        $soma += ($numeroatual * $multiplicador); // efetua o calculo para soma do digito atual e soma com o resultado anterior
        $multiplicador--;        // diminui o valor do multiplicador
    }

    $dv1_encontrado = $soma % 11;      // pega o resto da divis�o por 11 para saber o primeiro DV
    if ($dv1_encontrado < 2) {        // se o DV encontrado for 1 ou 0 (ou seja, menor que 2)
        $dv1_encontrado = 0;       // coloca o valor como 0
    } else {           // mas se for maior ou igual a 2
        $dv1_encontrado = 11 - $dv1_encontrado;   // substrai o valor encontrado de 11
    }

    /*     * ****************************
      Calculando o segundo digito
     * **************************** */
    $multiplicador = 11;
    $soma = 0;

    for ($i = 0; $i < 10; $i++) {        // agora pegamos os 10 primeiros valores do CPF informado
        $numeroatual = substr($cpf, $i, 1);    // pega o desejado
        $soma += ($numeroatual * $multiplicador); // efetua o calculo para soma do digito atual e soma com o resultado anterior
        $multiplicador--;        // diminui o valor do multiplicador
    }


    $dv2_encontrado = $soma % 11;      // pega o resto da divis�o por 11 para saber o primeiro DV
    if ($dv2_encontrado < 2) {        // se o DV encontrado for 1 ou 0 (ou seja, menor que 2)
        $dv2_encontrado = 0;       // coloca o valor como 0
    } else {           // mas se for maior ou igual a 2
        $dv2_encontrado = 11 - $dv2_encontrado;   // substrai o valor encontrado de 11
    }

    $dv_final = $dv1_encontrado . $dv2_encontrado;  // monta o DV encontrado no calcula

    if ($dv_final != $dv_informado) {      // se o DV informado � diferente do encontrado no calculo
        return false;         // CPF inv�lido
    }

    // se chegou at� aqui, � porque � valido, EBA!
    return true;
}

function validaCNPJ($cnpj) {

    $cnpj = preg_replace("/\D/", "", $cnpj);
    if (strlen($cnpj) == 15) {
        $cnpj = substr($cnpj, 1, 14);
    }

    if (strlen($cnpj) <> 14)
        return false;
    $soma1 = ($cnpj[0] * 5) +
            ($cnpj[1] * 4) +
            ($cnpj[2] * 3) +
            ($cnpj[3] * 2) +
            ($cnpj[4] * 9) +
            ($cnpj[5] * 8) +
            ($cnpj[6] * 7) +
            ($cnpj[7] * 6) +
            ($cnpj[8] * 5) +
            ($cnpj[9] * 4) +
            ($cnpj[10] * 3) +
            ($cnpj[11] * 2);
    $resto = $soma1 % 11;
    $digito1 = $resto < 2 ? 0 : 11 - $resto;
    $soma2 = ($cnpj[0] * 6) +
            ($cnpj[1] * 5) +
            ($cnpj[2] * 4) +
            ($cnpj[3] * 3) +
            ($cnpj[4] * 2) +
            ($cnpj[5] * 9) +
            ($cnpj[6] * 8) +
            ($cnpj[7] * 7) +
            ($cnpj[8] * 6) +
            ($cnpj[9] * 5) +
            ($cnpj[10] * 4) +
            ($cnpj[11] * 3) +
            ($cnpj[12] * 2);

    $resto = $soma2 % 11;
    $digito2 = $resto < 2 ? 0 : 11 - $resto;
    return (($cnpj[12] == $digito1) && ($cnpj[13] == $digito2));
}

function deixaNumero($doc) {
    return preg_replace('@\D@', '', $doc);
}

function mascara($val) {

    if (strlen($val) === 11) {
        $mask = '###.###.###-##';
    } else {
        $mask = '##.###.###/####-##';
    }

    $maskared = '';
    $k = 0;
    for ($i = 0; $i <= strlen($mask) - 1; $i++) {
        if ($mask[$i] == '#') {
            if (isset($val[$k]))
                $maskared .= $val[$k++];
        } else {
            if (isset($mask[$i]))
                $maskared .= $mask[$i];
        }
    } return $maskared;
}

function exportMysqlToCsv($result, $filename = 'arquivo.csv') {


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

function calculaDiferencaDataAtual($data, $dataatual = '') {

    if ($dataatual == '') {
        $date1 = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
    } else {
        $aDataAtual = explode('/', $dataatual);
        $date1 = mktime(0, 0, 0, $aDataAtual[1], $aDataAtual[0], $aDataAtual[2]);
    }
    $aData = explode('/', $data);


    $date2 = mktime(0, 0, 0, $aData[1], $aData[0], $aData[2]);
    $dateDiff = $date2 - $date1;
    $fullDays = floor($dateDiff / (60 * 60 * 24));

    return($fullDays);
}

function xss_clean($data) {
    // Fix &entity\n;
    $data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
    $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
    $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

    // Remove any attribute starting with "on" or xmlns
    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

    // Remove javascript: and vbscript: protocols
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

    // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

    // Remove namespaced elements (we do not need them)
    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

    do {
        // Remove really unwanted tags
        $old_data = $data;
        $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
    } while ($old_data !== $data);

    // we are done...
    return $data;
}

function strip_word_html($text, $allowed_tags = '<br>') {
    mb_regex_encoding('UTF-8');
//replace MS special characters first
    $search = array('/&lsquo;/u', '/&rsquo;/u', '/&ldquo;/u', '/&rdquo;/u', '/&mdash;/u');
    $replace = array('\'', '\'', '"', '"', '-');
    $text = preg_replace($search, $replace, $text);
//make sure _all_ html entities are converted to the plain ascii equivalents - it appears
//in some MS headers, some html entities are encoded and some aren't
    $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
//try to strip out any C style comments first, since these, embedded in html comments, seem to
//prevent strip_tags from removing html comments (MS Word introduced combination)
    if (mb_stripos($text, '/*') !== FALSE) {
        $text = mb_eregi_replace('#/\*.*?\*/#s', '', $text, 'm');
    }
//introduce a space into any arithmetic expressions that could be caught by strip_tags so that they won't be
//'<1' becomes '< 1'(note: somewhat application specific)
    $text = preg_replace(array('/<([0-9]+)/'), array('< $1'), $text);
    $text = strip_tags($text, $allowed_tags);
//eliminate extraneous whitespace from start and end of line, or anywhere there are two or more spaces, convert it to one
    $text = preg_replace(array('/^\s\s+/', '/\s\s+$/', '/\s\s+/u'), array('', '', ' '), $text);
//strip out inline css and simplify style tags
    $search = array('#<(strong|b)[^>]*>(.*?)</(strong|b)>#isu', '#<(em|i)[^>]*>(.*?)</(em|i)>#isu', '#<u[^>]*>(.*?)</u>#isu');
    $replace = array('<b>$2</b>', '<i>$2</i>', '<u>$1</u>');
    $text = preg_replace($search, $replace, $text);
//on some of the ?newer MS Word exports, where you get conditionals of the form 'if gte mso 9', etc., it appears
//that whatever is in one of the html comments prevents strip_tags from eradicating the html comment that contains
//some MS Style Definitions - this last bit gets rid of any leftover comments */
    $num_matches = preg_match_all("/\<!--/u", $text, $matches);
    if ($num_matches) {
        $text = preg_replace('/\<!--(.)*--\>/isu', '', $text);
    }
    return $text;
}

function abreviaString($texto, $limite, $tres_p = '…') {
  //Retorna o texto em plain/text
  $texto = strip_word_html($texto,'');


  if (strlen($texto) <= $limite) {
        return $texto;
    }
    return array_shift(explode('||', wordwrap($texto, $limite, '||'))) . $tres_p;
}

function retornaMesEscrito($mes_port) {

    if ($mes_port == 1) {
        $esAno = "Janeiro";
    }
    if ($mes_port == 2) {
        $esAno = "Fevereiro";
    }
    if ($mes_port == 3) {
        $esAno = "Março";
    }
    if ($mes_port == 4) {
        $esAno = "Abril";
    }
    if ($mes_port == 5) {
        $esAno = "Maio";
    }
    if ($mes_port == 6) {
        $esAno = "Junho";
    }
    if ($mes_port == 7) {
        $esAno = "Julho";
    }
    if ($mes_port == 8) {
        $esAno = "Agosto";
    }

    if ($mes_port == 9) {
        $esAno = "Setembro";
    }
    if ($mes_port == 10) {
        $esAno = "Outubro";
    }
    if ($mes_port == 11) {
        $esAno = "Novembro";
    }
    if ($mes_port == 12) {
        $esAno = "Dezembro";
    }


    return($esAno);
}

function cut($string,$chars) {
    $inv = array(1=>',','.',';',':');
    $len = strlen($string);
    if ($chars < $len) {
        $string = substr($string,0,$chars);
        if (substr($string,-1,1) != ' ') {
            for ($x = -2; $x < 0 ; $x--) if (substr($string,$x,1) == ' ') break;
            $x = $chars + $x;
            $tmp = substr($string,0,$x);
            if (array_search(substr($tmp,-1,1),$inv)) return substr($tmp,0,strlen($tmp)-1).'...'; else return $tmp.'...';
        } else {
            if (array_search(substr($string,-2,1),$inv)) return substr($string,0,$chars-2).'...'; else return substr($string,0,$chars-1).'...';
        }
    } else return $string;
}