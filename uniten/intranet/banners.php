<?php
require_once 'util/config.php';
Security::admSecurity();

$obj = new Banner();
$obj->alias('b')
    ->order('b.titulo ASC')
    ->find();

$total = $obj->count();

$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);
$obj->limit($offset, @$limit)
    ->find();
logDao::gravaLog($user->login, 'agendacursos', 'Acessou: bannes',$_REQUEST);
?>


<p><span class="titulo">Banners</span><br>
</p>
<script src="scripts/banners.js"></script>

<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
      <td colspan="2">&nbsp;</td>
      <td colspan="3" align="center"><a href="principal.php?acao=bannerCadastro">NOVO BANNER</a></td>
    </tr>
    <tr class="listaClara">
      <td><strong>Cód.</strong></td>
      <td><strong>Curso</strong></td>
      <td colspan="3" align="center"></td>
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
                      <td width="208"><?php echo $obj->id ?></td>
                        <td width="620"><?php echo $obj->titulo?></td>
                        
                <td width="58"><a href="principal.php?acao=bannerCadastro&id=<?php echo $obj->id ?>"><img src="imagens/icon_editar.gif" width="15" height="15" hspace="5" border="0" />Editar </a></td>
                <td width="75" align="right"> <a href="javascript:;" id="<?php echo $obj->id ?>" class="remover"><img src="imagens/icon_delete.gif" width="15" height="15" hspace="5" border="0" align="absmiddle">Apagar</a></td>
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
                            printf('[<a href="%s&offset=%d" >%s</a>]', 'principal.php?acao=banners', $start, $exibir);
                        } else {
                            printf('<a href="%s&offset=%d" >%s</a>', 'principal.php?acao=banners', $start, $exibir);
                        }
                    }
                }
    ?>

</p>

<p>&nbsp;</p>

