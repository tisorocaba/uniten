<?php
require_once 'util/config.php';
Security::admSecurity();
$obj = new UniteEmprega();
$obj->alias('p')
        ->order('p.fantasia ASC')
        ->find();

$total = $obj->count();

$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);
$obj->limit($offset, @$limit)
        ->find();
logDao::gravaLog($user->id, 'empresas', 'lista_de_empresas');
?>
<p><span class="titulo">UNITE Emprega &raquo; Empresas</span><br>
</p>
<script src="scripts/uniteemprega.js"></script>
<table width="100%" cellpadding="0" cellspacing="0" class="lista">
<tr >
  <td width="65"><table width="100%" cellpadding="1" cellspacing="1" class="lista">
    <tr class="listaClara">
      <td>&nbsp;</td>
      <td colspan="5" align="right"><a href="principal.php?acao=uniteempregaEmpresaCadastro">NOVA EMPRESA</a></td>
    </tr>
     <tr class="listaClara">
      <td>Empresa</td>
     
      <td align="center"><strong>Alunos</strong></td>
      <td align="center"><strong>Ativo</strong></td>
      <td align="center"><strong>Alterar</strong></td>
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
      <td width="522" style="text-transform:uppercase"><a href="principal.php?acao=uniteempregaEmpresaFicha&cod=<?php echo $obj->id ?>"><?php echo $obj->fantasia ?></a></td>
    
      <td width="416"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr >
          <td width="26%" align="center"><a href="uniteempregaProcesso.php?empresa=<?php echo $obj->id ?>&status=0" class="cssProcessos">Entrevistas</a></td>
          <td width="26%" align="center"><a href="uniteempregaProcesso.php?empresa=<?php echo $obj->id ?>&status=1" class="cssProcessos">Experiência</a></td>
          <td width="28%" align="center"><a href="uniteempregaProcesso.php?empresa=<?php echo $obj->id ?>&status=2" class="cssProcessos">Efetivados</a></td>
          <td width="20%" align="center"><a href="uniteempregaProcesso.php?empresa=<?php echo $obj->id ?>&status=3" class="cssProcessos">Deligados</a></td>
        </tr>
      </table></td>
      <td width="123" align="center"><?php if ($obj->status == 1) {
 ?>
        <a href="javascript:;" id="0|<?php echo $obj->id ?>" class="ativacao"> 
        <img src="imagens/icon_power_on.png" width="16" height="16" hspace="5" border="0" /></a>
        <?php } else { ?>
        <a href="javascript:;" id="1|<?php echo $obj->id ?>" class="ativacao"> <img src="imagens/icon_power_off.png" width="16" height="16" hspace="5" border="0" /></a>
        <?php } ?></td>
      <td width="74" align="center">
         <a href="principal.php?acao=uniteempregaEmpresaCadastro&cod=<?php echo $obj->id ?>">
           <img src="imagens/icon_editar.gif" width="15" height="15" hspace="5" border="0" />
         </a>
      </td>
      <td width="92" align="right"><a href="javascript:;" id="<?php echo $obj->id ?>" class="logout"><img src="imagens/icon_delete.gif" width="15" height="15" hspace="5" border="0" align="absmiddle" /></a></td>
    </tr>
    <?php } ?>
  </table>    <a href="principal.php?acao=empresaCadastro&id=<?php echo $obj->id ?>"></a></td>
</tr>
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
                    printf(' [<a href="%s&offset=%d" >%s</a>]', 'principal.php?acao=uniteemprega', $start, $exibir);
                } else {
                    printf('<a href="%s&offset=%d" > %s </a> ', 'principal.php?acao=uniteemprega', $start, $exibir);
                }
            }
        }
    ?>

</p>