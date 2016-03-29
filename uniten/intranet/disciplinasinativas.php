<?php
require_once 'util/config.php';

$cursos = new Curso();
$cursos->alias('c')->order('c.nome ASC')->find();

$obj = new Disciplina();

$pesquisa = $obj->escape(@$_REQUEST['pesquisa']);

if (empty($pesquisa)) {
    $obj->alias('d')
	    ->where('d.ativo = 0')
        ->order('d.nome ASC')
        ->find();
} else {
     $obj->alias('d')
         ->where('d.nome like ? and d.ativo = 0',$pesquisa)
         ->order('d.nome ASC')
         ->find();
}




$total = $obj->count();

$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);
$obj->limit($offset, @$limit)
        ->find();



logDao::gravaLog($user->login, 'disciplinas', 'Acessou: lista de disciplinas',$_REQUEST);
?>
<p><span class="titulo">Disciplinas</span> <span class="titulo">&raquo; Inativas</span><br>
</p>
<script src="scripts/disciplinas.js"></script>
<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
      <td colspan="3"><table width="100%" border="0">
        <tr>
          <td><a href="principal.php?acao=disciplinas">Disciplinas Ativas</a></td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
      <td colspan="3" align="center"><a href="principal.php?acao=disciplinaCadastro">NOVA DISCIPLINA</a></td>
    </tr>
    <tr class="listaClara">
      
      <td><strong>Disciplina</strong></td>
      <td><strong>Horas</strong></td>
      <td align="center">Ativo</td>
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
                      
                        <td width="432" style="text-transform: uppercase"><?php echo $obj->nome ?></td>
                        <td width="349"><?php echo $obj->cargaHoraria ?></td>
                        <td width="91" align="center">
                             <?php if ($obj->ativo == 1) { ?>
                        <a href="javascript:;" id="0|<?php echo $obj->id ?>" class="ativacao">
                          <img src="imagens/icon_power_on.png" width="16" height="16" hspace="5" border="0" /></a>
                            <?php } else { ?>
                        <a href="javascript:;" id="1|<?php echo $obj->id ?>" class="ativacao">
                          <img src="imagens/icon_power_off.png" width="16" height="16" hspace="5" border="0" /></a>

                    <?php } ?>
                </td>
                <td width="70" align="center">&nbsp;</td>
              
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
                            printf(' [<a href="%s&offset=%d" >%s</a>] ', 'principal.php?acao=disciplinasinativas&pesquisa='.@$_GET['pesquisa'], $start, $exibir);
                        } else {
                            printf(' <a href="%s&offset=%d" >%s</a> ', 'principal.php?acao=disciplinasinativas&pesquisa='.@$_GET['pesquisa'], $start, $exibir);
                        }
                    }
                }
    ?>

</p>

<p>&nbsp;</p>