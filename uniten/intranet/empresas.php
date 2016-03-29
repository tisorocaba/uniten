<?php
require_once 'util/config.php';
Security::admSecurity();
$obj = new Empresa();
$obj->alias('p')
        ->order('p.nome ASC')
        ->find();

$total = $obj->count();

$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);
$obj->limit($offset, @$limit)
        ->find();
logDao::gravaLog($user->login, 'empresas', 'Acessou: lista de empresas',$_REQUEST);
?>
<p><span class="titulo">Empresas</span><br>
</p>
<script src="scripts/empresas.js"></script>
<table width="100%" cellpadding="1" cellspacing="1" class="lista">

    <tr class="listaClara">
      <td>&nbsp;</td>
      <td colspan="5" align="center"><a href="principal.php?acao=empresaCadastro">NOVA EMPRESA</a></td>
    </tr>
     <tr class="listaClara">
      <td><strong>Empresas</strong></td>
      <td><strong>Cursos</strong></td>
      <td><strong>Usuários</strong></td>
      <td><strong>Ativo</strong></td>
      <td><strong>Alterar</strong></td>
      <td align="right"><strong>Remover</strong></td>
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
      <td width="884"><?php echo $obj->fantasia ?></td>
      <td width="95">
      <?php if((int)$obj->status==2){ ?>
      		 <a href="principal.php?acao=empresaCursos&cod=<?php echo $obj->id ?>"><img src="imagens/icon_lista.png"  border="0" /></a>
      <?php } ?>
      </td>
      <td width="95"><a href="principal.php?acao=usuarios&amp;empresa=<?php echo $obj->id ?>"><img src="imagens/icon_users.png" width="20" height="20" hspace="5" border="0" /></a></td>
      <td width="105"><?php if ($obj->ativo == 1) {
 ?>
        <a href="javascript:;" id="0|<?php echo $obj->id ?>" class="ativacao"> <img src="imagens/icon_power_on.png" width="16" height="16" hspace="5" border="0" /></a>
        <?php } else { ?>
        <a href="javascript:;" id="1|<?php echo $obj->id ?>" class="ativacao"> <img src="imagens/icon_power_off.png" width="16" height="16" hspace="5" border="0" /></a>
        <?php } ?></td>
      <td width="65"><a href="principal.php?acao=empresaCadastro&id=<?php echo $obj->id ?>"><img src="imagens/icon_editar.gif" width="15" height="15" hspace="5" border="0" /></a></td>
      <td width="74" align="right"><a href="javascript:;" id="<?php echo $obj->id ?>" class="logout"><img src="imagens/icon_delete.gif" width="15" height="15" hspace="5" border="0" align="absmiddle" /></a></td>
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
                    printf(' [<a href="%s&offset=%d" >%s</a>]', 'principal.php?acao=empresas', $start, $exibir);
                } else {
                    printf('<a href="%s&offset=%d" > %s </a> ', 'principal.php?acao=empresas', $start, $exibir);
                }
            }
        }
    ?>

</p>