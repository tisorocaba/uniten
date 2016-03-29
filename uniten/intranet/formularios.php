<?php
require_once 'util/config.php';
Security::admSecurity();

$obj = new Formulario();
$obj->alias('c')
        ->order('c.nome ASC')
        ->find();
$total = $obj->count();
$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);
$obj->limit($offset, @$limit)
        ->find();

logDao::gravaLog($user->login, 'formularios', 'Acessou: lista de formularios', $_REQUEST);
?>
<p><span class="titulo">Formulários</span><br>
</p>

<script src="scripts/formularios.js"></script>
<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr>
      <td>&nbsp;</td>
      <td width="770">&nbsp;</td>
      <td width="156" align="center">
      <?php if($user->id == 4 || $user->id == 1) { ?>
      <a href="principal.php?acao=formularioCadastro">NOVO FORMULÁRIO</a>
      <?php } ?>
      </td>
    </tr>
    <tr class="listaClara">
      <td><strong>Data Cadastro</strong></td>
      <td><strong>Nome</strong></td>
      <td align="center">&nbsp;</td>
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
                        <td width="156"><?php echo data_br($obj->dataCadastro) ?></td>
                        <td><a href="<?php echo URLARQ . $obj->arquivo ?>" target="_blank"><?php echo $obj->nome ?></a></td>
                        <td colspan="3" align="center"><a href="javascript:;" id="<?php echo $obj->id ?>" class="excluir"><img src="imagens/icon_delete.gif" width="15" height="15" hspace="5" border="0" align="absmiddle"></a></td>
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
