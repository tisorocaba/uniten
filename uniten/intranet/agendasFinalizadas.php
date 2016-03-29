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
     if(isset($_REQUEST['local'])){
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
    $obj->alias('a')
            ->join($cursos, 'INNER', 'c', 'curso', 'id', 'c.nome like ?', $cpbusca)
            ->where($where)
            ->selectAs()
            ->order('a.id ASC')
            ->find();
}




$total = $obj->count();

$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);
$obj->limit($offset, @$limit)
        ->find();
logDao::gravaLog($user->id, 'agendacursosfinalizados', 'lista_de_agendafinalizadas');
?>
<br>

<script src="scripts/agendacursos.js"></script>
<table width="100%" cellpadding="3" cellspacing="1" class="lista">
   <legend>AGENDAS FINALIZADAS</legend>
    <tr class="listaClara">
        <td colspan="9"><table width="100%" border="0">
          <tr>
            <td>&nbsp;</td>
            <td><span class="titulo"></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
                <td width="11%"><strong>Filtro  por nome</strong>:</td>
                <td width="71%"><input name="busca2" id="busca2" type="text" value="<?php echo @$_REQUEST['busca']; ?>" />
                  <input type="submit" name="btPesquisar" id="btPesquisar2" value="Localizar" /></td>
                <td width="18%">&nbsp;</td>
              </tr>
              <tr>
                <td><strong>Filtro por local</strong>:</td>
                <td><?php if($user->local == 1){ ?>
                  <select name="local" id="cbLocal" >
                    <option value="">Selecione...</option>
                    <?php echo Lumine_Util::buildOptions($locais,'id','local', @$_REQUEST['local']); ?>
                  </select>
                  <?php } ?></td>
                <td><?php if($user->local == 1){ ?>
                  <a href="principal.php?acao=agendaCursoCadastro">AGENDAR NOVO CURSO</a> &nbsp;
                <?php } ?></td>
              </tr>
            </table>            </td>
    </tr>
    <tr class="listaClara">
      <td colspan="8">
      <hr />
      </td>
    </tr>
    <tr class="listaClara">
        <td><strong>Curso finalizados</strong></td>

        <td><strong>Local</strong></td>
        <td><strong> Início</strong></td>
        <td><strong>Término</strong></td>
        <td align="center">Relatório Final</td>
        <td align="center">Candidatos</td>
        <?php if($user->local == 1){ ?><td align="center">Pós - Curso</td><?php } ?>
        <?php if($user->local == 1){ ?><td align="center">Editar</td><?php } ?>
        
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
        <td width="330"><?php echo $obj->curso->nome ?></td>
        <td width="232"><?php echo $obj->local->local ?></td>
        <td width="81"><?php echo data_br($obj->dataInicio) ?></td>
        <td width="109"><?php echo data_br($obj->dataTermino) ?></td>
        <td width="93" align="center">
         <a href="relatorio_final.php?agenda=<?php echo $obj->id ?>" class="cssCandidados" id="<?php echo $obj->id ?>">
           <img src="imagens/icon_relatorio.png" width="20" height="20" border="0" />
        </a>
        </td>
        <td width="93" align="center"><a href="candidatos.php?agenda=<?php echo $obj->id ?>" class="cssCandidados" id="<?php echo $obj->id ?>"><img src="imagens/icon_users.png" width="20" height="20" border="0" /></a></td>
        
         <?php if($user->local == 1){ ?>
             <td width="81" align="center">
                <a href="poscurso.php?agenda=<?php echo $obj->id ?>" class="cssCandidados" id="<?php echo $obj->id ?>">
                   <img src="imagens/icon_pos.png" width="20" height="20" border="0" />
                </a>
            </td>
        <?php } ?>
        
        
        <?php if($user->local == 1){ ?>
        <td width="65" align="center">
            <a href="principal.php?acao=agendaCursoCadastro&id=<?php echo $obj->id ?>">
            <img src="imagens/icon_editar.gif" width="15" height="15" hspace="5" border="0" /></a>
        </td>
        <?php } ?>
        
        
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
                printf('[<a href="%s&offset=%d" >%s</a>]', 'principal.php?acao=agendacursosfinalizados&busca=' . @$_GET['busca']."&local=".@$_GET['local'], $start, $exibir);
            } else {
                printf('<a href="%s&offset=%d" >%s</a>', 'principal.php?acao=agendacursosfinalizados&busca=' . @$_GET['busca']."&local=".@$_GET['local'], $start, $exibir);
            }
        }
    }
?>

</p>

<p>&nbsp;</p>