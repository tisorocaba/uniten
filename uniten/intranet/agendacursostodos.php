<?php
require_once 'util/config.php';
Security::admSecurity();

$cursos = new Curso();
$cursos->alias('c')->order('c.nome ASC')->find();

$obj = new AgendaCurso();
$cpbusca = $obj->escape(@$_REQUEST['busca']);

$locais = new Local();
$locais->alias('l')->where('l.ativo=1')->order('l.local ASC')->find();




// acoes diferentes por usuario
if($user->local == 1){
    if(!empty($_REQUEST['local'])){
       
        $_SESSION['LOCAL'] = $_REQUEST['local'];
        unset($_SESSION['BUSCA']);
        
        $where = 'a.status > 0 and a.local='.$_REQUEST['local'];
    }else{
        $where = 'a.status > 0';
    }
    
}else{
    $where = 'a.status > 1 and a.local = '.$user->local; 
}



if (empty($cpbusca)) {

    $obj->alias('a')
            ->order('a.id DESC')
            ->where($where)
            ->find();
} else {
    $_SESSION['BUSCA'] = $cpbusca;
    unset($_SESSION['LOCAL']);
    if ((int) $cpbusca > 0) {
        $where .= ' and a.id = ' . $cpbusca;
        $obj->alias('a')
                ->join($cursos, 'INNER', 'c', 'curso', 'id')
                ->where($where)
                ->selectAs()
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





$total = $obj->count();


$_SESSION['ORIGEM'] = 'agendacursostodos';
if(!empty($_GET['offset'])){
    $_SESSION['OFFSET'] = $_GET['offset'];
}else{
  $_SESSION['OFFSET'] = 0;  
}

$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);


$obj->limit($offset, @$limit)
        ->find();
logDao::gravaLog($user->login, 'agendacursostodos', 'Acessou: agenda de cursos todos',$_REQUEST);

$_SESSION['SQL'] = $obj->_getSQL();

?>
<p><span class="titulo">Agenda de Cursos &raquo;  Todos </span> <br>
    
<a href="principal.php?acao=agendaCursoCadastro"></a></p>

<script src="scripts/agendacursostodos.js"></script>
<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
        <td colspan="13"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
              <td width="17%">
              Status:<select name="status" onchange="self.location=this.value">
                <option value="principal.php?acao=agendacursos" >Andamento</option>
                <option value="principal.php?acao=agendacursosfinalizados">Finalizados</option>
                <option value="principal.php?acao=agendacursoscancelados">Cancelados</option>
                <option value="principal.php?acao=agendacursostodos" selected="selected">Todos</option>
               </select>
             
            </td>
              <td width="45%"><a href="xls_agendas.php?status=0&amp;busca=<?php echo @$cpbusca  ?>&amp;local=<?php echo @$_GET['local'] ?>" target="_blank">Exportar</a><a href="xls_relatorios.php"></a></td>
              <td width="38%" align="right">
               <?php if($user->local == 1){ ?>
                 <a href="principal.php?acao=agendaCursoCadastro">AGENDAR NOVO CURSO</a>
              <?php } ?>
              </td>
          </tr>
        </table></td>
    </tr>
    <tr class="listaClara">
        <td colspan="13"><table width="100%" border="0">
          <tr>
                <td width="20%"><strong>Filtro  por nome</strong>:</td>
                <td width="80%"><input name="busca" id="busca" type="text" value="<?php echo @$_REQUEST['busca']; ?>" />
                <input type="submit" name="button" id="btPesquisar" value="Localizar" /></td>
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
              </tr>
            </table></td>
    </tr>
    <tr class="listaClara">
        <td><strong>Cód.</strong></td>
        <td><strong>Curso em andamento</strong></td>

        <td><strong>Local</strong></td>
        <td><strong>Período</strong></td>
        <td><strong>Início</strong></td>
        <td><strong>Término</strong></td>
        <td align="center">Candidatos</td>
        <?php if($user->local == 1){ ?> <td align="center"><p>Resultado</p></td><?php }?>
        <?php if($user->local == 1){ ?><td align="center">Monitores</td><?php }?>
        <?php if($user->local == 1){ ?><td align="center">Diários</td><?php }?>
        <?php if($user->local == 1){ ?><td align="center">Ativo</td><?php }?>
        
        <?php if($user->local == 1){ ?><td align="center">Editar</td><?php }?>
        <td width="102" align="center">Apagar</td>
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
        <td width="31"><?php echo $obj->id?></td>
        <td width="222"><?php echo $obj->curso->nome ?></td>
        <td width="257"><?php echo $obj->local->local ?></td>
        <td width="51"><?php echo periodoCurso($obj->periodo) ?></td>
        <td width="67"><?php echo data_br($obj->dataInicio) ?></td>
        <td width="56"><?php echo data_br($obj->dataTermino) ?></td>
        <td width="81" align="center"><a href="candidatos.php?agenda=<?php echo $obj->id ?>" class="cssCandidados" id="<?php echo $obj->id ?>"><img src="imagens/icon_users.png" width="20" height="20" border="0" /></a></td>
        
        <?php if($user->local == 1){ ?>
          <td width="60" align="center">
              <?php if ($obj->resultado == 1) { ?>
                   <a href="javascript:;" id="0|<?php echo $obj->id ?>" class="resultado"> <img src="imagens/icon_publicado_on.gif" width="16" height="16" hspace="5" border="0" alt="publicado" title="publicado"/></a>
              <?php } else { ?>
                    <a href="javascript:;" id="1|<?php echo $obj->id ?>" class="resultado"> <img src="imagens/icon_publicado_off.png" width="16" height="16" hspace="5" border="0" alt="Não publicado"  title="Não publicado"/></a>
              <?php } ?>
          </td>
        <?php } ?>
        
        
             <?php if($user->local == 1){ ?>
                 <td width="119" align="center">
                     <a href="agendamonitores.php?agenda=<?php echo $obj->id ?>" class="cssMonitores" id="<?php echo $obj->id ?>">
                       <img src="imagens/icon_professor.png" alt="Monitores" width="20" height="20" border="0" />
                    </a>(<?php echo $obj->totalMonitores()?>)
                </td>
                 <td width="82" align="center"><a href="gradeAgenda.php?agenda=<?php echo $obj->id ?>" class="cssDiarios" id="<?php echo $obj->id ?>2">
                         <img src="imagens/icon_diario.png" alt="" width="20" height="20" hspace="5" border="0" /></a>(<?php echo $obj->totalAulas();?>)</td>
            <?php } ?>
        
        
         <?php if($user->local == 1){ ?>
                <td width="88" align="center">
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
               <td width="89" align="center">
                <a href="principal.php?acao=agendaCursoCadastro&id=<?php echo $obj->id ?>">
                    <img src="imagens/icon_editar.gif" width="15" height="15" hspace="5" border="0" />
                </a>
              </td>
           <?php } ?>
        
       
        
            <?php if($user->local == 1){ ?>
              <td width="102" align="center">
                    <a href="javascript:;" id="<?php echo $obj->id ?>" class="logout"><img src="imagens/icon_delete.gif" alt="" width="15" height="15" hspace="5" border="0" align="absmiddle" /></a>
            </td>
           <?php }?>
         <td width="14" align="center"></td>
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
  
  echo ('Total: '.$total.'&nbsp&nbsp');
  
    @$paginas = $total / $limit;

    if ($paginas > 1) {
        echo "P&aacute;gina(s)";

        for ($i = 0; $i < $paginas; $i++) {

            $exibir = $i + 1;
            $start = $i * $limit;

            if (marcaPagina(@$_GET['offset'], $limit) == $i + 1) {
                printf('&nbsp;[<a href="%s&offset=%d" >%s</a>]', 'principal.php?acao=agendacursostodos&busca=' . @$_GET['busca']."&local=".@$_GET['local'], $start, $exibir);
            } else {
                printf('&nbsp;<a href="%s&offset=%d" >%s</a>', 'principal.php?acao=agendacursostodos&busca=' . @$_GET['busca']."&local=".@$_GET['local'], $start, $exibir);
            }
        }
    }
?>
  
</p>

<p>&nbsp;</p>