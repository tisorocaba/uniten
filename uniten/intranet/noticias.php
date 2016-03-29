<?php
require_once 'util/config.php';

Security::admSecurity();

$obj = new Noticia();
$obj->alias('n')
    ->order('n.data DESC')
    ->find();

$total = $obj->count();

$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);
$obj->limit($offset, @$limit)
    ->find();


logDao::gravaLog($user->login, 'noticias', 'Acessou: lista de noticias', $_REQUEST);

?>


<p><span class="titulo">Notícias</span><br>
</p>
<script src="scripts/noticias.js"></script>

<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
        <td colspan="6" align="center">
          <table width="100%" border="0">
            <tr>
              <td width="88%">&nbsp;</td>
              <td width="12%"><a href="principal.php?acao=noticiaCadastro">NOVO NOTÍCIA</a></td>
            </tr>
        </table></td>
    </tr>
    <tr class="listaClara">
      <td><strong>Cód.</strong></td>
      <td><strong>Data</strong></td>
      <td  align="left"><strong>Notícia</strong></td>
     
      <td  align="center"></td>
      <td  align="center"></td>
      
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
                        <td width="31"><?php echo $obj->id ?></td>
                        <td width="111"><?php echo data_br($obj->data)?></td>
                        <td width="834"><?php echo $obj->titulo?></td>
                       
                       <td width="67">
                           <a href="principal.php?acao=noticiaCadastro&id=<?php echo $obj->id ?>">
                               <img src="imagens/icon_editar.gif" width="15" height="15" hspace="5" border="0" />Editar 
                           </a>
                       </td>
                      <td width="92" align="right"> 
                           <a href="javascript:;" id="<?php echo $obj->id ?>" class="remover">
                              <img src="imagens/icon_delete.gif" width="15" height="15" hspace="5" border="0" align="absmiddle">Apagar
                           </a>
                      </td>
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
                            printf('[<a href="%s&offset=%d" >%s</a>]', 'principal.php?acao=noticias', $start, $exibir);
                        } else {
                            printf('<a href="%s&offset=%d" >%s</a>', 'principal.php?acao=noticias', $start, $exibir);
                        }
                    }
                }
    ?>

</p>

<p>&nbsp;</p>

