<?php
require_once 'util/config.php';
Security::admSecurity();


if(!is_numeric($_REQUEST['cod'])){
    die('ERRO: Acesso Negado');
}
$professor = new Professor();
$cod = $professor->escape($_REQUEST['cod']);

$professor->get($cod);



$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'professorHistorico', 'Acessou: Historico do Professor',$_REQUEST,'','Professor: '.$_REQUEST['cod']);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="intranet.css" rel="stylesheet" type="text/css">
<script src="js/jquery-1.5.min.js" type="text/javascript"></script>

<script>
    $( "tr:even" ).css( "background-color", "#A9D6F5" );
    $( "tr:odd" ).css( "background-color", "#ACE6CB" )

</script>

<table width="100%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Histórico do Professor</strong></p>
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="3" cellpadding="1" > 
                <tr>
                    <td width="100%"><a href="xls_professor_historico.php?cod=<?php echo $cod ?>" target="_blank">Exportar para Excel</a></td>
                </tr>
                <tr> 
                    <td><table width="100%" border="0" id="tb" class="tabelaZebra">
                      <tr>
                        <td colspan="5" bgcolor="#FFFFFF"><strong>Nome: <?php echo $professor->nome; ?></strong></td>
                      </tr>
                      <tr>
                        <td width="8%" bgcolor="#CCCCCC"><strong>Cód. Curso</strong></td>
                        <td width="26%" bgcolor="#CCCCCC"><strong>Curso</strong></td>
                        <td width="24%" bgcolor="#CCCCCC"><strong>Disciplina</strong></td>
                        <td width="22%" bgcolor="#CCCCCC"><strong>Local</strong></td>
                        <td width="20%" bgcolor="#CCCCCC"><strong>Período do curso</strong></td>
                      </tr>
                      <?php foreach($professor->historico() as $historico) { ?>
                      <tr >
                        <td><?php echo $historico['cod']?></td>
                        <td><?php echo $historico['curso']?></td>
                        <td><?php echo $historico['disciplina']?></td>
                        <td><?php echo $historico['local']?></td>
                        <td><?php echo $historico['inicio']?> à <?php echo $historico['termino']?></td>
                      </tr>
                      <?php } ?>
                  </table></td>
                </tr>
</table>

</td>
</tr>
</table>

