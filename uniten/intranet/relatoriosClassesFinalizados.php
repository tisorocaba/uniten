<?php
Security::admSecurity();
$cursos = new Curso();
$cursos->alias('c')->order('c.nome ASC')->find();

$locais = new Local();
$locais->alias('l')->where('l.ativo=1')->order('l.local ASC')->find();

$obj = new AgendaCurso();

$cpbusca = $obj->escape(@$_REQUEST['busca']);


// xdebug();

// acoes diferentes por usuario
if($user->local == 1){
	
    if(!empty($_REQUEST['local'])){
        $where = 'a.status = 2 and a.local='.$_REQUEST['local'];
    }else{
        $where = 'a.status = 2';
    }
	
}else{
    $where = 'a.status = 2 and a.local = '.$user->local; 
}

if (empty($cpbusca)) {

    $obj->alias('a')
            ->order('a.id DESC')
            ->where($where)
            ->find();
} else {
   
    
    
     if ((int) $cpbusca > 0) {
        $where .= ' and a.id = ' . $cpbusca;
        $obj->alias('a')
                ->join($cursos, 'INNER', 'c', 'curso', 'id')
                ->where($where)
                ->selectAs()
                ->select('c.nome')
                ->order('a.id DESC')
                ->find();
    } else {
        $obj->alias('a')
                ->join($cursos, 'INNER', 'c', 'curso', 'id', 'c.nome like ?', $cpbusca)
                ->where($where)
                ->selectAs()
                ->order('a.id DESC')
                ->find();
    }
    
}

/* $lista->alias('u')
  ->join($venda,'LEFT','v',null,null,'v.datavenda <= ?', '2008-01-01')
  ->select('u.nome, count(v.codvenda) as total')
  ->find(); */


$total = $obj->count();

$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);
$obj->limit($offset, @$limit)
        ->find();

logDao::gravaLog($user->login, 'relatoriosClasses', 'Acessou: lista de relatorios finalizados',$_REQUEST);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<p><span class="titulo">Relatórios de Classes &raquo; Finalizados </span><br>
    <br />
    </p>

<script src="scripts/relatoriosClassesFinalizados.js"></script>
<table width="100%" cellpadding="3" cellspacing="1" class="lista" >
    <tr class="listaClara">
        <td colspan="12"><table width="100%" border="0">
          <tr>
              <td>Status:
                <select name="status" onchange="self.location=this.value">
                  <option value="principal.php?acao=relatoriosClasses" >Andamento</option>
                  <option value="principal.php?acao=relatoriosClassesFinalizados" selected="selected">Finalizados</option>
                  <option value="principal.php?acao=relatoriosClassesTodos">Todos</option>
              </select></td>
              <td><a href="xls_relatorios_agendas.php?status=2&amp;busca=<?php echo @$cpbusca  ?>&amp;local=<?php echo @$_GET['local'] ?>" target="_blank">Exportar</a><a href=".php"></a></td>
            </tr>
        </table></td>
    </tr>
    <tr class="listaClara">
        <td colspan="12">
             
               <table width="100%" border="0">
                 <tr>
                   <td width="20%"><strong>Filtro  por nome</strong>:</td>
                   <td width="80%"><input name="busca" id="busca" type="text" value="<?php echo @$_REQUEST['busca']; ?>" />
                     <input type="submit" name="btPesquisar" id="btPesquisar" value="Localizar" /></td>
                 </tr>
                 <tr>
                   <td><strong>Filtro por local</strong>:</td>
                   <td><?php if($user->local == 1){ ?>
                     <select name="local" id="cbLocal" >
                       <option value="">Selecione...</option>
                       <?php echo Lumine_Util::buildOptions($locais,'id','local', @$_REQUEST['local']); ?>
                     </select>
                     <?php } ?></td>
                 </tr>
        </table></td>
    </tr>
    <tr class="listaClara">
         <td><strong>Cód. </strong></td>
        <td><strong>Curso </strong></td>

        <td><strong>Local</strong></td>
        <td><strong>Início</strong></td>
         <td><strong>Término</strong></td>
        <td><strong>Período</strong></td>
        <td align="center">Questionários</td>
        <td align="center">Rel. Final</td>
      
        <td align="center">Alunos</td>
       <!--  <td align="center">Ativo</td> -->
        <td width="85" align="center">Diários</td>
        <td width="94" align="center">Av. Final</td>
        <td width="90" align="center">Desistência</td>
        
    </tr>

<?php
$cont = 0;
while ($obj->fetch()) {


    if ($cont === 0) {
        $linha = "listaClara";
        $cont = 1;
    } else {
        $linha = "listaEscura";
        $cont = 0;
    }
?>


    <tr class="<?php echo $linha ?>">
        <td width="35"><?php echo $obj->id ?></td>
        <td width="238"><?php echo $obj->curso->nome ?></td>
        <td width="209"><?php echo $obj->local->local ?></td>
        <td width="147"><?php echo data_br($obj->dataInicio) ?></td>
          <td width="145"><?php echo data_br($obj->dataTermino) ?></td>
        <td width="145"><?php echo periodoCurso($obj->periodo) ?></td>
        <td width="143" align="center"><a href="curso/pesquisaInfra.php?agenda=<?php echo $obj->id ?>" class="cssAlunos" id=""> Alunos</a> &nbsp; | &nbsp; <a href="curso/pesquisaProfessorCadastro.php?agenda=<?php echo $obj->id  ?>" class="cssAlunos" id="<?php echo $obj->id ?>"> Monitor</a></td>
        <td width="78" align="center">
        <a href="relatorio_final.php?agenda=<?php echo $obj->id ?>" class="cssAlunos" id="<?php echo $obj->id ?>">
           <img src="imagens/icon_relatorio.png" width="20" height="20" border="0" />
        </a>
        </td>
       
        <td width="55" align="center">
            <a href="alunosMatriculados.php?agenda=<?php echo $obj->id ?>" class="cssAlunos" id="<?php echo $obj->id ?>">
            <img src="imagens/icon_alunos.png" width="20" height="20" border="0" />
            </a>
        </td>
       
        <td align="center">
          <a href="diarios.php?agenda=<?php echo $obj->id ?>" class="cssAlunos" id="<?php echo $obj->id ?>">
            <img src="imagens/icon_diario.png" width="20" height="20" hspace="5" border="0" />
           </a>
        </td>
        <td align="center">
              <a href="alunosAvaliacaoFinal.php?agenda=<?php echo $obj->id ?>" class="cssAlunos" id="<?php echo $obj->id ?>">
                <img src="imagens/icon_avaliacao_final.png" width="22" height="22" border="0" />
              </a>
         </td>
        <td align="center">
            <a href="alunosDesistentes.php?agenda=<?php echo $obj->id ?>" class="cssAlunos" id="<?php echo $obj->id ?>3">Informar</a>
        </td>
       
    </tr>
<?php } ?>


</table>
<p>
<?php
    @$paginas = $total / $limit;

    if ($paginas > 1) {
        echo "P&aacute;gina(s)";

        for ($i = 0; $i < $paginas; $i++) {

            $exibir = $i + 1;
            $start = $i * $limit;

            if (marcaPagina(@$_GET['offset'], $limit) == $i + 1) {
                printf('[&nbsp<a href="%s&offset=%d" >%s</a>]', 'principal.php?acao=relatoriosClassesFinalizados&busca=' . @$_GET['busca']."&local=".@$_GET['local'], $start, $exibir);
            } else {
                printf('&nbsp<a href="%s&offset=%d" >%s</a>', 'principal.php?acao=relatoriosClassesFinalizados&busca=' . @$_GET['busca']."&local=".@$_GET['local'], $start, $exibir);
            }
        }
    }
?>

</p>

<p>&nbsp;</p>