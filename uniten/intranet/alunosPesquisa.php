<?php
require_once 'util/config.php';
Security::admSecurity();
unset($_SESSION['CODAGENDA']);

if (empty($_REQUEST['tipo']) || empty($_REQUEST['pesquisa'])) {
    msg('ERRO');
    gotox('principal.php?acao=alunos');
}


$aluno = new Aluno();
$pesquisa = $aluno->escape($_REQUEST['pesquisa']);

if ($_REQUEST['tipo'] == 'CPF') {
    $aluno->alias('a')->where('a.cpf = ?', $pesquisa)->find();
} else {
    $aluno->alias('a')->where('a.nome like  ?% ', $pesquisa)->find();
    
}

$total = $aluno->count();

$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);
$aluno->limit($offset, @$limit)
      ->find();



logDao::gravaLog($user->login, 'alunosPesquisa', 'Visualizou: resultado da pesquisa', $_REQUEST,'','Pesquisa: '.$_REQUEST['pesquisa']);
?>
<link href="intranet.css" rel="stylesheet" type="text/css">
<script src="scripts/alunosPesquisa.js" type="text/javascript"></script>
<p><span class="titulo">Alunos</span><br>
    <br />
    Busca por: <b><?php echo $_REQUEST['tipo']?></b></p>
<p>Resultado da pesquisa: <b><?php echo $total?></b> alunos encontrado </p>
<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
        <td colspan="4">
        </td>
    </tr>
    <tr class="listaClara">
        <td><strong>Nome</strong></td>
        <td><strong>CPF</strong></td>
        <td><strong>RG</strong></td>
         <td><strong>Data Nascimento</strong></td>
        <td width="99" align="center">&nbsp;</td>
    </tr>

    <?php
    $cont = 0;
    while ($aluno->fetch()) {

        if ($cont === 0) {
           $linha = "listaClara";
            $cont = 1;
        } else {
            $linha = "listaEscura";
            $cont = 0;
        }
    ?>
    <tr class="<?php echo $linha?>">
        <td width="260" style="text-transform: uppercase"><a href="principal.php?acao=alunoFicha&cod=<?php echo $aluno->id?>"><?php echo $aluno->nome?></a></td>
        <td width="299"><?php echo $aluno->cpf?></td>
        <td width="380"><?php echo $aluno->rg?></td>
        <td width="380"><?php echo data_br($aluno->dataNascimento)?></td>
        <td>
            <a href="alunoHistorico.php?cod=<?php echo $aluno->id?>" class="cssHistorico">
            <img src="imagens/icon_editar.gif" width="15" height="15" hspace="5" border="0" />Histórico
            </a>
        </td>
    </tr>
    <?php } ?>
</table>

 <?php
    @$paginas = $total / $limit;

    if ($paginas > 1) {
        echo "P&aacute;gina(s)";

        for ($i = 0; $i < $paginas; $i++) {

            $exibir = $i + 1;
            $start = $i * $limit;

            if (marcaPagina(@$_GET['offset'], $limit) == $i + 1) {
                printf('&nbsp[<a href="%s&offset=%d" >%s</a>]', 'principal.php?acao=alunosPesquisa&pesquisa=' . @$_REQUEST['pesquisa'].'&tipo='.$_REQUEST['tipo'], $start, $exibir);
            } else {
                printf('&nbsp<a href="%s&offset=%d" >%s</a>', 'principal.php?acao=alunosPesquisa&pesquisa=' . @$_REQUEST['pesquisa'].'&tipo='.$_REQUEST['tipo'], $start, $exibir);
            }
        }
    }
?>
  
</p>
<p>
    <input type="submit" name="button" id="button" value="Voltar" onclick="self.location='principal.php?acao=alunos'" />
</p>
