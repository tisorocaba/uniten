<?php 
require_once 'util/config.php';
Security::admSecurity();


$_SESSION['DATAINICIO'] = Usuario::staticGet(5)->escape(data_us($_REQUEST['data_inicio']));
$_SESSION['DATAFINAL'] = Usuario::staticGet(5)->escape(data_us($_REQUEST['data_fim']));



 $sql = 'select * 
            from loguser 
            where data >= "'.$_SESSION['DATAINICIO'].'00:00'.'"
            and data <= "'.$_SESSION['DATAFINAL'].'23:59'.'"';
               
if(!empty($_REQUEST['usuario'])){
    $sql .= ' and usuario = '.$_REQUEST['usuario'];
}

if(!empty($_REQUEST['acao1'])){
    $sql .= ' and MATCH (acao) AGAINST ("'.$_REQUEST['acao1'].'%")';
}

 $sql .=' order by data desc';
        


  
$rs = Usuario::staticGet(5)->_getConnection()->executeSQL($sql);


$_SESSION['SQL'] =  $sql;

logDao::gravaLog($user->login, 'logsPesquisa', 'Visualizou: resultado da pesquisa de logs', $_REQUEST);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="intranet.css" rel="stylesheet" type="text/css">
<script src="scripts/controleVTPesquisa.js"></script>
      <p><strong class="titulo">Log de Acesso :: Resultado</strong><br>
</p>
      <table width="100%" cellpadding="3" cellspacing="1" class="lista">
        <tr class="listaClara">
          <td colspan="13"><strong>Usuário: </strong> <?php echo Usuario::staticGet('login',(int)$_POST['usuario'])->nome?></td>
        </tr>
        <tr class="listaClara">
          <td colspan="13"><strong>Período: </strong><?php echo $_POST['data_inicio']?> a <?php echo $_POST['data_fim']?></td>
        </tr>
       
        <tr class="listaClara">
          <td width="139"><strong>Data</strong></td>
          <td width="328"><strong>Ação</strong></td>
         
          <td width="413"><strong>Informações</strong></td>
         
          
          <td width="86" align="right"><strong>Login</strong></td>
          
        </tr>
         <?php 
		    $cont  = 0;
			$total = 0;
			
			
		    while($row = mysql_fetch_array($rs)){ 
			 if ($cont === 0) {
                        $linha = "listaClara";
                        $cont = 1;
                    } else {
                        $linha = "listaEscura";
                        $cont = 0;
                    }
					
		
		    
		 ?>
        <tr class="<?php echo $linha?>" style="text-transform:uppercase">
          <td><?php echo data_br($row['data'])?></td>
          <td><?php echo $row['acao']?></td>
          
          <td><?php echo $row['importante']?></td>
         
         
          <td align="right">
		 <?php echo $row['usuario']?></td>
         
        </tr>
       <?php } ?>
       
      </table>
      <p align="center">
        <input type="button" name="enviar" id="enviar2" value="Exportar" onclick="self.location='xls_logs.php'" /> 
        <input type="button" name="enviar2" id="enviar" value="Voltar" onclick="self.location='principal.php?acao=logs'" />
</p>
