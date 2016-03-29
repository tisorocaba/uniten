<?php
require_once '../util/config.php';
Security::admSecurity();

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'resultadoConteudoProgramaticoCursos.php.php', 'Resultado:Consulta de conteudo programatico :: Cursos', $_REQUEST);

$agenda = new AgendaCurso();
$ag = implode(",", $_POST['cursos']);


$sql = <<<EOD
SELECT local_curso_id, DATE_FORMAT(data_aula, '%d/%m/%Y') as data,horas, (select nome from disciplina where id = disciplina_id ) as disciplina,conteudo, 
(select nome from professor where id = professor_id ) as professor
 FROM diario_classe where local_curso_id IN ({$ag}) order by  local_curso_id ASC
EOD;


$_SESSION['SQL'] = $sql;
 
$rs = $agenda->_getConnection()->executeSQL($sql);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../intranet.css" rel="stylesheet" type="text/css">
<link href="../css/validationEngine.jquery.css" rel="stylesheet" type="text/css">
<link href="../js/css/jquery-ui.css" rel="stylesheet" type="text/css">
<link href="../js/css/ui.theme.css" rel="stylesheet" type="text/css">
<script src="../js/jquery-1.6.2.min.js"></script>
<script src="../js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.ui.core.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.ui.widget.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.ui.datepicker.js" type="text/javascript" charset="utf-8"></script>

<script src="scripts/formConteudoProgamatico.js"></script>

<table width="100%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Relatórios</strong></p>
        </td>
    </tr>
    <tr>
        <td>
            <form action="resultadoConteudoProgramaticoCursos.php" method="post" name="form1" id="form1">
                <table width="100%" border="0" cellspacing="3" cellpadding="1">
                    <tr>
                        <td colspan="2"><strong>Conteúdo Programático</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><a href="../xls_relatorios.php">Exportar</a></td>
                    </tr>
                    <tr>
                        <td colspan="2"><table width="100%" border="0">
                                <tr>
                                    <td>
                                        <table width="100%" border="0" id="tb" class="tabelaZebra">
                                            <tr>
                                                <td colspan="6" bgcolor="#FFFFFF">Conteúdo Programático <br />
                                               </tr>
                                            <tr>

                                                <td width="6%" bgcolor="#CCCCCC"><strong>Data</strong></td>
                                                <td width="9%" bgcolor="#CCCCCC"><strong>Carga Horária</strong></td>
                                                <td width="28%" bgcolor="#CCCCCC"><strong>Disciplina</strong></td>
                                                <td width="27%" bgcolor="#CCCCCC"><strong>Conteúdo</strong></td>
                                                <td width="30%" bgcolor="#CCCCCC"><strong>Professor</strong></td>

                                            </tr>
                                            <?php while ($row = mysql_fetch_array($rs)) { ?>
                                                <tr >
                                                    <td><?php echo $row['data'] ?></td>
                                                    <td><?php echo $row['horas'] ?></td>
                                                    <td><?php echo $row['disciplina'] ?></td>
                                                    <td><?php echo $row['conteudo'] ?></td>
                                                    <td><?php echo $row['professor'] ?></td>
                                                </tr>
                                            <?php } ?>
                                        </table>

                                    </td>
                                </tr>
                            </table></td>
                    </tr>
                    <tr>
                        <td width="48%">&nbsp;</td>
                        <td width="52%"><input type="button" name="button" id="button" value="Voltar" onclick="history.go(-2)" /></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td> * campos obrigatórios</td>
                    </tr>

                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                </table>
            </form>

        </td>
    </tr>
</table>

