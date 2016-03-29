<?php
require_once '../util/config.php';
require_once 'dao/cursosDao.php';
require_once 'dao/processoDao.php';
Security::uniteempregaSecurity();
$cursoDao = new cursosDao();
$processoDao = new ProcessoDao();




if(!empty($_REQUEST['status'])){
	$_SESSION['STATUSENTRE'] = $_REQUEST['status'];
}

    
$total = $cursoDao->totalAlunos($empresa->id,$_SESSION['STATUSENTRE']); 


?>
<link href="intranet.css" rel="stylesheet" type="text/css">
<script src="scripts/processos.js"></script>

<p><span class="titulo">Alunos &raquo; <?php echo faseProcesso($_SESSION['STATUSENTRE']) ?></span>
</p>
<table width="996" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
        <td colspan="7">
        </td>
    </tr>
    <tr class="listaClara">
        <td width="350"><strong>Nome</strong></td>
        <td width="137"><strong>
         <?php if($_SESSION['STATUSENTRE']==1) { ?>
             Data entrevista
         <?php }elseif($_SESSION['STATUSENTRE']==4){ ?>
            Data desligamento
         <?php }else{ ?>
         Data início
         <?php } ?>
         </strong></td>
        <td width="214"><strong>
        <?php if($_SESSION['STATUSENTRE']==1) { ?>
             Horário da entrevista
         <?php }else{ ?>
           Setor
         <?php } ?>
        </strong></td>
       
        <td width="183" align="center">&nbsp;</td>
        <td width="24" align="center">&nbsp;</td>
    </tr>

    <?php
    $cont = 0;
    foreach ($cursoDao->listaAlunos($empresa->id ,$_SESSION['STATUSENTRE'], @$offset) as $aluno) {
		//$statuspro = $processoDao->verificaStatus($aluno->cod,$empresa->id,$_SESSION['STATUSENTRE']);
        if ($cont === 0) {
           $linha = "listaClara";
            $cont = 1;
        } else {
            $linha = "listaEscura";
            $cont = 0;
        }
    ?>
    <tr class="<?php echo $linha?>">
        <td width="350" style="text-transform: uppercase">
        <a href="alunoFicha.php?cod=<?php echo $aluno->cod?>" class="cssCandidados"><?php echo $aluno->nome?></a></td>
        <td width="137"><?php echo data_br($aluno->data)?></td>
        <td width="214">
		 <?php if($_SESSION['STATUSENTRE']==1) { ?>
             <?php echo $aluno->hora?>
         <?php }else{ ?>
           <?php echo $aluno->setor?>
         <?php } ?>
		</td>
       
        <td width="183">
            
         
                 <a href="principal.php?acao=processoCadastro&cod=<?php echo $aluno->id?>">
                   alterar 
                 </a>
          
          
        </td>
        <td width="24">
        <?php if($_SESSION['STATUSENTRE']==1) { ?>
         <a href="processoRemover.php?id=<?php echo $aluno->id?>">
            remover
        </a>
        <?php } ?>
        </td>
    </tr>
    <?php } ?>
</table>

 <?php
    @$paginas = $total / $limit;

    if ($paginas > 1) {
        echo "P&aacute;gina(s)";

        for ($i = 0; $i < $paginas; $i++) {

            $exibir = $i + 1;
            $start = $i * $limit;

            if (marcaPagina(@$_GET['offset'], $limit) == $i + 1) {
                printf('&nbsp[<a href="%s&offset=%d" >%s</a>]', 'principal.php?acao=resultadoPesquisa', $start, $exibir);
            } else {
                printf('&nbsp<a href="%s&offset=%d" >%s</a>', 'principal.php?acao=resultadoPesquisa', $start, $exibir);
            }
        }
    }
?>
  
</p>
<p align="center">&nbsp;</p>
