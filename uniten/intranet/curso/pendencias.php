<?php
require_once '../dao/pendenciaDao.php';
Security::cursoSecurity();


logDao::gravaLog($user->login, 'pendencias', 'Acessou: lista de pendencias','','','');

$pendenciaDao = new PendenciaDao();
$diarios = $pendenciaDao->agendasSemDiariosPorEmpresa($user->empresa->id);



?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<p><span class="titulo">Pendências</span><br>
    <br />
    </p>
<table width="100%" border="0" cellspacing="3" cellpadding="1">
  <tr class="splicenet">
    <td width="100%"><table width="100%" cellpadding="3" cellspacing="1" class="lista">
      <tr class="listaClara">
        <td width="989"><strong>Diários sem registro de presenças.</strong></td>
      </tr>
      <tr class="listaClara">
        <td>
        
        
        <table width="100%" border="0">
                                                   
          <tr>
            <td width="6%" class="normal"><strong>Código</strong></td>
            <td width="27%" class="normal"><strong>Monitor</strong></td>
            <td width="56%" class="normal"><strong>Curso</strong></td>
            <td width="11%" class="normal"><strong>Data</strong></td>
          </tr>
          <?php
          if($diarios!=null){
              
        
          foreach($diarios as $diario) { ?>
           <tr>
            <td width="6%" class="normal"><?php echo $diario['cod']?></td>
            <td width="27%" class="normal"><?php echo $diario['monitor']?></td>
            <td width="56%" class="normal"><?php echo $diario['curso']?></td>
            <td width="11%" class="normal"><?php echo $diario['data_do_diario']?></td>
          </tr>
         <?php  }
         } ?> 
        </table>
        
        </td>
      </tr>
     
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<script src="scripts/relatoriosClasses.js"></script>
<p>&nbsp;</p>

<p>&nbsp;</p>