<?php
require_once 'util/config.php';
Security::admSecurity();
$obj = new Projeto();
$obj->alias('p')
        ->order('p.nome ASC')
        ->find();

$total = $obj->count();

$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);
$obj->limit($offset, @$limit)
        ->find();


logDao::gravaLog($user->login, 'projetos', 'Acessou: lista de programas',$_REQUEST);

?>
<p><span class="titulo">Programas</span><br>
</p>
<script src="scripts/projetos.js"></script>
<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
        <td>&nbsp;</td>
        <td colspan="3" align="center"><a href="principal.php?acao=projetoCadastro">NOVO PROGRAMA</a></td>
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
            <td width="105">
            <?php if ($obj->ativo == 1) { ?>
                <a href="javascript:;" id="0|<?php echo $obj->id ?>" class="ativacao">
                    <img src="imagens/icon_power_on.png" width="16" height="16" hspace="5" border="0" />Ativo
                </a>
		    <?php } else { ?>
                <a href="javascript:;" id="1|<?php echo $obj->id ?>" class="ativacao">
                    <img src="imagens/icon_power_off.png" width="16" height="16" hspace="5" border="0" />Desativado
                </a>

       <?php } ?>
        </td>
        <td width="65">
          <a href="principal.php?acao=projetoCadastro&id=<?php echo $obj->id ?>"><img src="imagens/icon_editar.gif" width="15" height="15" hspace="5" border="0" />Editar </a>
        </td>
        <td width="74" align="right"> 
          <a href="javascript:;" id="<?php echo $obj->id ?>" class="logout"><img src="imagens/icon_delete.gif" width="15" height="15" hspace="5" border="0" align="absmiddle">Apagar</a>
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
                    printf(' [<a href="%s&offset=%d" >%s</a>]', 'principal.php?acao=projetos', $start, $exibir);
                } else {
                    printf('<a href="%s&offset=%d" > %s </a> ', 'principal.php?acao=projetos', $start, $exibir);
                }
            }
        }
    ?>

</p>