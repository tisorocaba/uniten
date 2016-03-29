<?php
require_once '../util/config.php';
Security::provaSecurity();

$obj = new AgendaCurso();
$cpbusca = $obj->escape(@$_REQUEST['busca']);

$obj->alias('a')
            ->order('a.id DESC')
            ->where('a.status = 1 and a.prova=1 and a.empresaProva = ?', $user->empresa->id)
            ->find();

/*if (empty($cpbusca)) {

    $obj->alias('a')
            ->order('a.id DESC')
            ->where('a.status = 1 and a.prova=1 and a.empresa = ?', $user->empresa->id)
            ->find();
} else {
    $obj->alias('a')
            ->join($cursos, 'INNER', 'c', 'curso', 'id', 'c.nome like ?', $cpbusca)
            ->where('a.status = 1')
            ->selectAs()
            ->order('a.id ASC')
            ->find();
}*/

/* $lista->alias('u')
  ->join($venda,'LEFT','v',null,null,'v.datavenda <= ?', '2008-01-01')
  ->select('u.nome, count(v.codvenda) as total')
  ->find(); */


$total = $obj->count();

$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);
$obj->limit($offset, @$limit)
        ->find();

logDao::gravaLog($user->login, 'agendacursos', 'Acessou: lista de agendas ', $_REQUEST);

?>
<p><span class="titulo">Agenda de Cursos</span> <br>
    <br />
  <script src="scripts/agendacursos.js"></script>
</p>
<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
        <td colspan="12"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
              <td width="45%">&nbsp;</td>
              <td width="55%" align="right">&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr class="listaClara">
        <td colspan="6"><strong>Pesquisa</strong>:
            <input name="busca" id="busca" type="text" value="<?php echo @$_REQUEST['busca']; ?>" />
            <input type="submit" name="button" id="btPesquisar" value="Localizar" /></td>
        <td colspan="6" align="right"><a href="principal.php?acao=disciplinaCadastro"></a><a href="principal.php?acao=agendaCursoCadastro"></a></td>
    </tr>
    <tr class="listaClara">
        <td><strong>Curso em andamento</strong></td>
        <td><strong>Início das inscrições</strong></td>

       
        <td><strong>Término das inscrições</strong></td>
        <td><strong>Local da prova</strong></td>
        <td><strong>Data da prova</strong></td>
        <td><strong>Horário da prova</strong></td>
        <td align="center">Candidatos</td>
        <td align="center">Exportar</td>
       
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
        <td width="235"><?php echo $obj->curso->nome ?></td>
        <td width="147"><?php echo data_br($obj->dataInicioInscricao) ?></td>
        
        <td width="153"><?php echo data_br($obj->dataFinalInscricao) ?></td>
        <td width="107"><?php echo $obj->provaLocal ?></td>
        <td width="125"><?php echo data_br($obj->provaData) ?></td>
        <td width="163"><?php echo $obj->provaHorario ?></td>
        <td width="87" align="center">
            <a href="candidatos.php?agenda=<?php echo $obj->id ?>" class="cssCandidados" id="<?php echo $obj->id ?>">
            <img src="../imagens/icon_users.png" width="19" height="20" hspace="5" border="0" />
            </a>
        </td>
        <td width="87" align="center">
        <a href="xls_candidatos.php?agenda=<?php echo $obj->id?>" target="_blank">
         <img src="../imagens/icon_excel.png" width="16" height="16" border="0" />
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
                printf('[<a href="%s&offset=%d" >%s</a>]', 'principal.php?acao=agendacursos&busca=' . @$_GET['busca'], $start, $exibir);
            } else {
                printf('<a href="%s&offset=%d" >%s</a>', 'principal.php?acao=agendacursos&busca=' . @$_GET['busca'], $start, $exibir);
            }
        }
    }
?>

</p>

<p>&nbsp;</p>