<?php
require_once 'util/config.php';
Security::admSecurity();

$obj = new Feriado();
$obj->alias('f')
        ->order('f.titulo DESC')
        ->find();




$total = $obj->count();

$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);
$obj->limit($offset, @$limit)
        ->find();
logDao::gravaLog($user->login, 'feriados', 'Acessou: lista de feriados', $_REQUEST);
?>
<p><span class="titulo">Feriados e Pontes</span><br>
</p>

<script src="scripts/feriados.js"></script>
<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
      <td colspan="5" align="right"><a href="principal.php?acao=feriadoCadastro">NOVO FERIADO</a></td>
    </tr>
    <tr class="listaClara">
      <td><strong>Feriado</strong></td>
      <td width="188"><strong>Data </strong></td>
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
                      <td width="784"><?php echo $obj->titulo ?></td>
                        <td><?php echo data_br($obj->data) ?></td>
                       
                <td width="44" align="center"><a href="principal.php?acao=feriadoCadastro&id=<?php echo $obj->id ?>"><img src="imagens/icon_editar.gif" width="15" height="15" hspace="5" border="0" /></a></td>
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
