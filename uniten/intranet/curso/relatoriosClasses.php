<?php
require_once '../dao/pendenciaDao.php';
Security::cursoSecurity();
$cursos = new Curso();
$cursos->alias('c')->order('c.nome ASC')->find();
Security::cursoSecurity();
$obj = new AgendaCurso();


$locais = new Local();
$locais->alias('l')->where('l.ativo=1 and id in (select local_id from local_curso where empresa_curso_id = ?)',$user->empresa->id)->order('l.local ASC')->find();


$cpbusca = $obj->escape(@$_REQUEST['busca']);



if(!empty($_REQUEST['status'])){
	$status = (int)$_REQUEST['status'];	
	$titulo = "Finalizados";
}else{
   $status = 1;	
   $titulo = "Em andamento";
}




if((int)$user->tipoLogin == 2){
    
    gotox("principal.php?acao=relatoriosClassesProfessor");
    //var_dump($professor->_getLink('agendas'));
    //die;
}

if (empty($cpbusca)&& empty($_REQUEST['local'])) {

    $obj->alias('a')
            ->order('a.id DESC')
            ->where('a.status = '.$status.' and a.empresaCurso=?',$user->empresa->id)
            ->find();
} elseif(!empty($cpbusca)) {
    
    
     if ((int) $cpbusca > 0) {
        $where = 'a.id = ' . $cpbusca.' and a.empresaCurso='.$user->empresa->id;
        $obj->alias('a')
                ->join($cursos, 'INNER', 'c', 'curso', 'id')
                ->where($where)
                ->selectAs()
                ->order('a.id DESC')
                ->find();
    } else {
        $obj->alias('a')
            ->join($cursos, 'INNER', 'c', 'curso', 'id', 'c.nome like ?', $cpbusca)
            ->where('a.status = '.$status.' and a.empresaCurso=?',$user->empresa->id)
            ->selectAs()
            ->order('a.id ASC')
            ->find();
    }
    
} elseif(!empty($_REQUEST['local'])) {
    
    $obj->alias('a')
            ->order('a.id DESC')
            ->where('a.status = ? and a.local = ? and a.empresaCurso=?',$_REQUEST['status'],$_REQUEST['local'],$user->empresa->id)
            ->find();
}


$total = $obj->count();

$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);
$obj->limit($offset, @$limit)
        ->find();

logDao::gravaLog($user->login, 'relatoriosClasses', 'Acessou: lista de relatorios de classe',$_REQUEST,'','Status: '.$titulo);




?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<p><span class="titulo">Relatórios de Classes :: <?php echo $titulo?></span><br>
    <br />
    </p>
<script src="scripts/relatoriosClasses.js"></script>
<table width="100%" cellpadding="3" cellspacing="1" class="lista" >
    <tr class="listaClara">
        <td colspan="13"><table width="100%" border="0">
          <tr>
              <td width="93%">Status:
                <select name="status" id="status" onchange="self.location='principal.php?acao=relatoriosClasses&status='+this.value">
                  <option value="1" <?php if($status===1) { ?>selected="selected" <?php } ?>>Andamento</option>
                  <option value="2" <?php if($status===2) { ?>selected="selected" <?php } ?>>Finalizados</option>
              </select></td>
              <td width="7%">
              <a href="xls_relatorios.php?status=<?php echo $status?>" target="_blank">Exportar</a>
              </td>
          </tr>
        </table></td>
    </tr>
    <tr class="listaClara">
      <td colspan="13"><table width="100%" border="0">
        <tr>
          <td><strong>Pesquisa(Curso/Cód)</strong>:
<input name="busca" id="busca" type="text" value="<?php echo @$_REQUEST['busca']; ?>" />
          <input type="button" name="button" id="btPesquisar" value="Localizar" /></td>
          <td><strong> Local</strong>:
            <select name="local" id="cbLocal" onchange="self.location='principal.php?acao=relatoriosClasses&local='+this.value+'&status='+document.getElementById('status').value" >
              <option value="">Todos</option>
              <?php echo Lumine_Util::buildOptions($locais,'id','local', @$_REQUEST['local']); ?>
          </select></td>
        </tr>
      </table></td>
    </tr>
    <tr class="listaClara">
        <td colspan="13">&nbsp;</td>
    </tr>
    <tr class="listaClara">
        <td><strong>Cód. </strong></td>
        <td><strong>Curso </strong></td>

        <td><strong>Local</strong></td>
        <td><strong>  Início </strong></td>
        <td><strong>Término </strong></td>
        <td><strong>Horário de Aula</strong></td>
        <td align="center">Questionários</td>
        <td align="center">Alunos</td>
        <td width="82" align="center">Diário classe</td>
        <td width="111" align="center">Avaliação Final</td>
    
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
        <td width="36"><?php echo $obj->id ?></td>
        <td width="235"><?php echo $obj->curso->nome ?></td>
        <td width="214"><?php echo $obj->local->local ?></td>
        <td width="84"><?php echo data_br($obj->dataInicio) ?></td>
        <td width="67"><?php echo data_br($obj->dataTermino) ?></td>
        <td width="134"><?php echo $obj->horarioInicial ?> as <?php echo $obj->horarioFinal ?></td>
        <td width="83" align="center"><a href="pesquisaInfra.php?agenda=<?php echo $obj->id ?>" class="cssAlunos" id="">
              <!--  <img src="../imagens/icon_avaliacao_final.png" width="22" height="22" border="0" /> -->
            </a></td>
       
       
        <td width="49" align="center"><a href="alunosMatriculados.php?agenda=<?php echo $obj->id ?>" class="cssAlunos" id="<?php echo $obj->id ?>"><img src="../imagens/icon_alunos.png" width="20" height="20" border="0" /></a></td>
       
        <td align="center">
          <a href="principal.php?acao=diarios&agenda=<?php echo $obj->id ?>"  id="<?php echo $obj->id ?>">
            <img src="../imagens/icon_editar.gif" width="15" height="15" hspace="5" border="0" />
           </a>        </td>
        <td align="center"><a href="alunosAvaliacaoFinal.php?agenda=<?php echo $obj->id ?>" class="cssAlunos" id="<?php echo $obj->id ?>"><img src="../imagens/icon_avaliacao_final.png" width="22" height="22" border="0" /></a></td>
       
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
                printf('[&nbsp;<a href="%s&offset=%d" >%s</a>]', 'principal.php?acao=relatoriosClasses&busca=' . @$_GET['busca'].'&status='.$status.'&local='.@$_GET['local'], $start, $exibir);
            } else {
                printf('&nbsp;<a href="%s&offset=%d" >%s</a>', 'principal.php?acao=relatoriosClasses&busca=' . @$_GET['busca']. '&status='.$status.'&local='.@$_GET['local'], $start, $exibir);
            }
        }
    }
?>

</p>

<p>&nbsp;</p>