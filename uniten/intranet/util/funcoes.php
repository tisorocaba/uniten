<?php

function xdebug() {
    Lumine_Log::setLevel(Lumine_Log::ERROR);
    Lumine_Log::setOutput(Lumine_Log::BROWSER);
}

function limpaCPF($cpf) {
    $cpf = str_replace('.', '', $cpf);
    $cpf = str_replace('-', '', $cpf);
    return $cpf;
}

function completaZero($prot) {
    $n = str_pad($prot, 4, "0", STR_PAD_LEFT);
    return $n;
}

function marcaPagina($offset, $limit) {
    return ($offset / $limit) + 1;
}

function calculaHoras($totalMin) {
    $hora = floor($totalMin / 60);
    $min = ($totalMin % 60);
    return $hora . ':' . $min;
}

function retornaMinutos($horas) {
    $aDado = explode(':', $horas);
    if ((int) $aDado[0] == 0) {
        return (int) @$aDado[1];
    } else {
        return (60 * (int) $aDado[0]) + (int) $aDado[1];
    }
}

function periodoCurso($periodo) {
    if ($periodo == 'M')
        return "Manhã";
    elseif ($periodo == 'T')
        return "Tarde";
    elseif ($periodo == 'N')
        return "Noite";
}

function statusAluno($status) {
    if ($status == 0)
        return "<span class=\"label label-primary\">Aguardando</spam>";
    elseif ($status == 1)
        return "<span class=\"label label-success\">Cursando</spam>";
    elseif ($status == 2)
        return "<span class=\"label label-success\">Aprovado</spam>";
    elseif ($status == 3)
        return "<span class=\"label label-danger\">Reprovado</spam>";
    else
        return "<span class=\"label label-danger\">Desistente</spam>";
}

function retornaRenda($renda) {
    if ($renda == 1)
        return "0 a 3 salários";
    elseif ($renda == 2)
        return "3 a 5 salários";
    else
        return "5 ou mais salários";
}

function cortaString($string, $cont) {

    $nString = substr($string, 0, $cont) . "...";
    return $nString;
}

function checkLogin($status = false) {

    if (empty($_SESSION['NOME'])) {
        msg('Voc� deve estar logado para acessar essa sess�o');
        gotox('index.php');
    }
    $numargs = func_num_args();

    if ($numargs > 0) {
        $status = func_get_arg(0);
        //echo $status." sess:".$_SESSION['STATUS'];
        if ($_SESSION['STATUS'] != $status) {
            msg('Voc� n�o tem permiss�o para acessar essa p�gina');
            gotox('index.php');
        }
    }
}

function fileIsOk($arq) {


    $aFiles = array(1 => 'pjpg', 2 => 'jpg', 3 => 'pjpg');

    $aArq = explode('.', $arq);
    $key = array_search(strtolower($aArq[1]), $aFiles);
    if ($key > 0) {
        return true;
    } else {
        return false;
    }
}

function logout($msg = '') {
    setSession(array());
    gotox('index.php?msg=' . urlencode($msg));
}

function acesso($dep, $res) {

    $user = getSession();
    //die($dep);
    if ($user['tipoUsuario']['tp_id'] > 2) {
        if ($dep != $user["departamento"]['dep_id']) {
            if ($res == "S") {
                echo "<script>alert('Pagina restrita a usu&#65533;rios desse departamento'); history.go(-1)</script>";
                die;
            }
        }
    }
}

function gotox($url) {
    echo "<script>self.location='" . $url . "'</script>";
    exit;
}

/* * ****************************************
 * inicia as variaves de POST caso n&#65533;o existam
 * @author Hugo
 * @param Lumine_Base $obj
 * *************************************** */

function initVars(Lumine_Base $obj) {
    $parts = $obj->_getObjectPart('_definition');
    foreach ($parts as $name => $part) {
        if (!isset($_POST[$name])) {
            $_POST[$name] = '';
        }
    }
}

function data_br($data_us = '') {
    $div = explode(" ", @$data_us);
    @list($ano, $mes, $dia) = explode("-", $div[0]);
    $data_br1 = "$dia/$mes/$ano";
    if (!empty($div[1])) {
        $data_br1 .= ' ' . $div[1];
    }
    return $data_br1;
}

function dataBR($data_us = '') {
    $div = explode(" ", @$data_us);
    @list($ano, $mes, $dia) = explode("-", $div[0]);
    $data_br1 = "$dia/$mes/$ano";
    return $data_br1;
}

function data_us($data_br = '') {
    $div = explode(" ", @$data_br);
    @list($dia, $mes, $ano) = explode("/", $div[0]);
    $data_br1 = "$ano-$mes-$dia";
    return $data_br1;
}

function converteMoedaFloat($valor) {
    $valor1 = str_replace(".", "", $valor);
    $valor2 = str_replace(",", ".", $valor1);
    return $valor2;
}

function converteFloatMoeda($number, $fractional = false) {
    //setlocale(LC_MONETARY, 'pt_BR');
    //return money_format('%.2n', $valor);
    return number_format($number, 2, ',', '.');
}

function lerArq($end) {
    $ponteiro = fopen($end, "r");
    $linha = "";
    while (!feof($ponteiro)) {
        $linha .= fgets($ponteiro, 4096);
    }
    fclose($ponteiro);
    return ($linha);
}

function enviaSenhaUsuario($nome, $login, $senha, $email) {

    $html = getHTTP('http://www.sorocaba.sp.gov.br/uniten/intranet/modelo/envio-senha.php');

    $html = str_replace('{NOME}', $nome, $html);
    $html = str_replace('{LOGIN}', $login, $html);
    $html = str_replace('{SENHA}', $senha, $html);

    enviaEmail('uniten@sorocaba.sp.gov.br', $email, 'UNITEN :: Dados de Acesso', utf8_decode($html));
}

function enviaSenhaEmpresa($nome, $cnpj, $senha, $email) {

    $html = getHTTP('http://www.sorocaba.sp.gov.br/uniten/intranet/modelo/envio-senha-empresa.php');

    $html = str_replace('{NOME}', $nome, $html);
    $html = str_replace('{LOGIN}', $cnpj, $html);
    $html = str_replace('{SENHA}', $senha, $html);

    $ret = enviaEmail('uniten@sorocaba.sp.gov.br', $email, 'UNITEN EMPREGA :: Dados de Acesso', utf8_decode($html));

    //die($ret);
}

function reenviaSenhaEmpresa($nome, $cnpj, $senha, $email) {

    $html = getHTTP('http://www.sorocaba.sp.gov.br/uniten/intranet/modelo/reenvio-senha-empresa.php');

    $html = str_replace('{NOME}', $nome, $html);
    $html = str_replace('{LOGIN}', $cnpj, $html);
    $html = str_replace('{SENHA}', $senha, $html);

    $ret = enviaEmail('uniten@sorocaba.sp.gov.br', $email, 'UNITE EMPREGA :: REENVIO DE SENHA', utf8_decode($html));

    //die($ret);
}

function enviaEmail($de, $para, $assunto, $msg) {

    //////////////////////////////
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From: ".$de."\r\n"; // remetente

    if (mail($para, $assunto, $msg, $headers)){
           return "OK";
    }else{
       return "ERRO";
    }

}

function getHTTP($url, $param = '') {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 120); // segundos
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
    $conteudo = curl_exec($ch);
    curl_close($ch);



    return $conteudo;
}

function retornaData($meses, $sinal) {
    if ($sinal == "+") {
        return date("Y-m-d", mktime(0, 0, 0, date("m") + $meses, date("d"), date("Y")));
    } else {
        return date("Y-m-d", mktime(0, 0, 0, date("m") - $meses, date("d"), date("Y")));
    }
}

function msg($msg) {
    echo "<script>alert('" . $msg . "')</script>";
}

function dataEscrita($ano, $mes, $dia) {
    $dia_port = date("w", mktime(0, 0, 0, $mes, $dia, $ano));



    $mes_port = date("m", mktime(0, 0, 0, $mes, $dia, $ano));

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


    $escrita = " Sorocaba, " . $dia . " de " . $esAno . " de " . $ano;

    return($escrita);
}

function mostraMes($mes_port) {



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

function criptografaSenha($password) {
    $hash = base64_encode(sha1($password, true));
    return $hash;
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

function xss_protect($data, $strip_tags = false, $allowed_tags = "") {
    if ($strip_tags) {
        $data = strip_tags($data, $allowed_tags . "<b>");
    }

    if (stripos($data, "script") !== false) {
        $result = str_replace("script", "scr<b></b>ipt", htmlentities($data, ENT_QUOTES));
    } else {
        $result = htmlentities($data, ENT_QUOTES);
    }

    return $result;
}

function retornaEstadoCivil($estadoCivil) {
    if ($estadoCivil == 'S')
        return "Solteiro(a)";
    elseif ($estadoCivil == 'C')
        return "Casado(a)";
    elseif ($estadoCivil == 'D')
        return "Divorciado(a)";
    elseif ($estadoCivil == 'A')
        return "Amasiado(a)";
    else
        return "Viúvo(a)";
}

function situacaoHabitacional($sit) {
    if ($sit == 'A')
        echo "Reside com os pais";
    elseif ($sit == 'B')
        echo "Reside em imóvel cedido";
    else
        echo "Outros";
}

function escolaridade($escolaridade) {
    if ($escolaridade == 'EF')
        echo "Ensino Fundamental";
    elseif ($escolaridade == 'EFI')
        echo "Ensino Fundamental Incompleto";
    elseif ($escolaridade == 'EM')
        echo "Ensino Medio";
    elseif ($escolaridade == 'EMI')
        echo "Ensino Medio Incompleto";
    elseif ($escolaridade == 'ES')
        echo "Ensino Superior";
    else
        echo "Ensino Superior Incompleto";
}

function ramoAtividade($ramo) {
    if ($ramo == '1')
        return "Administrativo";
    elseif ($ramo == '2')
        return "Alimentos";
    elseif ($ramo == '3')
        return "Beleza";
    elseif ($ramo == '4')
        return "Comércio";
    elseif ($ramo == '5')
        return "Informática";
    elseif ($ramo == '6')
        return "Eletrônica";
    else
        return "Metal Mecânica";
}

function porteEmpresa($porte) {
    if ($porte == '1')
        return "Micro";
    elseif ($porte == '2')
        return "Pequena";
    elseif ($porte == '3')
        return "Média";
    elseif ($porte == '4')
        return "Grande";
}

function faseProcesso($fase) {

    if ($fase == 1) {
        $titulo = "Entrevista";
    } elseif ($fase == 2) {
        $titulo = "Experiência";
    } elseif ($fase == 3) {
        $titulo = "Efetivo";
    } else {
        $titulo = "Deligado";
    }

    return $titulo;
}

function converterHoraValor($horas, $valorporhora) {

    $aDados = explode(':', $horas);
    $totalMinuto = 0;
    if (!empty($aDados[1])) {
        $valorMinuto = ((float) $valorporhora / 60);
        $totalMinuto = $valorMinuto * (int) $aDados[1];
    }

    $totalHora = (int) $aDados[0] * (float) $valorporhora;

    return $totalHora + $totalMinuto;
}

function extraiSegundo($horas) {
    $aDados = explode(':', $horas);
    return $aDados[0] . ':' . $aDados[1];
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
    $dateDiff = $date1 - $date2;
    $fullDays = floor($dateDiff / (60 * 60 * 24));

    return($fullDays);
}

function calculaIdade($data_nascimento, $data_calcula = '') {

    $data_nascimento = $this->dataUS($data_nascimento);



    if ($data_calcula == '') {
        $data_calcula = date('Y-m-d');
    }
    $data_nascimento = strtotime($data_nascimento . " 00:00:00");
    $data_calcula = strtotime($data_calcula . " 00:00:00");
    $idade = floor(abs($data_calcula - $data_nascimento) / 60 / 60 / 24 / 365);
    return($idade);
}

function checaData($data) {
    $aData = explode('/', $data);
    return checkdate($aData[1], $aData[0], $aData[2]);
}

function isDiaUtil($data) {

    //Colocamos em um array os dia de fim de semana (sábado e domingo)
    $fds = array('6', '0');

    //Verificamos qual é o dia da semana
    $diaSemana = date('w', strtotime($data));


    //Aqui verficamos se é o dia útil
    if (in_array($diaSemana, $fds)) {
        return false;
    } else {
        return true;
    }
}

function statusResposta($resposta) {

    if (is_numeric($resposta)) {
        if ($resposta == 1)
            return "Péssimo";
        elseif ($resposta == 2)
            return "Regular";
        elseif ($resposta == 3)
            return "Bom";
        elseif ($resposta == 4)
            return "Muito Bom";
        else
            return "Excelente";
    }else {
        if ($resposta == 'N') {
            echo "Não";
        } else {
            echo "Sim";
        }
    }
}

function statusCursoLocal($status) {
    if ($status == 1)
        return "Em Andamento";
    elseif ($status == 2)
        return "Finalizado";
    elseif ($status == 3)
        return "Cancelado";
    elseif ($status == 4)
        return "Agendado";
    else
        return "Todos";
}

// utilizado na grade de aulas
function calculadorTempo($tempos) {
    $segundos = 0;

    foreach ($tempos as $tempo) { //percorre o array $tempo
        list( $h, $m, $s ) = explode(':', $tempo); //explode a variavel tempo e coloca as horas em $h, minutos em $m, e os segundos em $s
//transforma todas os valores em segundos e add na variavel segundos

        $segundos += $h * 3600;
        $segundos += $m * 60;
        $segundos += $s;
    }

    $horas = floor($segundos / 3600); //converte os segundos em horas e arredonda caso nescessario
    $segundos %= 3600; // pega o restante dos segundos subtraidos das horas
    $minutos = floor($segundos / 60); //converte os segundos em minutos e arredonda caso nescessario
    $segundos %= 60; // pega o restante dos segundos subtraidos dos minutos

    return $horas . ':' . $minutos;
    //echo "{$horas}:{$minutos}:{$segundos}";
}

function reduzirNome($texto, $tamanho) {
    // Se o nome for maior que o permitido
    if (strlen($texto) > ( $tamanho - 2 )) {
        
        // tira as marcações html e php da string
        $texto = trim(strip_tags($texto));   
        
        // cria uma matriz (palavras) separando cada palavra do nome
        $palavas = explode(' ', $texto);
        
        // Pego o primeiro nome
        $nome = $palavas[0];
                
        // Pego o ultimo nome
        $sobrenome = trim($palavas[count($palavas) - 1]);

        // Vejo qual e a posicao do ultimo nome
        $ult_posicao = count($palavas) - 1;
        

        // Crio uma variavel para receber os nomes do meio abreviados
        $meio = '';
        
        // Listo todos os nomes do meios e abrevio eles
        for ($a = 1; $a < $ult_posicao; $a++):
            // Enquanto o tamanho do nome nao atingir o limite de caracteres
            // completo com o nomes do meio abreviado
            if (strlen($nome . ' ' . $meio . ' ' . $sobrenome) <= $tamanho):
                $meio .= ' ' . strtoupper(substr($palavas[$a], 0, 1));
            endif;
        endfor;

    }
    else 
    {
        $nome = $texto;
        $meio = '';
        $sobrenome = '';
    }
    
    return trim($nome . $meio . ' ' . $sobrenome);

}

function getBrowser() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version = "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $bname = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
            $version = $matches['version'][0];
        } else {
            $version = $matches['version'][1];
        }
    } else {
        $version = $matches['version'][0];
    }

    // check if we have a number
    if ($version == null || $version == "") {
        $version = "?";
    }

    return array(
        'userAgent' => $u_agent,
        'name' => $bname,
        'version' => $version,
        'platform' => $platform,
        'pattern' => $pattern
    );
}
