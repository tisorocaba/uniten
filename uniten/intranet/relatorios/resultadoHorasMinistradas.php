<?php
require_once '../util/config.php';
Security::admSecurity();

$user = unserialize($_SESSION['USER']);


$inicio = data_us(Aluno::staticGet(12)->escape($_REQUEST['data_inicio']));
$fim = data_us(Aluno::staticGet(12)->escape($_REQUEST['data_fim']));
logDao::gravaLog($user->login, 'resultadoHorasMinistradas.php', 'Visualizou: Resultado da Pesquisa Horas Ministradas', $_REQUEST, ' Periodo: ' . $inicio . ' a ' . $fim);

// lista todas 
$sql = "SELECT 
    LC.id, 
   (select nome from curso where id = curso_id) as curso,
   (select local from local where id = local_id ) as local,
   (select nome from empresa where id = empresa_curso_id) as empresa,
   SEC_TO_TIME( SUM( TIME_TO_SEC( horas ) ) ) AS total  
  
FROM diario_classe  DC, local_curso LC
WHERE  local_curso_id = LC.id 
AND data_aula >= '{$inicio}'
AND data_aula <= '{$fim}'
AND (LC.status = 1 OR LC.status = 2)
group by local_curso_id
order by data_aula ASC";

$rs = Aluno::staticGet(12)->_getConnection()->executeSQL($sql);


$_SESSION['SQL'] = $sql;

// pega o total 
$sql = "SELECT 
			   SEC_TO_TIME( SUM( TIME_TO_SEC( horas ) ) ) AS total  
			  
			FROM diario_classe  DC, local_curso LC
			WHERE	local_curso_id = LC.id 
			AND data_aula >= '{$inicio}'
			AND data_aula <= '{$fim}'
			AND (LC.status = 1 OR LC.status = 2)
";

$rsTotal = Aluno::staticGet(12)->_getConnection()->executeSQL($sql);
$rowTotal = mysql_fetch_array($rsTotal);

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
                        <td colspan="2"><strong>Horas Ministradas</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr />
                        </td>
                    </tr>
                        <tr>
                            <td colspan="2"> <table width="100%" border="0">
                              <tr>
                                <td>Perído pesquisado: <?php echo $_REQUEST['data_inicio'];?> à  <?php echo $_REQUEST['data_fim'];?></td>
                                <td><a href="../xls_relatorios.php">Exportar</a></td>
                              </tr>
                            </table></td>
                        </tr>
                        <tr>
                          <td colspan="2"><table width="100%" border="0">
                            <tr>
                              <td>
                              <table width="100%" border="0" id="tb" class="tabelaZebra">
                      <tr>
                        <td colspan="7" bgcolor="#FFFFFF">Cursos </td>
                      </tr>
                      <tr>
                       
                        <td width="6%" bgcolor="#CCCCCC"><strong>Cód. Curso</strong></td>
                        <td width="31%" bgcolor="#CCCCCC"><strong>Curso</strong></td>
                        <td width="32%" bgcolor="#CCCCCC"><strong>Local</strong></td>
                        <td width="24%" bgcolor="#CCCCCC"><strong>Empresa</strong></td>
                        <td width="7%" bgcolor="#CCCCCC"><strong>Horas</strong></td>
                        
                      </tr>
                      <?php   while ($row = mysql_fetch_array($rs)) {?>
                      <tr >
                      
                        <td><?php echo $row['id']?></td>
                        <td><?php echo $row['curso']?></td>
                        <td><?php echo $row['local']?></td>
                        <td><?php echo $row['empresa']?></td>
                        <td><?php echo $row['total']?></td>
                      
                      </tr>
                     
                      <?php } ?>
                      
                       <tr >
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>Total</td>
                        <td><?php echo $rowTotal['total']?></td>
                      </tr>
                  </table>
                              
                              </td>
                            </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td width="48%">&nbsp;</td>
                          <td width="52%"><input type="submit" name="button" id="button" value="Continuar" /></td>
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

