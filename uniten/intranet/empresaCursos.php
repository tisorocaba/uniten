<?php
Security::admSecurity();

$obj = new AgendaCurso();
$cod = $obj->escape(@$_REQUEST['cod']);
$status = $obj->escape(@$_REQUEST['status']);



if (Empresa::staticGet($cod)->status == 2) {
    if (!empty($_REQUEST['status'])) {
        if($_REQUEST['status']==0){
            $where = 'a.empresaCurso = ' . $cod . ' AND a.status >=' . $status;
        }else{
            $where = 'a.empresaCurso = ' . $cod . ' AND a.status =' . $status;
        }
        
    } else {
        $where = 'a.empresaCurso = ' . $cod . ' AND a.status = 1';
    }
}else{
    if (isset($_REQUEST['status'])) {
        $where = 'a.empresaProva = ' . $cod . ' AND a.status =' . $status;
    } else {
        $where = 'a.empresaProva = ' . $cod . ' AND a.status = 1';
    }
    
}


$obj->alias('a')
        ->order('a.id DESC')
        ->where($where)
        ->find();


$total = $obj->count();

$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);
$obj->limit($offset, @$limit)
        ->find();


logDao::gravaLog($user->login, 'empresaCusros', 'Acessou: lista de cursos da empresa',$_REQUEST);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<p><span class="titulo">Cursos Empresas :: <?php echo Empresa::staticGet($cod)->fantasia ?></span><br>
    <br />
</p>

<script src="scripts/empresaCursos.js"></script>
<table width="100%" cellpadding="3" cellspacing="1" class="lista" >
    <tr class="listaClara">
        <td colspan="6">

            <table width="100%" border="0">
                <tr>
                    <td width="10%"><strong>Status</strong>:</td>
                    <td width="90%">
                        <select name="status" id="cbStatus" onchange="self.location='principal.php?acao=empresaCursos&status='+this.value+'&cod=<?php echo $cod?>'">
                            <option value="1" <?php if($status=='1') echo "selected"?> >Em Andamento</option>
                            <option value="2" <?php if($status=='2') echo "selected"?>>Finalizado</option>
                             <option value="3" <?php if($status=='3') echo "selected"?>>Cancelado</option>
                             <option value="0" <?php if($status=='0') echo "selected"?>>Todos</option>
                        </select>
                    </td>
                </tr>
            </table></td>
    </tr>
    <tr class="listaClara">
        <td><strong>Curso </strong></td>
        <td><strong>Status </strong></td>
        <td><strong>Local</strong></td>
        <td><strong>Início</strong></td>
        <td><strong>Término</strong></td>

        <td width="114" align="center"><strong>Monitores</strong></td>
       <!--  <td align="center">Ativo</td> -->
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
            <td width="309"><?php echo $obj->curso->nome ?></td>
            <td width="150"><?php echo  statusCursoLocal($obj->status)?></td>
            <td width="350"><?php echo $obj->local->local ?></td>
            <td width="172"><?php echo data_br($obj->dataInicio) ?></td>
            <td width="210"><?php echo data_br($obj->dataTermino) ?></td>

            <td align="center">
                <a href="empresaCursosMonitores.php?agenda=<?php echo $obj->id ?>" class="cssMonitores" id="<?php echo $obj->id ?>">
                	<img src="imagens/icon_professor.png" alt="Monitores" width="20" height="20" border="0" />
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
                printf('[&nbsp;<a href="%s&offset=%d" >%s</a>]', 'principal.php?acao=empresaCursos&busca=' . @$_GET['busca'] . "&status=" . @$_GET['status']."&cod=".$_GET['cod'], $start, $exibir);
            } else {
                printf('&nbsp;<a href="%s&offset=%d" >%s</a>', 'principal.php?acao=empresaCursos&busca=' . @$_GET['busca'] . "&status=" . @$_GET['status']."&cod=".$_GET['cod'], $start, $exibir);
            }
        }
    }
    ?>

</p>

<p>
    <input name="alterar" value="voltar" type="button" onclick="self.location='principal.php?acao=empresas'" />
    <input name="alterar2" value="exportar" type="button" onclick="self.location='xls_empresaCursos.php?empresa=<?php echo @$_GET['cod']?>&status=<?php echo @$_GET['status']?>'" />
</p>
