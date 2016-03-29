<?php

/**
 * Classe responsavel por redirecionamento, alerts, geracao de arquivos e leitura
 * 
 * @author Rogerio Lima
 * @version 0.1
 * @copyright Splicenet � 2009, splicenet.com.br
 * @access public
 * @package splicenet
 * @subpackage util
 * @example UtilManager::msg($msg);
 */
class Utilmanager {

    /**
     * Construtor da classe
     * @access public
     * @param void
     * @return void
     */
    function Utilmanager() {
        
    }

    /**
     * Metodo responsavel por emitir alerts
     * @access public
     * @param String $msg 
     * @return void
     */
    function msg($msg) {

        echo "<script> alert('" . $msg . "'); </script>";
    }

    function myredirect($url) {
        echo "<script>self.location='" . $url . "';</script>";
        die();
    }

    function buscaCEP($cep) {
        // $url = 'http://apis.splicenet.com.br/cep/consulta_cep.php?cep=' . $cep . '&formato=xml';
        // $url = 'http://sistemas.sorocaba.sp.gov.br:9090/comdata/endereco/pesquisarPorCep?cep=' . $cep;
        
        // $resp = $this->getURL($url);

        // $json = json_encode($resp);

        // return utf8_encode($json->logradouro);

        return utf8_encode("teste|teste2|teste3|teste4");
        
        // $xml = new SimpleXMLElement($resp);
        // if((int)$xml->retorno === -1){
        //     return "ERRO";
        // }else{
        //     if($xml->logradouro != ''){
        //          return utf8_encode((string)$xml->logradouro . "|" . trim((string)$xml->bairro) . "|" . trim((string)$xml->cidade) . "|" . trim((string)$xml->estado));
        //     }else{
        //         return utf8_encode("||" . trim((string)$xml->cidade) . "|" . trim((string)$xml->estado));
        //     }
        // }       
    }

    function buscaCEPSTR($cep) {
        $url = 'http://apis.splicenet.com.br/cep/consulta_cep.php?cep=' . $cep . '&formato=string';
        $resp = $this->getURL($url);

        $aDados = explode('|', $resp);

        if (count($aDados) === 0) {
            return "ERRO";
        } elseif (empty($aDados[3])) {
            return utf8_encode("||" . $aDados[0] . "|" . $aDados[1]);
        } else {
            return utf8_encode($aDados[0] . "|" . trim($aDados[1]) . "|" . trim($aDados[2]) . "|" . trim($aDados[3]));
        }
    }

    /* function buscaCEP($cep) {
      $url = 'http://www.buscarcep.com.br/?cep=' . $cep . '&formato=string&chave=1ZSn1itzrqlSEcV7MYkYzEnRxrvzKu/';
      $resp = $this->getURL($url);
      if (strpos($resp, "cidade") != false) {
      if (!empty($resp)) {
      $aString = explode('&resultado', $resp);
      $aLimp = explode('&', $aString [0]);
      $end = str_replace('logradouro=', '', $aLimp [6]);
      $bairro = str_replace('bairro=', '', $aLimp [4]);
      $cidade = str_replace('cidade=', '', $aLimp [3]);
      $uf = str_replace('uf=', '', $aLimp [2]);
      return utf8_encode(($end)) . "|" . utf8_encode($bairro) . "|" . utf8_encode($cidade) . "|" . $uf;
      }
      } else {
      return 'ERRO';
      }
      } */

    function getURL($url, $vars = '') {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 12); // segundos
        curl_setopt($ch, CURLOPT_REFERER, "");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        $result = curl_exec($ch);
        //die($result."  -- ret");
        curl_close($ch);
        return $result;
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

    /**
     * Metodo generico de envio de emails
     *
     * @access public
     * @param String $de, $para, $assunto, $msg
     * @return String $conteudo
     */
    function enviaEmail($de, $para, $assunto, $msg) {
        
        /*$param = "de=" . $de;
        $param .= "&para=" . $para;
        $param .= "&assunto=" . $assunto;
        $param .= "&msg=" . $msg;


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "webmail.splicenet.com.br/dominios/reservas/mail.php");
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120); // segundos
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $conteudo = curl_exec($ch);
        curl_close($ch);

        return $conteudo;*/

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

    function dataBR($data_us) {
        $div = explode(" ", $data_us);
        @list($ano, $mes, $dia) = explode("-", $div[0]);
        $data_br1 = "$dia/$mes/$ano";
        return $data_br1 . " " . @$div[1];
    }

    function dataUS($data_br) {
        @list($dia, $mes, $ano) = explode("/", $data_br);
        $data_br1 = "$ano-$mes-$dia";
        return $data_br1;
    }

    function limpaCPF($cpf) {
        $cpf = str_replace('.', '', $cpf);
        $cpf = str_replace('-', '', $cpf);
        return $cpf;
    }

    function moedaToBanco($valor) {
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
        return $valor;
    }

    public function verificacpf($cpf) {
        /*         * ****************************
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
            $soma += ( $numeroatual * $multiplicador); // efetua o calculo para soma do digito atual e soma com o resultado anterior
            $multiplicador--;        // diminui o valor do multiplicador
        }

        $dv1_encontrado = $soma % 11;      // pega o resto da divis�o por 11 para saber o primeiro DV
        if ($dv1_encontrado < 2) {        // se o DV encontrado for 1 ou 0 (ou seja, menor que 2)
            $dv1_encontrado = 0;       // coloca o valor como 0
        } else {           // mas se for maior ou igual a 2
            $dv1_encontrado = 11 - $dv1_encontrado;   // substrai o valor encontrado de 11
        }

        /*         * ****************************
          Calculando o segundo digito
         * **************************** */
        $multiplicador = 11;
        $soma = 0;

        for ($i = 0; $i < 10; $i++) {        // agora pegamos os 10 primeiros valores do CPF informado
            $numeroatual = substr($cpf, $i, 1);    // pega o desejado
            $soma += ( $numeroatual * $multiplicador); // efetua o calculo para soma do digito atual e soma com o resultado anterior
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

}

?>