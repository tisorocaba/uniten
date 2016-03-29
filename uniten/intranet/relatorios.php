<?php
require_once 'util/config.php';
Security::admSecurity();

$empresas = new Empresa ();
$empresas->alias ('p')->order ('p.nome ASC')->find ();
logDao::gravaLog($user->login, 'relatorios', 'Acessou: relatorios',$_REQUEST);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="intranet.css" rel="stylesheet" type="text/css">
<link href="css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">

<link href="js/css/jquery-ui.css" rel="stylesheet" type="text/css">
<link href="js/css/ui.theme.css" rel="stylesheet" type="text/css">

<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>



<script src="js/jquery.ui.core.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.ui.widget.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.ui.datepicker.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/relatorios.js"></script>
<table width="100%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Relatórios</strong></p>
        </td>
    </tr>
    <tr>
        <td>
        
              <table width="100%" border="0" cellspacing="3" cellpadding="1">
                    <tr>
                        <td colspan="5"><strong>RELATÓRIOS DO SISTEMA</strong></td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <hr />
                        </td>
                    </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td width="19%"><strong>ALUNOS</strong></td>
                          <td width="19%"><strong> CURSOS</strong></td>
                          <td width="19%"><strong>UNITE</strong></td>
                          <td width="21%"><strong>INSCRIÇÕES</strong></td>
                          <td width="22%"><strong>DESISTÊNCIA</strong></td>
                        </tr>
                        <tr>
                          <td><a href="relatorios/formAlunoGeral.php" class="cssAlunos">&raquo; Perfil Geral </a></td>
                          <td><a href="relatorios/formCursoGeral.php" class="cssAlunos">&raquo; Formandos por Vagas</a><a href="relatorios/formDesistencia.php" class="cssAlunos"></a></td>
                          <td><a href="relatorios/formPosCurso.php" class="cssAlunos">&raquo; Pós-Curso</a></td>
                          <td><a href="relatorios/formInscricoesPeriodo.php" class="cssAlunos">&raquo; Por Período</a><a href="relatorios/formAlunoGeral.php" class="cssAlunos"></a></td>
                          <td><a href="relatorios/formDesistencia.php" class="cssAlunos">&raquo; Pesquisa geral </a></td>
                        </tr>
                        <tr>
                          <td><a href="relatorios/formFaixaEtaria.php" class="cssAlunos">&raquo; Perfil por Faixa Etária</a><a href="relatorios/formAlunoGeral.php" class="cssAlunos"></a></td>
                          <td><a href="relatorios/formCursoGeralValores.php" class="cssAlunos">&raquo; Formandos por Vagas(Valor)</a><a href="relatorios/formCursoGeral.php" class="cssAlunos"></a></td>
                          <td><a href="relatorios/formEvolucao.php" class="cssAlunos">&raquo; Evolução UNITE</a></td>
                          <td><a href="relatorios/formInscricoesPorData.php" class="cssAlunos">&raquo; Por Data da Prova</a></td>
                          <td><a href="relatorios/formDesistenciaJustificativa.php" class="cssAlunos">&raquo; Justificativa</a></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><a href="relatorios/formFormandosMes.php" class="cssAlunos">&raquo; Formandos por Mês</a><a href="relatorios/formCursoGeral.php" class="cssAlunos"></a></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><a href="relatorios/formEmpregabilidade.php" class="cssAlunos">&raquo; Empregabilidade</a><a href="relatorios/formEvolucao.php" class="cssAlunos"></a></td>
                          <td><a href="relatorios/formUniteemprega.php" class="cssAlunos">&raquo; UNITE Emprega</a></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><a href="relatorios/formConteudoProgramatico.php" class="cssAlunos">&raquo; Conteúdo Programático</a></td>
                          <td></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><a href="relatorios/formHorasMinistradas.php" class="cssAlunos">&raquo; Horas Ministradas</a><a href="relatorios/formEmpregabilidade.php" class="cssAlunos"></a></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td><a href="relatorios/formFaixaEtaria.php" class="cssAlunos"></a></td>
                          <td><a href="relatorios/formPosCurso.php" class="cssAlunos"></a></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                
                <tr>
                  <td colspan="5">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="5">&nbsp;</td>
                </tr>
              </table>
         

        </td>
    </tr>
</table>

