<?php
require_once 'util/config.php';
require_once 'empresas/dao/processoDao.php';
Security::admSecurity();

$processoDao = new ProcessoDao();

$empresa = (int)$processoDao->escape($_REQUEST['empresa']);
$status = (int)$processoDao->escape($_REQUEST['status']);



$alunos = $processoDao->alunosProcesso($empresa,$status);

if($status===0){
	$statusTitulo = "Em entrevista";
	$dataTitulo = "Data da  entrevista";
}elseif($status===1){
	$statusTitulo = "Em experiência";
	$dataTitulo = "Data de início da experiência";
}elseif($status===2){
	$statusTitulo = "Efetivado";
	$dataTitulo = "Data da efetivação";
}else{
	$statusTitulo = "Desligado";
	$dataTitulo = "Data do desligamento";
}



$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'uniteempregaProcesso', 'Acessou: Alunos em processo uniteemprega',$_REQUEST,'','Empresa: '.$_REQUEST['empresa'].' Status: '.$statusTitulo);
?>
<link href="intranet.css" rel="stylesheet" type="text/css">
<link href="css/validationEngine.jquery.css" rel="stylesheet" type="text/css">

<script src="js/jquery-1.5.min.js" type="text/javascript"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.limite-char-1.0.js" type="text/javascript"></script>

<table width="95%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">UNITE Emprega  :: Alunos :: <?php echo $statusTitulo;?> </strong></p>
        </td>
    </tr>
    <tr>
        <td>
              <table width="100%" border="0" cellspacing="3" cellpadding="1">
                <tr>
                    <td width="100%"><strong>Empresa: <?php echo UniteEmprega::staticGet($empresa)->fantasia;?></strong></td>
                </tr>
                <tr>
                    <td><hr /></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td align="left"><table width="100%" border="0">
                      <tr>
                        <td width="5%" bgcolor="#CCCCCC" ><strong>Cód.</strong></td>
                        <td width="69%" bgcolor="#CCCCCC" ><strong>Nome</strong></td>
                        <td width="26%" bgcolor="#CCCCCC" align="right"><strong><?php echo $dataTitulo;?></strong></td>
                      </tr>
                      <?php 
                      
                       $cont = 0; 
					   $i=0;
                       foreach ($alunos as $aluno) { 
                          
                            
                           if ($cont === 0) {
                                $linha = "listaClara";
                                $cont = 1;
                            } else {
                                $linha = "listaEscura";
                                $cont = 0;
                            }
 							$i++;
                          ?>
                          
                      
                      <tr class="<?php echo $linha ?>">
                        <td style="text-transform:uppercase" ><?php echo $aluno->cod?></td>
                        <td style="text-transform:uppercase" ><?php echo $aluno->nome?></td>
                        <td align="right"><?php echo data_br($aluno->data) ?></td>
                      </tr>
                      <?php }?>
                  </table></td>
                </tr>
                <tr>
                  <td align="left">Total: <?php echo $i;?></td>
                </tr>
                <tr>
                  <td align="center">&nbsp;
                  <input name="imprimir" value="imprimir" type="button" onclick="print();" /></td>
                </tr>
            </table>
        
        </td>
    </tr>
</table>
