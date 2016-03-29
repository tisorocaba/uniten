<?php 
require_once '../util/config.php';
Security::cursoSecurity();
$user = unserialize($_SESSION['USER']);

if(empty($_GET['id']) && (int)$_GET['id']===0){
    gotox("principal.php?acao=diarios");
}
 
if((int)$user->tipoLogin == 2){
         gotox("principal.php?acao=diarioCadastroProfessor&id=".$_GET['id']);
}else{
         gotox("principal.php?acao=diarioCadastro&id=".$_GET['id']);
}