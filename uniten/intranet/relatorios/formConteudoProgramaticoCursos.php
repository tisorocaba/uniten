<?php
require_once '../util/config.php';
Security::admSecurity();

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'formConteudoProgramaticoCursos.php', 'Resultado: Pesquisa de conteudo programatico :: Cursos', $_REQUEST);

$agenda = new AgendaCurso();
$inicio = $agenda->escape($_POST['data_inicio']);
$fim = $agenda->escape($_POST['data_fim']);

$agenda->alias('a')->order('id DESC')->where('a.dataInicio >= ? and a.dataTermino <= ?',$inicio,$fim)->find();

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
                            <td colspan="2">Perído pesquisado: <?php echo $inicio;?> à  <?php echo $fim;?> </td>
                        </tr>
                        <tr>
                          <td colspan="2"><table width="100%" border="0">
                            <tr>
                              <td>
                              <table width="100%" border="0" id="tb" class="tabelaZebra">
                      <tr>
                        <td colspan="6" bgcolor="#FFFFFF">Cursos localizados</td>
                      </tr>
                      <tr>
                        <td width="5%" bgcolor="#CCCCCC">&nbsp;</td>
                        <td width="17%" bgcolor="#CCCCCC"><strong>Cód. Curso</strong></td>
                        <td width="23%" bgcolor="#CCCCCC"><strong>Curso</strong></td>
                        <td width="29%" bgcolor="#CCCCCC"><strong>Local</strong></td>
                        <td width="26%" bgcolor="#CCCCCC"><strong>Empresa</strong></td>
                        
                      </tr>
                      <?php  while ($agenda->fetch()) { ?>
                      <tr >
                        <td><input type="checkbox" name="cursos[]" id="cursos" value="<?php echo $agenda->id?>" class="validate[minCheckbox[1]]" /></td>
                        <td><?php echo $agenda->id?></td>
                        <td><?php echo $agenda->curso->nome?></td>
                        <td><?php echo $agenda->local->local?></td>
                        <td><?php echo Empresa::staticGet($agenda->empresaCurso)->nome?></td>
                      
                      </tr>
                      <?php } ?>
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

