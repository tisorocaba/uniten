<?php
require_once 'util/config.php';
Security::admSecurity();

if(!empty($_GET['cod']))
{
   $obj = new Desistencia();
   $obj->get($obj->escape($_GET['cod']));
   
   
   
}else{
  die('ERRO');
}
$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->id, 'disistenciaDetalhe', 'visualizar',$_REQUEST);
unset($user);

?>
<p><span class="titulo">Aluno  &raquo; Historico &raquo;  Desistência</span><br> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="intranet.css" rel="stylesheet" type="text/css">
</p>


<table width="100%" cellpadding="3" cellspacing="1">
        <tr>
          <td width="8%" valign="top"><strong> Curso:</strong></td>
          <td width="92%" align="left">
          
            <?php echo AgendaCurso::staticGet($obj->agenda)->curso->nome?>
          </td>
  </tr>
        <tr>
          <td valign="top"><strong> Aluno:</strong></td>
          <td align="left">
         
             <?php echo Aluno::staticGet($obj->aluno)->nome?>
          </td>
        </tr>
       
        <tr>
          <td valign="top"><strong>Motivo:</strong></td>
          <td style="text-transform:uppercase">
              <?php echo DesistenciaMotivo::staticGet($obj->motivo)->nome?>
           </td>
        </tr>
        <?php if(!empty($obj->descricao)){ ?>
        <tr>
          <td valign="top"><strong>Obs:</strong></td>
          <td>
              <?php echo $obj->descricao?>
          </td>
        </tr>
        <?php } ?>
        
       <tr>
         <td colspan="2" align="center">
             <input type="button" name="button" id="button" value="voltar" onclick="history.go(-1)" />
          </td>
  </tr>
</table>
<br />


