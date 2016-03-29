<?php
require_once 'util/config.php';

$obj = new Professor();
$empresas = new Empresa ();

$empresas->alias('p')->where('p.ativo=1 and status >= 2')->order('p.nome ASC')->find();
$cbemp = $obj->escape(@$_REQUEST['empresa']);
if (empty($cbemp)) {
    
    if(empty($_REQUEST['busca'])){
        $obj->alias('p')
            ->order('p.nome ASC')
            ->find();
    }else{
        $obj->alias('p')
            ->where('p.nome like ?',$obj->escape($_REQUEST['busca']))     
            ->order('p.nome ASC')
            ->find();
    }
    
    
} else {
    $obj->alias('p')
            ->where('p.empresa=?', $cbemp)
            ->order('p.nome ASC')
            ->find();
}
$total = $obj->count();

$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);
$obj->limit($offset, @$limit)
        ->find();

logDao::gravaLog($user->login, 'professores', 'Acessou: lista de professores',$_REQUEST);
?>
<p><span class="titulo">Professores</span><br />
  <br>
<a href="xls_professores.php?empresa=<?php echo @$_GET['empresa'] ?>" target="_blank">Exportar para Excel</a></p>
<script src="scripts/professores.js"></script>
<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
      <td><strong>Filtrar por nome</strong>:
        <input type="text" name="busca" id="busca" value="<?php echo @$_REQUEST['busca']?>" />
      <input type="submit" name="button" id="btLocalizar" value="Localizar" /></td>
      <td colspan="4" align="center"><a href="principal.php?acao=professorCadastro&amp;empresa=<?php echo @$_GET['empresa'] ?>">NOVO PROFESSOR</a></td>
    </tr>
    <tr class="listaClara">
        <td><strong>Empresa</strong>:
        <select name="empresa" id="cbEmpresas">
          <option value="">Todos</option>
          <?php echo Lumine_Util::buildOptions($empresas, 'id', 'fantasia', $cbemp); ?>
        </select></td>
        <td align="center">Histórico </td>
        <td align="center">Ativo<a href="principal.php?acao=professorCadastro&empresa=<?php echo @$_GET['empresa'] ?>"></a></td>
        <td align="center">Editar</td>
        <td align="center">Apagar</td>
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
                        <td width="884"><?php echo $obj->nome ?></td>
                        <td width="105" align="center" ><a href="professorHistorico.php?cod=<?php echo $obj->id?>" class="cssHistorico" ><img src="imagens/icon_historico.png" width="16" height="16" border=0 alt="histórico" /></a></td>
                        <td width="105" align="center">
            <?php if ($obj->ativo == 1) {
            ?>
                        <a href="javascript:;" id="0|<?php echo $obj->id ?>" class="ativacao">
                            <img src="imagens/icon_power_on.png" width="16" height="16" hspace="5" border="0" />
                        </a>
            <?php } else { ?>
                        <a href="javascript:;" id="1|<?php echo $obj->id ?>" class="ativacao">
                            <img src="imagens/icon_power_off.png" width="16" height="16" hspace="5" border="0" />
                        </a>

            <?php } ?>
                </td>
                <td width="65" align="center"><a href="principal.php?acao=professorCadastro&id=<?php echo $obj->id ?>"><img src="imagens/icon_editar.gif" width="15" height="15" hspace="5" border="0" /></a></td>
                <td width="74" align="center"> <a href="javascript:;" id="<?php echo $obj->id ?>" class="logout"><img src="imagens/icon_delete.gif" width="15" height="15" hspace="5" border="0" align="absmiddle"></a></td>
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
                            printf('&nbsp;[<a href="%s&offset=%d" >%s</a>]', 'principal.php?acao=professores&empresa=' . @$_GET['empresa'], $start, $exibir);
                        } else {
                            printf('&nbsp;<a href="%s&offset=%d" >%s</a>', 'principal.php?acao=professores&empresa=' . @$_GET['empresa'], $start, $exibir);
                        }
                    }
                }
    ?>

</p>