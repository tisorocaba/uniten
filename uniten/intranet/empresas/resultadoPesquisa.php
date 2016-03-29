<?php
require_once '../util/config.php';
require_once 'dao/cursosDao.php';
require_once 'dao/processoDao.php';
Security::uniteempregaSecurity();
$cursoDao = new cursosDao();
$processoDao = new ProcessoDao();

// salvando os dados da pesquesa

if(!empty($_REQUEST['curso'])){
    
    $_SESSION['PESQUISACURSO']    = $cursoDao->escape($_REQUEST['curso']);
    $_SESSION['PESQUISASEXO']     =  $cursoDao->escape($_REQUEST['sexo']);
    $_SESSION['PESQUISAPERIODO']  =  $cursoDao->escape($_REQUEST['periodo']);
    
}

$total = $cursoDao->totalAlunosCuros($_SESSION['PESQUISACURSO'],$_SESSION['PESQUISASEXO'] ,$_SESSION['PESQUISAPERIODO'] ); 

$offset = (int)@$_REQUEST['offset'];
    



?>
<link href="intranet.css" rel="stylesheet" type="text/css">
<script src="scripts/resultadoPesquisa.js" type="text/javascript"></script>
<p><span class="titulo">Alunos &raquo; Resultado da Pesquisa </span> <br>
    <br />
    Curso: <b><?php echo Curso::staticGet($_SESSION['PESQUISACURSO'])->nome?></b> / Sexo: <b>
    <?php if($_SESSION['PESQUISASEXO']=='M'){echo "MASCULINO";}elseif($_SESSION['PESQUISASEXO']=='F'){echo "FEMININO";}else{ echo "AMBOS";}?>
    </b> / Período: <b>
    <?php if($_SESSION['PESQUISAPERIODO']=='M'){echo "MANHÃ";}elseif($_SESSION['PESQUISAPERIODO']=='T'){echo "TARDE";}elseif($_SESSION['PESQUISAPERIODO']=='N'){ echo "NOITE";}else{echo "QUALQUER";}?>
    </b><br />
  <br />
Resultado da pesquisa: <b><?php echo $total?></b> alunos encontrado </p>
<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
        <td colspan="7">
        </td>
    </tr>
    <tr class="listaClara">
      <td>&nbsp;</td>
        <td><strong>Nome</strong></td>
        <td><strong>Idade</strong></td>
        <td><strong>Email</strong></td>
        <td><strong>Telefone</strong></td>
        <td><strong>Status do aluno</strong></td>
        <td width="146" align="center"><strong>Entrevistar</strong></td>
    </tr>

    <?php
    $cont = 0;
    foreach ($cursoDao->listaAlunosCuros($_SESSION['PESQUISACURSO'],$_SESSION['PESQUISASEXO'] ,$_SESSION['PESQUISAPERIODO'] , $offset) as $aluno) {
        
         

        if ($cont === 0) {
           $linha = "listaClara";
            $cont = 1;
        } else {
            $linha = "listaEscura";
            $cont = 0;
        }
    ?>
    <tr class="<?php echo $linha?>">
      <td width="12" style="text-transform: uppercase">
         <?php if($processoDao->emProcesso($empresa->id,$aluno->id)==''){ ?> 
               <img src="../imagens/icon_star2.png" width="12" height="12" />
             <?php }else{ ?>
               <a href="alunoHistorico.php?cod=<?php echo $aluno->id?>" class="cssHistorico"><img src="../imagens/icon_star1.png" width="12" height="12" border="0" /></a>
            <?php } ?>
        
        
        </td>
        <td width="339" style="text-transform: uppercase">
        <a href="alunoFicha.php?cod=<?php echo $aluno->id?>" class="cssCandidados"><?php echo $aluno->nome?></a></td>
        <td width="74"><?php echo $aluno->idade?> anos</td>
        <td width="178"><?php echo $aluno->email?></td>
        <td width="107"><?php echo $aluno->telefone?></td>
        <td width="89"><?php echo statusAluno($aluno->status)?></td>
        <td align="center">
             <?php if($processoDao->emProcesso($empresa->id,$aluno->id)=='' || $processoDao->emProcesso($empresa->id,$aluno->id)==4){ ?> 
              <a href="principal.php?acao=entrevistaForm&cod=<?php echo $aluno->id?>">
               agendar
              </a>
            <?php }else{ ?>
              agendado
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
<p align="center">
    <input type="submit" name="button" id="button" value="Voltar" onclick="self.location='principal.php'" />
</p>
