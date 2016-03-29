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
class Emailmanager {

    
    function Emailmanager() {}


    function enviaEmailInscricaoProva($agenda,$aluno){
        
        $html = $this->getHTTP('http://www.sorocaba.sp.gov.br/uniten/intranet/modelo/inscricao-prova.php');
        
        $html = str_replace('{PROTOCOLO}',  $agenda['id'].'-'.$aluno['id'],  $html);
        $html = str_replace('{CANDIDATO}',  $aluno['nome'], $html);
        $html = str_replace('{CURSO}',      $agenda['curso']['nome'], $html);
        $html = str_replace('{DATA}',       $agenda['provaData'], $html);
        $html = str_replace('{LOCAL}',      $agenda['provaLocal'], $html);
        $html = str_replace('{HORARIO}',    $agenda['provaHorario'], $html);
        
      
      
        $this->enviaEmail('uniten@sorocaba.sp.gov.br', $aluno['email'], utf8_decode('Confirmação de Inscrição: '.$agenda['curso']['nome']), utf8_decode($html));

    }


    function enviaContato($formulario){

        $html = '
           <link href="http://www.sorocaba.sp.gov.br/uniten/intranet/intranet.css" rel="stylesheet" type="text/css">
    
           <table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
              <td><img src="http://www.sorocaba.sp.gov.br/uniten/intranet/imagens/logotipo_intranet.gif" width="250" height="80" alt="UNITE"></td>
           </tr>
           <tr>
              <td></td>
           </tr>
           <tr>
              <td>  <p><span class="titulo">Formulário de Contato</span><br />
              <br />
              <br />
              Nome: {NOME}
              ,<br />
              Email: {EMAIL}<br />
              Telefone: {DDD}-{TELEFONE}<br />
              Assunto: {ASSUNTO}<br />
              <br />
              {MENSAGEM},</p>
              <p>DATA: {DATA}<br />
                <br />
               IP: {IP}<br />
              </p></td>
           </tr>
           <tr>
              <td></td>
           </tr>
           </table>';

        $html = str_replace('{NOME}',  $formulario['nome'],  $html);
        $html = str_replace('{EMAIL}',  $formulario['email'], $html);
        $html = str_replace('{TELEFONE}',      $formulario['telefone'], $html);
        $html = str_replace('{DDD}',      $formulario['ddd'], $html);
        $html = str_replace('{ASSUNTO}',      $formulario['assunto'], $html);
        $html = str_replace('{MENSAGEM}',       $formulario['mensagem'], $html);
        $html = str_replace('{DATA}',      date('d-m-Y H:i'), $html);
        $html = str_replace('{IP}',    $_SERVER['REMOTE_ADDR'], $html);

        $email = 'uniten@sorocaba.sp.gov.br';
       
        $ret = $this->enviaEmail($formulario['email'],$email,utf8_decode('Formulário de Contato'), utf8_decode($html));
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


        $ch = curl_init ();
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
    
    
    function getHTTP($url,$param='') {

    $ch = curl_init ();
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

    

}

?>