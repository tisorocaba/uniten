<?php
require_once 'util/config.php';
Security::admSecurity();



$obj = new Curso();

$cbpro = $obj->escape(@$_REQUEST['projeto']);

if(!empty($_REQUEST['busca'])) {
    $obj->alias('c')
            ->where('c.nome like ? and c.ativo = 1', $obj->escape($_REQUEST['busca']))
            ->order('c.nome ASC')
            ->find();
}else{
    $obj->alias('c')
        ->order('c.nome ASC')
        ->where('c.ativo = 1')
        ->find();
}






$total = $obj->count();

$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);
$obj->limit($offset, @$limit)
        ->find();

logDao::gravaLog($user->login, 'cursos', 'Acessou: lista de cursos', $_REQUEST);
?>
<p><span class="titulo">Cursos&raquo; Ativos </span> <br>
</p>

<script src="scripts/cursos.js"></script>
<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
        <td colspan="4">
          <table width="100%" border="0">
            <tr>
              <td><a href="principal.php?acao=cursosinativos">Cursos Inativos</a></td>
              <td>Filtrar por nome</strong>:
              <input type="text" name="busca" id="busca" value="<?php echo @$_REQUEST['busca']?>" />
              <input type="button" name="button" id="btLocalizar" value="Localizar"  onclick="self.location='principal.php?acao=cursos&busca='+busca.value"/></td>
            </tr>
        </table></td>
        <td colspan="4" align="center"><a href="principal.php?acao=cursoCadastro">NOVO CURSO</a></td>
    </tr>
    <tr class="listaClara">
        <td><strong>Cód.</strong></td>
        <td><strong>Curso</strong></td>
        <td><strong>Destaque na Site</strong></td>
        <td><strong>Carga Horária</strong></td>

        <td align="center">Ativo </td>
        <td align="center">Editar </td>
        <td align="center">Apagar</td>
    </tr>

    <?php
    $cont = 0;
    while ($obj->fetch()) {


        $carga = 0;
        $arr = $obj->_getLink('disciplinas');

        foreach ($arr as $value) {
            $carga += $value->cargaHoraria;
        }

        if ($cont === 0) {
            $linha = "listaClara";
            $cont = 1;
        } else {
            $linha = "listaEscura";
            $cont = 0;
        }
        ?>


        <tr class="<?php echo $linha ?>">
            <td width="38"><?php echo $obj->id ?></td>
            <td width="620"><?php echo $obj->nome ?></td>
            <td width="141" align="center"><?php if ((int) $obj->destaque === 1) {
        echo "Sim";
    } else {
        echo "Não";
    } ?> </td>
            <td width="92" align="center"><?php echo $carga ?> horas</td>

            <td width="48" align="center">
                <?php if ($obj->ativo == 1) {
                    ?>
                    <a href="javascript:;" id="0|<?php echo $obj->id ?>" class="ativacao">
                        <img src="imagens/icon_power_on.png" width="16" height="16" hspace="5" border="0" /></a>
    <?php } else {
        ?>
                    <a href="javascript:;" id="1|<?php echo $obj->id ?>" class="ativacao">
                        <img src="imagens/icon_power_off.png" width="16" height="16" hspace="5" border="0" /></a>

    <?php } ?>
            </td>
            <td width="43" align="center"><a href="principal.php?acao=cursoCadastro&id=<?php echo $obj->id ?>"><img src="imagens/icon_editar.gif" width="15" height="15" hspace="5" border="0" /></a></td>
            <td width="53" align="center"> <a href="javascript:;" id="<?php echo $obj->id ?>" class="logout"><img src="imagens/icon_delete.gif" width="15" height="15" hspace="5" border="0" align="absmiddle"></a></td>
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
                printf('&nbsp;[<a href="%s&offset=%d" >%s</a>]', 'principal.php?acao=cursos', $start, $exibir);
            } else {
                printf('&nbsp;<a href="%s&offset=%d" >%s</a>', 'principal.php?acao=cursos', $start, $exibir);
            }
        }
    }
    ?>

</p>

<p>&nbsp;</p>