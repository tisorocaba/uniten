<?php
require_once 'util/config.php';
Security::admSecurity();

$cursos = new Curso();
$cursos->alias('c')->order('c.nome ASC')->find();

$obj = new AgendaCurso();
$cpbusca = $obj->escape(@$_REQUEST['busca']);

$locais = new Local();
$locais->alias('l')->where('l.ativo=1')->order('l.local ASC')->find();
$user = unserialize($_SESSION['USER']);

// acoes diferentes por usuario
if($user->local == 1){
    if(!empty($_REQUEST['local'])){
        $where = 'a.status = 1 and a.local='.$_REQUEST['local'];
    }else{
        $where = 'a.status = 1';
    }
    
}else{
    $where = 'a.status = 1 and a.local = '.$user->local; 
}



if (empty($cpbusca)) {

    $obj->alias('a')
            ->order('a.id DESC')
            ->where($where)
            ->find();
} else {
    $obj->alias('a')
            ->join($cursos, 'INNER', 'c', 'curso', 'id', 'c.nome like ?', $cpbusca)
            ->where($where)
            ->selectAs()
            ->order('a.id DESC')
            ->find();
}




$total = $obj->count();

$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);
$obj->limit($offset, @$limit)
        ->find();
logDao::gravaLog($user->id, 'agendacursos', 'lista_de_agendacursos');
?>



			
            
            
            <table width="100%" cellpadding="3" cellspacing="1" class="lista">
            <legend ><strong>EM ANDAMENTO</strong></legend>
    <tr class="listaClara">
        <td colspan="13"><table width="100%" border="0">
          <tr>
                <td width="11%"><strong>Filtro  por nome</strong>:</td>
                <td width="66%"><input name="busca" id="busca" type="text" value="<?php echo @$_REQUEST['busca']; ?>" />
                <input type="submit" name="button" id="btPesquisar" value="Localizar" /></td>
                <td width="23%">&nbsp;</td>
              </tr>
              <tr>
                <td><strong>Filtro por local</strong>:</td>
                <td>
                <?php if($user->local == 1){ ?>
                 <select name="local" id="cbLocal" >
                     <option value="">Selecione...</option>
					<?php echo Lumine_Util::buildOptions($locais,'id','local', @$_REQUEST['local']); ?>
                 </select>
                <?php } ?>
                </td>
                <td><?php if($user->local == 1){ ?>
                  <a href="principal.php?acao=agendaCursoCadastro">AGENDAR NOVO CURSO</a>
                <?php } ?></td>
              </tr>
            </table></td>
    </tr>
    <tr class="listaClara">
        <td><strong>Curso em andamento</strong></td>

        <td><strong>Local </strong></td>
        <td><strong>Período</strong></td>
        <td><strong>Início</strong></td>
        <td><strong>Término</strong></td>
        <td align="center">Candidatos</td>
        <?php if($user->local == 1){ ?> <td align="center"><p>Resultado</p></td><?php }?>
        <?php if($user->local == 1){ ?><td align="center">Monitores</td>
        <td align="center">Diários</td>
        <?php }?>
        <?php if($user->local == 1){ ?><td align="center">Ativo</td><?php }?>
        <?php if($user->local == 1){ ?><td align="center">Editar</td><?php }?>
        
        <?php if($user->local == 1){ ?><td align="center">Apagar</td><?php }?>
        <td width="1" align="center"></td>
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
        <td width="224"><?php echo $obj->curso->nome ?></td>
        <td width="200"><?php echo $obj->local->local ?></td>
        <td width="70"><?php echo periodoCurso($obj->periodo) ?></td>
        <td width="68"><?php echo data_br($obj->dataInicio) ?></td>
        <td width="63"><?php echo data_br($obj->dataTermino) ?></td>
        <td width="69" align="center"><a href="candidatos.php?agenda=<?php echo $obj->id ?>" class="cssCandidados" id="<?php echo $obj->id ?>"><img src="imagens/icon_users.png" width="20" height="20" border="0" /></a></td>
        
        <?php if($user->local == 1){ ?>
          <td width="63" align="center">
              <?php if ($obj->resultado == 1) { ?>
                   <a href="javascript:;" id="0|<?php echo $obj->id ?>" class="resultado"> <img src="imagens/icon_publicado_on.gif" width="16" height="16" hspace="5" border="0" alt="publicado" title="publicado"/></a>
              <?php } else { ?>
                    <a href="javascript:;" id="1|<?php echo $obj->id ?>" class="resultado"> <img src="imagens/icon_publicado_off.png" width="16" height="16" hspace="5" border="0" alt="Não publicado"  title="Não publicado"/></a>
              <?php } ?>
          </td>
        <?php } ?>
        
        
             <?php if($user->local == 1){ ?>
                 <td width="62" align="center">
                    <a href="agendamonitores.php?agenda=<?php echo $obj->id ?>" class="cssMonitores" id="<?php echo $obj->id ?>">
                       <img src="imagens/icon_professor.png" alt="Monitores" width="20" height="20" border="0" />
                   </a>
                </td>
                 <td width="62" align="center"><a href="diarios.php?agenda=<?php echo $obj->id ?>" class="cssAlunos" id="<?php echo $obj->id ?>2"><img src="imagens/icon_diario.png" width="20" height="20" hspace="5" border="0" /></a></td>
            <?php } ?>
        
        
         <?php if($user->local == 1){ ?>
                <td width="58" align="center">
                        <?php if ($obj->ativo == 1) {?>
                          <a href="javascript:;" id="0|<?php echo $obj->id ?>" class="ativacao">
                            <img src="imagens/icon_power_on.png" width="16" height="16" hspace="5" border="0" /></a>
                        <?php } else { ?>
                          <a href="javascript:;" id="1|<?php echo $obj->id ?>" class="ativacao">
                            <img src="imagens/icon_power_off.png" width="16" height="16" hspace="5" border="0" /></a>
                        <?php } ?>
                </td>
        <?php } ?>
        
        
            <?php if($user->local == 1){ ?>
               <td width="41" align="center">
                <a href="principal.php?acao=agendaCursoCadastro&id=<?php echo $obj->id ?>">
                    <img src="imagens/icon_editar.gif" width="15" height="15" hspace="5" border="0" />
                </a>
              </td>
           <?php } ?>
        
       
        
            <?php if($user->local == 1){ ?>
              <td width="54" align="center">
                    <a href="javascript:;" id="<?php echo $obj->id ?>" class="logout"><img src="imagens/icon_delete.gif" alt="" width="15" height="15" hspace="5" border="0" align="absmiddle" /></a>
            </td>
           <?php }?>
         <td align="center"></td>
    </tr>
<?php } ?>


</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><a href="legendas/agendacursos.php" class="cssLegenda" title="Legenda">Ver a legenda</a></td>
  </tr>
</table>
<br />
<p>
  <?php
    @$paginas = $total / $limit;

    if ($paginas > 1) {
        echo "P&aacute;gina(s)";

        for ($i = 0; $i < $paginas; $i++) {

            $exibir = $i + 1;
            $start = $i * $limit;

            if (marcaPagina(@$_GET['offset'], $limit) == $i + 1) {
                printf('&nbsp;[<a href="%s&offset=%d" class="pagination" >%s</a>]', 'agendasAndamento.php?busca=' . @$_GET['busca']."&local=".@$_GET['local'], $start, $exibir);
            } else {
                printf('&nbsp;<a href="%s&offset=%d" class="pagination" >%s</a>', 'agendasAndamento.php?busca=' . @$_GET['busca']."&local=".@$_GET['local'], $start, $exibir);
            }
        }
    }
?>
            
            
            
            
            
            
		</p>
