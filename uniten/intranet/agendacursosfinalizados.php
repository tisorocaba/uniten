<?php
require_once 'util/config.php';
Security::admSecurity();
$cursos = new Curso();
$cursos->alias('c')->order('c.nome ASC')->find();

$obj = new AgendaCurso();

$cpbusca =  !empty($_REQUEST['busca'])? $obj->escape($_REQUEST['busca']): '';

$locais = new Local();
$locais->alias('l')->where('l.ativo=1')->order('l.local ASC')->find();





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
      if((int)$cpbusca>0){
        $where .= ' and a.id = '.$cpbusca;
        $obj->alias('a')
            ->join($cursos, 'INNER', 'c', 'curso', 'id')
            ->where($where)
            ->selectAs()
            ->order('a.id DESC')
            ->find();
    }else{
        $obj->alias('a')
            ->join($cursos, 'INNER', 'c', 'curso', 'id', 'c.nome like ?', $cpbusca)
            ->where($where)
            ->selectAs()
            ->order('a.id DESC')
            ->find();
        
    }
    
}



$total = $obj->count();

$_SESSION['ORIGEM'] = 'agendacursosfinalizados';
if(!empty($_GET['offset'])){
    $_SESSION['OFFSET'] = $_GET['offset'];
}else{
  $_SESSION['OFFSET'] = 0;  
}

$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);

$obj->limit($offset, @$limit)
        ->find();

logDao::gravaLog($user->login, 'agendacursosfinalizados', 'Acessou: agenda de cursos finalizados',$_REQUEST);
?>
<p><span class="titulo">Agenda de Cursos &raquo; Finalizados</span><br>
    <br />
    <a href="principal.php?acao=agendaCursoCadastro"></a>
    <script src="scripts/agendacursosfinalizados.js"></script>
</p>
<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
        <td colspan="10"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
              <td width="17%">Status:
                  <select name="status" onchange="self.location=this.value">
                    <option value="principal.php?acao=agendacursos" >Andamento</option>
                    <option value="principal.php?acao=agendacursosfinalizados" selected="selected">Finalizados</option>
                    <option value="principal.php?acao=agendacursoscancelados">Cancelados</option>
                    <option value="principal.php?acao=agendacursostodos" >Todos</option>
                  </select>
              </td>
              <td width="83%" align="right">
              <table width="100%" border="0">
                <tr>
                  <td width="76%"><a href="xls_agendas.php?status=2&amp;busca=<?php echo @$cpbusca  ?>&amp;local=<?php echo @$_GET['local'] ?>" target="_blank">Exportar</a></td>
                  <td width="24%"><?php if($user->local == 1){ ?>
                    <a href="principal.php?acao=agendaCursoCadastro">AGENDAR NOVO CURSO</a> &nbsp;
                  <?php } ?></td>
                </tr>
              </table></td>
            </tr>
        </table></td>
    </tr>
    <tr class="listaClara">
        <td colspan="10"><table width="100%" border="0">
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
            </table>            <a href="principal.php?acao=agendaCursoCadastro"></a></td>
    </tr>
    <tr class="listaClara">
        <td><strong>Cód.</strong></td>
        <td><strong>Curso finalizados</strong></td>

        <td><strong>Local</strong></td>
        <td><strong> Início</strong></td>
        <td><strong>Término</strong></td>
        <td><strong>Carga Horária</strong></td>
        <td align="center">Resultado Final</td>
        <td align="center">Candidatos</td>
        <?php if($user->local == 1 || $user->local == 31){ ?><td align="center">Pós - Curso<br />
         <font size="-1"> (pesquisados/aprovados)</font> </td><?php } ?>
        <?php if($user->local == 1){ ?><td align="center">Editar</td><?php } ?>
        
    </tr>

<?php
$cont = 0;
while ($obj->fetch()) {

    $aDados = $obj->posCursoCompleto();
    $totalGrade = $obj->gradeHoraria();
   
    $bgPos = '#FFF';
	
	if((int)$aDados['percentual']>70){
	            $img = "poscurso-verde.png";
	}else if((int)$aDados['percentual']===0){
	        $img = "poscurso-vermelho.png";
	}else{
	        $img = "poscurso-amarelo.png";
	}
    

    if ($cont === 0) {
        $linha = "listaClara";
        $cont = 1;
    } else {
        $linha = "listaEscura";
        $cont = 0;
    }
?>


    <tr class="<?php echo $linha ?>" bgcolor="">
        <td width="32"><?php echo $obj->id?></td>
        <td width="345"><?php echo $obj->curso->nome ?></td>
        <td width="243"><?php echo $obj->local->local ?></td>
        <td width="85"><?php echo data_br($obj->dataInicio) ?></td>
        <td width="114"><?php echo data_br($obj->dataTermino) ?></td>
        <td width="88"><?php echo $totalGrade ?> Hora(s)</td>
        <td width="123" align="center">
         <a href="relatorio_final.php?agenda=<?php echo $obj->id ?>" class="cssCandidados" id="<?php echo $obj->id ?>">
           <img src="imagens/icon_relatorio.png" width="20" height="20" border="0" />
        </a>
        </td>
        <td width="97" align="center"><a href="candidatos.php?agenda=<?php echo $obj->id ?>" class="cssCandidados" id="<?php echo $obj->id ?>"><img src="imagens/icon_users.png" width="20" height="20" border="0" /></a></td>
        
         <?php if($user->local == 1 || $user->local == 31){ ?>
         
             
             <td width="147" align="center" >
            
                <table width="77%" border="0">
                 <?php if($totalGrade>10){ ?>
                  <tr>
                    <td width="70%"> <a href="poscurso.php?agenda=<?php echo $obj->id ?>" class="cssCandidados" id="<?php echo $obj->id ?>">
                        (<?php echo $aDados['pesquisado']?>/<?php echo $aDados['aprovados']?>) 
                       </a>
                    </td>
                    <td width="30%">  <img src="imagens/<?php echo $img;?>" width="16" height="16" /></td>
                  </tr>
                  <?php }else{ ?>
                  <tr>
                    <td colspan="2">Não se aplica</td>
                  </tr>
                  <?php } ?>
                </table>
                
                   
                
              
            </td>
        <?php } ?>
        
        
        <?php if($user->local == 1 ){ ?>
        <td width="73" align="center" >
            <a href="principal.php?acao=agendaCursoCadastro&id=<?php echo $obj->id ?>">
            <img src="imagens/icon_editar.gif" width="15" height="15" hspace="5" border="0" /></a>
        </td>
        <?php } ?>
        
        
    </tr>
<?php } ?>


</table>
<p>
<?php
    echo ('Total: '.$total.'&nbsp&nbsp');
    @$paginas = $total / $limit;

    if ($paginas > 1) {
        echo "P&aacute;gina(s)";

        for ($i = 0; $i < $paginas; $i++) {

            $exibir = $i + 1;
            $start = $i * $limit;

            if (marcaPagina(@$_SESSION['OFFSET'], $limit) == $i + 1) {
                printf('&nbsp;[<a href="%s&offset=%d" >%s</a>]', 'principal.php?acao=agendacursosfinalizados&busca=' . @$_GET['busca']."&local=".@$_GET['local'], $start, $exibir);
            } else {
                printf('&nbsp;<a href="%s&offset=%d" >%s</a>', 'principal.php?acao=agendacursosfinalizados&busca=' . @$_GET['busca']."&local=".@$_GET['local'], $start, $exibir);
            }
        }
    }
?>

</p>

<p>&nbsp;</p>