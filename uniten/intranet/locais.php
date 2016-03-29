<?php
require_once 'util/config.php';
Security::admSecurity();
$projeto = new Projeto();
$projeto->alias('p')->order('p.nome ASC')->find();

$obj = new Local();

$cbpro = $obj->escape(@$_REQUEST['projeto']);

if (empty($cbpro)) {
    $obj->alias('l')
        ->order('l.local ASC')
        ->find();
} else {
     $obj->alias('l')
         ->where('l.projeto=?',$cbpro)
         ->order('l.local ASC')
         ->find();

}



$total = $obj->count();

$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);
$obj->limit($offset, @$limit)
        ->find();
logDao::gravaLog($user->login, 'locais', 'Acessou: lista de locais',$_REQUEST);
?>
<p><span class="titulo">Locais</span><br>
</p>
<script src="scripts/locais.js"></script>
<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
        <td><strong>Projeto</strong>:
            <select name="projeto" id="cbProjetos">
                <option value="">Todos</option>
                <?php echo Lumine_Util::buildOptions($projeto, 'id', 'nome', $cbpro); ?>
            </select></td>
        <td colspan="3" align="center"><a href="principal.php?acao=localCadastro">NOVO LOCAL</a></td>
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


    <tr class="<?php echo $linha ?>" style="text-transform: uppercase">
                        <td width="884"><?php echo $obj->local ?></td>
                        <td width="105">
            <?php if ($obj->ativo == 1) {
            ?>
                        <a href="javascript:;" id="0|<?php echo $obj->id ?>" class="ativacao">
                            <img src="imagens/icon_power_on.png" width="16" height="16" hspace="5" border="0" />Ativo
                        </a>
            <?php } else {
 ?>
                        <a href="javascript:;" id="1|<?php echo $obj->id ?>" class="ativacao">
                            <img src="imagens/icon_power_off.png" width="16" height="16" hspace="5" border="0" />Desativado
                        </a>

<?php } ?>
                </td>
                <td width="65"><a href="principal.php?acao=localCadastro&id=<?php echo $obj->id ?>"><img src="imagens/icon_editar.gif" width="15" height="15" hspace="5" border="0" />Editar </a></td>
                <td width="74" align="right"> <a href="javascript:;" id="<?php echo $obj->id ?>" class="logout"><img src="imagens/icon_delete.gif" width="15" height="15" hspace="5" border="0" align="absmiddle">Apagar</a></td>
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
                            printf('[<a href="%s&offset=%d" >%s</a>]', 'principal.php?acao=locais&projeto='.@$_GET['projeto'], $start, $exibir);
                        } else {
                            printf('<a href="%s&offset=%d" >%s</a>', 'principal.php?acao=locais&projeto='.@$_GET['projeto'], $start, $exibir);
                        }
                    }
                }
    ?>

</p>