<?php
require_once 'util/config.php';
require_once 'dao/diarioClasseDao.php';
Security::admSecurity();
$agenda = new AgendaCurso();
if (!empty($_REQUEST['agenda'])) {
    $_SESSION['CODAGENDA'] = $agenda->escape($_REQUEST['agenda']);
}
$agenda->get($_SESSION['CODAGENDA']);



//$qtalunos = count($agenda->getLink('alunos'));
$diarios = new DiarioClasse();
$diarios->alias('d')->where('d.agenda=?', $_SESSION['CODAGENDA'])->order('d.data DESC')->find();

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'diarios', 'Acessou: lista de diarios',$_REQUEST,'','Agenda: '.$_SESSION['CODAGENDA']);

// recuperando as disciplinas
$cargahoraria = 0;
foreach ($agenda->curso->disciplinas as $diciplina) {
    $cargahoraria += $diciplina->cargaHoraria;
}

?>
<link href="intranet.css" rel="stylesheet" type="text/css">
<style type="text/css">
.titulo2 {                FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #522b2b; LINE-HEIGHT: 18px; FONT-FAMILY: Arial, Helvetica, sans-serif
}
</style>

<p><span class="titulo">Diário de Classe</span><br></p>
<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
        <td colspan="3">Código: <?php echo $agenda->id; ?><br />
          Curso: <?php echo $agenda->curso->nome ?>
            <br />
            Data de início: <?php echo data_br($agenda->dataInicio) ?>
         <br />
         Período: <?php echo $agenda->periodo ?><br />
         Carga Horária: <?php echo $cargahoraria; ?> horas
        </td>
        <td colspan="6" align="right">
          <table width="100%" border="0">
            <tr>
              <td width="34%">
               
                <table width="100%" border="0">                  
                    <tr>
                        <td><a href="modelo/relatorio-classe21.php?offset=1&folha=1" target="_blank">VERSÃO ISO </a></td>
                    </tr>                    
                </table>

              </td>
              
              <td width="33%"><a href="diarioCadastro.php">INCLUIR DIÁRIO</a></td>
              <td width="33%"><a href="modelo/relatorio-classe22.php?offset=1&folha=1" target="_blank">LISTA DE CLASSE</a></td>            
            </tr>
          </table>          
        </td>
    </tr>
    <tr class="listaClara">
        <td height="28"><strong>Cód.</strong></td>
        <td height="28"><strong>Data</strong></td>
        <td><strong>Disciplina</strong></td>
        <td><strong>Horas</strong></td>
        <td><strong>VT</strong></td>
        <td>&nbsp;</td>
        <td align="center"><strong>Visualizar</strong></td>
        <td align="center"><strong>Alterar</strong></td>
        <td align="center"><strong>Remover</strong></td>
    </tr>
    <?php
    $totalMin = 0;
    $totalVales = 0;
    $i = 0;
    $mes = '';
    while ($diarios->fetch()) {
        
       
        
        $totalMin += retornaMinutos($diarios->horas);
        $diarioClasseDao = new DiarioClasseDao();
        $vales = $diarioClasseDao->totalVales($diarios->id);

        $totalVales += $vales;
        $i++;
        ?>

        <tr class="listaClara">
            <td width="30"><?php echo $diarios->id ?></td>
            <td width="84"><?php echo data_br($diarios->data) ?></td>
            <td width="523"><?php echo Disciplina::staticGet($diarios->disciplina)->nome ?></td>
            <td width="78"><?php echo $diarios->horas ?></td>
            <td width="71"><?php echo $vales * 2 ?></td>
            <td width="76">&nbsp;</td>
            <td width="64"><a href="diarioVisualizar.php?id=<?php echo $diarios->id ?>"><img src="imagens/icon_view.png" width="24" height="24" hspace="5" border="0" /></a></td>
            <td width="44"><a href="diarioCadastro.php?id=<?php echo $diarios->id ?>"><img src="imagens/icon_editar.gif" width="15" height="15" hspace="5" border="0" /></a></td>
            <td width="61" align="right"> <a href="diarioLogic.php?id=<?php echo $diarios->id ?>&acao=remover" class="logout"><img src="imagens/icon_delete.gif" width="15" height="15" hspace="5" border="0" align="absmiddle"></a></td>
        </tr>

    <?php } ?>
    <tr class="listaClara">
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td align="right">Total:</td>
        <td><?php echo str_pad(calculaHoras($totalMin), 4, '0'); ?></td>
        <td><?php echo $totalVales * 2 ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
    </tr>
</table>
<p>Quantidade de aulas: <?php echo $i; ?></p>
