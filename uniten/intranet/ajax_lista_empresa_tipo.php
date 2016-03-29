<?php
 
require_once 'util/config.php';
$empresa = new Empresa();
$empresa->alias('e')->where('e.status = ?',$empresa->escape($_REQUEST['status']))->find();

if (!empty($_REQUEST ['status'])) {
   
    echo '<select name="empresa" id="cbEmpresa" class="validate[required]" > ';
           echo '<option value="">selecione...</option>';
    while ($empresa->fetch()) {
        if($empresa->id==@$_REQUEST['empresa']){
           echo '<option value="'.$empresa->id.'" selected>'.$empresa->nome.'</option>';
        }else{
           echo '<option value="'.$empresa->id.'">'.$empresa->nome.'</option>';
        }
    }
    echo '</select>';
}else {
    echo '<select name="empresa" id="cbEmpresa" class="validate[required]" ></select> ';
}



?>