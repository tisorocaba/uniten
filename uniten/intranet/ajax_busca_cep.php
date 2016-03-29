<?php
header("Content-Type: text/html; charset=LATIN1",true);
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if(empty($_REQUEST ['cep'])){
  die;
}

$url = 'http://www.buscarcep.com.br/?cep=' . $_REQUEST ['cep'] . '&formato=string&chave=1ZSn1itzrqlSEcV7MYkYzEnRxrvzKu/';

$resp = _getUrl($url);

if (!empty($resp)) {
    $aString = explode('&resultado', $resp);
    $aLimp = explode('&', $aString [0]);

    $end = str_replace('logradouro=', '', $aLimp [6]);
    $bairro = str_replace('bairro=', '', $aLimp [4]);
    $cidade = str_replace('cidade=', '', $aLimp [3]);
    $uf = str_replace('uf=', '', $aLimp [2]);


    //echo _retiraAcentuacao($end) . "|" . _retiraAcentuacao($bairro) . "|" . _retiraAcentuacao($cidade) . "|" . $uf;
    echo ($end) . "|" . ($bairro) . "|" . ($cidade) . "|" . $uf;
}

function _getUrl($url = '', $param='') {

    $ch = curl_init ();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 12); // segundos
    curl_setopt($ch, CURLOPT_REFERER, "");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function _retiraAcentuacao($palavra) {
    $palavra = @ereg_replace("[^a-zA-Z0-9_.]", "", strtr($palavra, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ", "aaaaeeiooouucAAAAEEIOOOUUC_"));

    $palavra = str_replace('_', ' ', $palavra);

    return $palavra;
}

?>
