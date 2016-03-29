<?php
 
require_once 'util/config.php';
$local = new Local();
$local->alias('l')->where('l.ativo = 1')->find();

// if (!empty($_REQUEST ['status'])) {
   
    echo '<select name="local" id="cbLocal class="validate[required]" > ';
           echo '<option value="">selecione...</option>';
    while ($local->fetch()) {
        if($local->id==@$_REQUEST['local']){
           echo '<option value="'.$local->id.'" selected>'.$local->local.'</option>';
        }else{
           echo '<option value="'.$local->id.'">'.$local->local.'</option>';
        }
    }
    echo '</select>';
//}else {
  //  echo '<select name="local" id="cbLocal" class="validate[required]" ></select> ';
//}



?>