<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of security
 *
 * @author rogerio
 */
class Security {
    //put your code here

    public static function admSecurity(){
        if(empty($_SESSION['USER'])){
            die('<script>
                     alert("Sua sessão expirou, faça login novamente!");
                     window.parent.location="index.php";
                 </script>');
        }  else {
            $userTemp = unserialize($_SESSION['USER']);
            $status = $userTemp->empresa->status;
            unset($userTemp);
            if($status<>3){
                die('<script>
                       alert("Acesso negado!");
                       window.parent.location="index.php";
                   </script>');
            }
        }
    }
    
    public static function cursoSecurity(){
        if(empty($_SESSION['USER'])){
            die('<script>
                     alert("Sua sessão expirou, faça login novamente!");
                     window.parent.location="../index.php";
                 </script>');
        }  else {
            $userTemp = unserialize($_SESSION['USER']);
            $status = $userTemp->empresa->status;
            
           
            unset($userTemp);
            if($status<>'2'){
                die('<script>
                       alert("Acesso negado!");
                       window.parent.location="index.php";
                   </script>');
            }
        }
    }
    
    public static function provaSecurity(){
        if(empty($_SESSION['USER'])){
            die('<script>
                     alert("Sua sessão expirou, faça login novamente!");
                     window.parent.location="index.php";
                 </script>');
        }  else {
            $userTemp = unserialize($_SESSION['USER']);
            $status = $userTemp->empresa->status;
            unset($userTemp);
            if($status<>1){
                die('<script>
                       alert("Acesso negado!");
                       window.parent.location="index.php";
                   </script>');
            }
        }
    }

     public static function uniteempregaSecurity(){
        if(empty($_SESSION['EMPRESA'])){
            die('<script>
                     alert("Sua sessão expirou, faça login novamente!");
                     window.parent.location="index.php";
                 </script>');
        } 
    }
    
     public static function admEcurso(){
         if(empty($_SESSION['USER'])){
            die('<script>
                     alert("Sua sessão expirou, faça login novamente!");
                     window.parent.location="index.php";
                 </script>');
        }
    }
}
?>
