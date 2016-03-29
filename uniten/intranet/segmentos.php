<?php
require_once 'util/config.php';
Security::admSecurity();



$obj = new Segmento();

$cbpro = $obj->escape(@$_REQUEST['projeto']);

$obj->alias('c')
        ->order('c.nome ASC')
        ->find();




$total = $obj->count();

$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);
$obj->limit($offset, @$limit)
        ->find();
logDao::gravaLog($user->login, 'segmentos', 'Acessou: lista de segmentos', $_REQUEST);
?>
<p><span class="titulo">Segmentos</span><br>
</p>

<script src="scripts/segmentos.js"></script>
<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
      <td colspan="2">&nbsp;</td>
      <td colspan="4" align="center"><a href="principal.php?acao=segmentoCadastro">NOVO SEGMENTO</a></td>
    </tr>
    <tr class="listaClara">
      <td><strong>Cód.</strong></td>
      <td><strong>Segmento</strong></td>
      <td align="center">Ativo </td>
      <td align="center">Editar </td>
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
                      <td width="40"><?php echo $obj->id ?></td>
                        <td><?php echo $obj->nome ?></td>
                        <td width="51" align="center">
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
                <td width="44" align="center"><a href="principal.php?acao=segmentoCadastro&id=<?php echo $obj->id ?>"><img src="imagens/icon_editar.gif" width="15" height="15" hspace="5" border="0" /></a></td>
                <td width="50" align="center"> <a href="javascript:;" id="<?php echo $obj->id ?>" class="logout"><img src="imagens/icon_delete.gif" width="15" height="15" hspace="5" border="0" align="absmiddle"></a></td>
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
                            printf('[<a href="%s&offset=%d" >%s</a>]', 'principal.php?acao=segmentos', $start, $exibir);
                        } else {
                            printf('<a href="%s&offset=%d" >%s</a>', 'principal.php?acao=segmentos', $start, $exibir);
                        }
                    }
                }
    ?>

</p>
