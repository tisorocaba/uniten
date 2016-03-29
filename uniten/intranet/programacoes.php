<?php
require_once 'util/config.php';
Security::admSecurity();
$cursos = new Curso();
$cursos->alias('c')->order('c.nome ASC')->find();

$obj = new AgendaCurso();

$cpbusca = $obj->escape(@$_REQUEST['busca']);

$curos = new Curso();
$curos->alias('c')->where('c.ativo=1')->order('c.nome ASC')->find();

$where = 'a.status = 4';

if(!empty($_REQUEST['pesquisa'])){
    
    if(!empty($_REQUEST['mes'])){
        $where .= ' and MONTH(data_inicio) = '.$_REQUEST['mes'];
    }
    
    if(!empty($_REQUEST['curso'])){
        $where .= ' and curso_id = '.$_REQUEST['curso'];
    }
    
}

$obj->alias('a')
        ->order('a.id DESC')
        ->where($where)
        ->find();




$total = $obj->count();

$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);
$obj->limit($offset, @$limit)
        ->find();

logDao::gravaLog($user->login, 'programacoes', 'Acessou: programacoes', $_REQUEST);


$_SESSION['SQL'] = $obj->_getSQL();

?>
<p><span class="titulo">Programação</span><br>
    <br />
<link href="css/validationEngine.jquery.css" rel="stylesheet" type="text/css">
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/programacoes.js"></script>
</p>
<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
        <td colspan="12">
        <form id="form1" name="form1" method="post" action="principal.php?acao=programacoes">
        <input name="pesquisa" type="hidden" value="on" />
          <table width="100%" border="0">
            <tr>
              <td width="44%"><strong>Mês</strong>:
                <select name="mes" id="mes" style="text-transform:uppercase">
                  <option value="">TODOS</option>
                  <option value="1" <?php if(@$_REQUEST['mes']==1){ echo "selected=\"selected\"";}?> >Janeiro</option>
                  <option value="2" <?php if(@$_REQUEST['mes']==2){ echo "selected=\"selected\"";}?>>Fevereiro</option>
                  <option value="3" <?php if(@$_REQUEST['mes']==3){ echo "selected=\"selected\"";}?>>Março</option>
                  <option value="4" <?php if(@$_REQUEST['mes']==4){ echo "selected=\"selected\"";}?>>Abril</option>
                  <option value="5" <?php if(@$_REQUEST['mes']==5){ echo "selected=\"selected\"";}?>>Maio</option>
                  <option value="6" <?php if(@$_REQUEST['mes']==6){ echo "selected=\"selected\"";}?>>Junho</option>
                  <option value="7" <?php if(@$_REQUEST['mes']==7){ echo "selected=\"selected\"";}?>>Julho</option>
                  <option value="8" <?php if(@$_REQUEST['mes']==8){ echo "selected=\"selected\"";}?>>Agosto</option>
                  <option value="9" <?php if(@$_REQUEST['mes']==9){ echo "selected=\"selected\"";}?>>Setembro</option>
                  <option value="10" <?php if(@$_REQUEST['mes']==10){ echo "selected=\"selected\"";}?>>Outubro</option>
                  <option value="11" <?php if(@$_REQUEST['mes']==11){ echo "selected=\"selected\"";}?>>Novembro</option>
                  <option value="12" <?php if(@$_REQUEST['mes']==12){ echo "selected=\"selected\"";}?>>Dezembro</option>
                </select></td>
              <td width="49%">&nbsp;</td>
              <td width="7%">&nbsp;</td>
            </tr>
            <tr>
              <td><strong>Curso</strong>:
                <select name="curso" id="cbLocal" >
                  <option value="">TODOS</option>
                  <?php echo Lumine_Util::buildOptions($cursos,'id','nome', @$_REQUEST['curso']); ?>
                </select></td>
              <td><input type="submit" name="button" id="button" value="Filtrar" /></td>
              <td><a href="xls_relatorios.php">Exportar</a></td>
            </tr>
          </table>
        </form></td>
    </tr>
    <tr >
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr class="listaClara">
        <td><strong>Cód.</strong></td>
        <td><strong>Curso </strong></td>

        <td><strong>Local</strong></td>
        <td><strong>Início</strong></td>
        <td><strong>Término</strong></td>
        <td><strong> Mês</strong></td>
        <td><strong>Vagas</strong></td>
        <td align="center"><strong>Período</strong></td>
        <td align="center"><strong>Sala</strong></td>
        
        
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
        <td width="15"><?php echo $obj->id?></td>
        <td width="330"><?php echo $obj->curso->nome ?></td>
        <td width="232"><?php echo $obj->local->local ?></td>
        <td width="232"><?php echo data_br($obj->dataInicio); ?></td>
        <td width="232"><?php echo data_br($obj->dataTermino); ?></td>
        <td width="81"><?php echo mostraMes(date('m',strtotime($obj->dataInicio))) ?></td>
        <td width="109"><?php echo $obj->vagas ?></td>
        <td width="93" align="center"><?php echo $obj->periodo ?></td>
        <td width="93" align="center"><?php echo $obj->sala ?></td>
    
        
        
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

            if (marcaPagina(@$_GET['offset'], $limit) == $i + 1) {
                printf('&nbsp;[<a href="%s&offset=%d" >%s</a>]', 'principal.php?acao=programacoes&mes=' . @$_REQUEST['mes']."&curso=".@$_GET['curso'], $start, $exibir);
            } else {
                printf('&nbsp;<a href="%s&offset=%d" >%s</a>', 'principal.php?acao=programacoes&busca=' . @$_REQUEST['mes']."&curso=".@$_GET['curso'], $start, $exibir);
            }
        }
    }
?>

</p>

<p>&nbsp;</p>