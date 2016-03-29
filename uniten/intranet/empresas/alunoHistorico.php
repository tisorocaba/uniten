<?php
require_once '../util/config.php';
require_once 'dao/processoDao.php';
Security::uniteempregaSecurity();
$processoDao = new ProcessoDao();
$empresa = unserialize($_SESSION['EMPRESA']);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../intranet.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Histórico do Aluno</strong></p>
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="3" cellpadding="1">
                <?php 
				$i=1;
				foreach ($processoDao->listaProcessos($empresa->id, $processoDao->escape($_REQUEST['cod'])) as $processo) { ?>
                <tr>
                  <td><strong><?php echo $i?>º processo de  seleção  </strong></td>
                </tr>
                <tr>
                        <td><hr></td>
                </tr>
                <tr>
                        <td>
                         
                         
                           <table width="100%" border="0">
                           <?php foreach ($processoDao->listaAlteracaoProcesso($processo->id) as $alteracao) {  ?>
                              <tr>
                                <td width="5%">&nbsp;</td>
                                <td width="5%"><img src="../imagens/icon_seta.png" width="16" height="16" /></td>
                                <td width="16%"><?php echo faseProcesso($alteracao->status_para)?></td>
                                <td width="79%"><?php echo data_br($alteracao->data)?></td>
                              </tr>
                            <?php } ?>
                            </table>

                        </td>
                </tr>
                  
                <tr>
                      <td align="left">&nbsp;</td>
               </tr>
               
               <?php $i++; } ?>
               
                <tr>
                    <td align="center">&nbsp;
                  <input type="button" name="button" id="button" value="imprimir" onclick="print()" />
&nbsp;&nbsp;&nbsp;</td>
                </tr>
            </table>

        </td>
    </tr>
</table>

