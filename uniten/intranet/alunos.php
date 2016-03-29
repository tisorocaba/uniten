<?php
require_once 'util/config.php';
Security::admSecurity();


$aluno = new Aluno();
$aluno->find();
$total = $aluno->count();


$aluno = new Aluno();
$totalM = $aluno->alias('a')->where('a.sexo=?','M')->find();
$aluno = new Aluno();
$totalF = $aluno->alias('a')->where('a.sexo=?','F')->find();

logDao::gravaLog($user->login, 'alunos', 'Acessou: pesquisa de alunos', $_REQUEST);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="intranet.css" rel="stylesheet" type="text/css">
<link href="css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="screen" href="../css/combogrid/css/smoothness/jquery.ui.combogrid.css"/>
<link rel="stylesheet" type="text/css" media="screen" href="../css/combogrid/css/smoothness/jquery-ui-1.10.1.custom.css"/>
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="js/combogrid/jquery/jquery-ui-1.10.1.custom.min.js"></script>
<script type="text/javascript" src="js/combogrid/plugin/jquery.ui.combogrid-1.6.3.js"></script>

<script src="scripts/alunos.js"></script>
<table width="100%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Alunos</strong></p>
        </td>
    </tr>
    <tr>
        <td>
            <form action="principal.php?acao=alunosPesquisa" method="post" name="form1" id="form1">
              <table width="100%" border="0" cellspacing="3" cellpadding="1">
                    <tr>
                        <td colspan="2"><strong>Pesquisa</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr />
                        </td>
                    </tr>
                    <tr>
                      <td width="10%">&nbsp;</td>
                      <td width="90%">&nbsp;</td>
                    </tr>
                    <tr class="splicenet">
                        <td colspan="2">Informe o nome ou o CPF do aluno</td>
                        </tr>
                        <tr>
                          <td><label for="select"></label>
                            <select name="tipo" id="tipo">
                              <option value="CPF">CPF</option>
                              <option value="NOME">NOME</option>
                          </select></td>
                          <td><label for="pesquisa"></label>
                          <input name="pesquisa" type="text" id="pesquisa" size="45" class="validate[required]" />
                          <label for="radio">
                            <input type="submit" name="button" id="button" value="Localizar" />
                          </label></td>
                        </tr>
                
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">Alunos cadastrados: <?php echo $total ?> </td>
                </tr>
                <tr>
                  <td colspan="2">Sexo Masculino: <?php echo $totalM?></td>
                </tr>
                 <tr>
                  <td colspan="2">Sexo Feminino: <?php echo $totalF?></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
              </table>
            </form>

        </td>
    </tr>
</table>

<p>&nbsp;</p>
