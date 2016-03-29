<?php
require_once 'util/config.php';

Security::admSecurity();

$obj = new Pagina();
$obj->alias('p')
    ->order('p.titulo ASC')
    ->find();

$total = $obj->count();

$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);
$obj->limit($offset, @$limit)
    ->find();

logDao::gravaLog($user->login, 'paginas', 'Acessou: lista de paginas', $_REQUEST);

?>


<p><span class="titulo">Página do Site</span><br>
</p>
<script src="scripts/paginas.js"></script>
<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
      <td><strong>Página</strong></td>
      <td>&nbsp;</td>
      
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
      <td width="908"><?php echo $obj->titulo ?></td>
       <td width="125"><a href="principal.php?acao=paginaCadastro&id=<?php echo $obj->id ?>"><img src="imagens/icon_editar.gif" width="15" height="15" hspace="5" border="0" />Editar </a></td>
     
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
                            printf('[<a href="%s&offset=%d" >%s</a>]', 'principal.php?acao=eventos', $start, $exibir);
                        } else {
                            printf('<a href="%s&offset=%d" >%s</a>', 'principal.php?acao=eventos', $start, $exibir);
                        }
                    }
                }
    ?>

</p>

<p>&nbsp;</p>

