<?php
require_once 'util/config.php';
require_once 'dao/agendaCursoDao.php';
require 'dao/diarioClasseDao.php';
Security::admSecurity();
$diarioDao = new DiarioClasseDao();

$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);

$diario = new DiarioClasse();
$diario->get($_SESSION['CODDIARIO']);

$disciplina = new Disciplina();
$disciplina->get($diario->disciplina);

$professor = new Professor();
$professor->get($diario->professor);

$agendaDao = new AgendaCursoDao();
$alunos = $agendaDao->listaAlunoAgenda($_SESSION['CODAGENDA']);

$user = unserialize($_SESSION['USER']);

logDao::gravaLog($user->login, 'diarioAlunos', 'Acessou: Presença e Vale-transporte',$_REQUEST,'','Diario: '.$_SESSION['CODDIARIO']);
?>
<link href="intranet.css" rel="stylesheet" type="text/css">
<link href="css/validationEngine.jquery.css" rel="stylesheet" type="text/css">

<script src="js/jquery-1.5.min.js" type="text/javascript"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.limite-char-1.0.js" type="text/javascript"></script>
<script src="scripts/diarioAlunos.js" type="text/javascript"></script>
<table width="95%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Diário de Classe</strong></p>
        </td>
    </tr>
    <tr>
        <td>
            <form action="diarioLogic.php" method="post" id="form2">
                <input name="diario" id="diario" type="hidden" value="<?php echo $_SESSION['CODDIARIO'] ?>" />
                <input name="id" type="hidden" value="<?php echo @$_REQUEST['id'] ?>" />
                <input name="acao" type="hidden" value="gravapresenca" />
              
                <table width="100%" border="0" cellspacing="3" cellpadding="1">
                    <tr>
                        <td colspan="2"><strong>Dados do diário</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr />
                        </td>
                    </tr>
                    <tr>
                        <td width="16%">Curso:</td>
                        <td width="84%"><?php echo $agenda->curso->nome; ?></td>
                    </tr>
                    <tr>
                        <td>Disciplina:</td>
                        <td><?php echo $disciplina->nome; ?></td>
                    </tr>
                    <tr>
                        <td>Professor:</td>
                        <td><?php echo $professor->nome; ?></td>
                    </tr>
                    <tr>
                        <td>Data:</td>
                        <td><?php echo data_br($diario->data); ?></td>
                    </tr>

                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong>Informações sobre alunos</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2"><hr /></td>
                    </tr>
                    <tr>
                        <td colspan="2"><table width="100%" border="0" cellspacing="2" cellpadding="2">
                                <tr>
                                    <td width="57%"><strong>Aluno</strong></td>
                                    <td width="22%" align="center"><strong>Presença</strong></td>
                                </tr>

                                <?php 
									  $cont = 0;
								      foreach ($alunos as $aluno) { 
								
									  if ($cont === 0) {
                                            $linha = "listaClara";
                                            $cont = 1;
                                      } else {
                                            $linha = "listaEscura";
                                            $cont = 0;
                                      }
								
								    ?>

                                    <tr class="<?php echo $linha ?>">
                                        <td style="text-transform:uppercase"><?php echo $aluno->aluno ?></td>
                                    <td align="center">
                                        <input type="radio" name="falta-<?php echo $aluno->id ?>" id="faltasim-<?php echo $aluno->id ?>" value="1" class="cssFalta validate[required]" <?php echo $diarioDao->isCheckedPresenca($_SESSION['CODDIARIO'], $aluno->id, 1)?> />
                                        Sim
                                        <input type="radio" name="falta-<?php echo $aluno->id ?>" id="faltanao-<?php echo $aluno->id ?>" value="0" class="cssFalta validate[required]" <?php echo $diarioDao->isCheckedPresenca($_SESSION['CODDIARIO'], $aluno->id, 0)?> />
                                        Não </td>
                                    </tr>
                                <?php } ?>
                            </table></td>
                    </tr>

                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center"><input name="Continuar" type="submit" value="Continuar"  /></td>
                                </tr>
                            </table></td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>

<p>&nbsp;</p>
