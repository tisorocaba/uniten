<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of logDao
 *
 * @author rogerio
 */

//require_once 'C:/xampp/htdocs/uniten/intranet/util/conn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/uniten/intranet/util/conn.php';
class logDao {

    public static function gravaLog($usuario,$pagina,$acao='',$request='',$erro='',$importante=''){
        
        
        $conn = new Mysql();
        if($request!=''){
            unset($request['__utma']);
            unset($request['__utmz']);
            unset($request['ci_session']);
            unset($request['PHPSESSID']);
            unset($request['disciplinas']);
            unset($request['menu']);
            $requestString = $conn->escape( @implode('|',$request));
           
            
            
        }else{
            $requestString='';
        }
        
        $sql = 'insert into loguser(usuario,pagina,acao,ip,dados,php_error,importante) values("'.$usuario.'","'.$pagina.'","'.$acao.'","'.$_SERVER['REMOTE_ADDR'].'","'.$requestString.'","'.$erro.'","'.$importante.'")';
    
        $conn->query($sql);
   }






    //put your code here
}
?>
