<?php
require_once 'util/config.php';
require_once 'dao/agendaCursoDao.php';
Security::admSecurity();

$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);


$user = unserialize($_SESSION['USER']);

logDao::gravaLog($user->login, 'candidatoLogic', 'Acessou: incluir candidato(consulta)', $_SESSION);



?>

<link href="intranet.css" rel="stylesheet" type="text/css">
<link href="css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">

<script src="js/jquery-1.6.2.min.js" type="text/javascript"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.limite-char-1.0.js" type="text/javascript"></script>
<script src="scripts/candidatoCadastro.js" type="text/javascript"></script>

<p><span class="titulo">Aluno &raquo; Cadastro</span><br>
</p>

<form action="candidatoConsulta.php" method="post" id="form1">
<table width="100%" cellpadding="3" cellspacing="1">
  <tr>
    <td valign="top">Curso:</td>
    <td><?php echo $agenda->curso->nome?></td>
  </tr>
  <tr>
    <td width="17%" valign="top">CPF:</td>
    <td width="83%"><input type="text" name="cpf" id="cpf" class="validate[required]"/></td>
  </tr>
  <tr>
    <td width="17%" valign="top">Data de Nascimento:</td>
    <td width="83%">
        <input type="text" size="15" name="dataNascimento" id="dataNascimento" class="validate[required]"/>
    </td>
  </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td align="left"><input type="submit" name="enviar" id="enviar" value="Continuar">
          <input type="button" name="enviar2" id="enviar2" value="Voltar" onClick="history.go(-1)"></td>
        </tr>
      </table>
</form>
