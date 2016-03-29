<?php
require_once 'util/config.php';
Security::admSecurity();



$obj = new Curso();

$cbpro = $obj->escape(@$_REQUEST['projeto']);

$obj->alias('c')
        ->order('c.nome ASC')
		->where('c.ativo = 0')
        ->find();




$total = $obj->count();

$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);
$obj->limit($offset, @$limit)
        ->find();

logDao::gravaLog($user->login, 'cursos', 'Acessou: lista de cursos',$_REQUEST);
?>
<p><span class="titulo">Cursos &raquo; Inativos </span><br>
</p>

<script src="scripts/cursosinativos.js"></script>
<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
      <td colspan="4"><a href="principal.php?acao=cursos"></a>
        <table width="100%" border="0">
          <tr>
            <td width="13%"><a href="principal.php?acao=cursos">Cursos Ativos</a></td>
            <td width="87%"></td>
          </tr>
      </table></td>
      <td colspan="4" align="center"><a href="principal.php?acao=cursoCadastro">NOVO CURSO</a></td>
    </tr>
    <tr class="listaClara">
      <td><strong>Cód.</strong></td>
      <td><strong>Curso</strong></td>
      <td><strong>Destaque na Home</strong></td>
      <td><strong>Carga Horária</strong></td>
      
      <td align="center">Ativo </td>
      
    </tr>

    <?php
                $cont = 0;
                while ($obj->fetch()) {
		 
                    
                    $carga = 0;
		    $arr = $obj->_getLink('disciplinas');
                    
                    foreach ($arr as $value) {
                        $carga += $value->cargaHoraria;
                    }

                    if ($cont === 0) {
                        $linha = "listaClara";
                        $cont = 1;
                    } else {
                        $linha = "listaEscura";
                        $cont = 0;
                    }
    ?>


                    <tr class="<?php echo $linha ?>">
                      <td width="42"><?php echo $obj->id ?></td>
                        <td width="648"><?php echo $obj->nome ?></td>
                        <td width="145" align="center"><?php if((int)$obj->destaque ===1){echo "Sim";}else{echo "Não";}?> </td>
                        <td width="112" align="center"><?php echo $carga?> horas</td>
                      
                        <td width="159" align="center">
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
                            printf('&nbsp;[<a href="%s&offset=%d" >%s</a>]', 'principal.php?acao=cursos', $start, $exibir);
                        } else {
                            printf('&nbsp;<a href="%s&offset=%d" >%s</a>', 'principal.php?acao=cursos', $start, $exibir);
                        }
                    }
                }
    ?>

</p>

<p>&nbsp;</p>