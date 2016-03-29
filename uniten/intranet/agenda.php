<?php
require_once 'util/config.php';
Security::admSecurity();

if(!empty($_GET['cod']))
{
   $obj = new AgendaCurso();
   $obj->get($obj->escape($_GET['cod']));
   
   
   
   
   
   /*
   $obj->dataInicio = data_br($_POST['dataInicio'])
   
   $_POST = $obj->toArray();

   $_POST['dataInicio'] = data_br($_POST['dataInicio']);
   $_POST['dataTermino'] = data_br($_POST['dataTermino']);
   $_POST['dataInicioInscricao'] = data_br($_POST['dataInicioInscricao']);
   $_POST['dataFinalInscricao'] = data_br($_POST['dataFinalInscricao']);
   
   if(!empty($_POST['provaData'])){
	    $_POST['provaData'] = data_br($_POST['provaData']);
   }

   $_POST['valor'] = converteFloatMoeda($_POST['valor']);
   $_POST['valorVale'] = converteFloatMoeda($_POST['valorVale']);
  */
   
   
}else{
  die('ERRO');
}
$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->id, 'agenda', '',$_REQUEST);
unset($user);

?>
<p><span class="titulo">Agenda de Cursos  &raquo; Curso</span><br> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="intranet.css" rel="stylesheet" type="text/css">
</p>

<form name="form1" id="form1" method="post" action="agendaCursoLogic.php">
<input type="hidden" name="id" value="<?php echo @$_POST['id']?>"  />
<table width="100%" cellpadding="3" cellspacing="1">
        <tr>
          <td width="19%" valign="top"><strong> Curso:</strong></td>
          <td width="81%" align="left">
          
            <?php echo $obj->curso->nome?>
           </td>
        </tr>
        <tr>
          <td valign="top"><strong> Local:</strong></td>
          <td align="left">
         
             <?php echo $obj->local->local?>
           </td>
        </tr>
       
        <tr>
          <td valign="top"><strong>Data de início:</strong></td>
          <td>
              <?php echo data_br($obj->dataInicio)?>
           </td>
        </tr>
        <tr>
          <td valign="top"><strong>Data de término:</strong></td>
          <td>
              <?php echo data_br($obj->dataTermino)?>
          </td>
        </tr>
        <tr>
          <td valign="top"><strong>Horário de início:</strong></td>
          <td>
              <?php echo $obj->horarioInicial; ?>
          </td>
        </tr>
        <tr>
          <td valign="top"><strong>Horário de término:</strong></td>
          <td>
              <?php echo $obj->horarioFinal; ?>
          </td>
        </tr>
        <tr>
          <td valign="top"><strong>Quantidade de vagas:</strong></td>
          <td>
              <?php echo $obj->vagas; ?>
          </td>
        </tr>
        <tr>
          <td valign="top"><strong>Aplicar prova:</strong></td>
          <td>
             <?php 
                  if($obj->prova==1) echo "Sim"; else echo "Não";
             ?>
          </td>
        </tr>
        <?php if($obj->prova==1) { ?>
         <tr>
          <td colspan="2">
          
          		<table width="1056">
                   <tr >
                  <td width="214" valign="top"><strong>Local da prova: </strong></td>
                  <td width="830" align="left">
                      <?php echo $obj->provaLocal; ?>
                    </td>
                </tr>
                <tr >
                  <td valign="top"><strong>Data da prova:</strong></td>
                  <td align="left">
                     <?php echo data_br($obj->provaData); ?>
                  </td>
                </tr>
                <tr >
                  <td valign="top"><strong>Horário da prova:</strong></td>
                  <td align="left">
                      <?php echo $obj->provaHorario; ?>
                 </td>
                </tr>
               </table>
          
          </td>
         
        </tr>
        <?php } ?>
       

        <tr>
          <td valign="top"><strong>Permite inscrição pela web:</strong></td>
          <td>
              <?php if($obj->inscricaoweb==1 || empty ($obj->inscricaoweb)) echo "Sim"; else 'Não' ?>
         </td>
        </tr>
       
       
        <tr>
          <td valign="top"><strong>Observação:</strong></td>
          <td><?php echo $obj->obs?></td>
        </tr>
        
       
      </table>
<br />
<input type="button" name="button" id="button" value="voltar" onclick="history.go(-1)" />
</form>
