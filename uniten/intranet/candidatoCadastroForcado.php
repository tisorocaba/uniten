<?php
require_once 'util/config.php';
Security::admSecurity();

$obj = new Aluno();
$obj->get($_REQUEST['aluno']);
$cursoMatricula = AgendaCurso::staticGet((int)$_SESSION['CODAGENDA'])->curso->nome;
$cursoAtual = AgendaCurso::staticGet((int)$_REQUEST['curso'])->curso->nome;

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'candidaCadastroForcado', 'Acessou: aviso de cadastro forcado', $_REQUEST, '', 'aluno: ' . $obj->id. ' Curso: '.$_SESSION['CODAGENDA']);

?>
<link href="intranet.css" rel="stylesheet" type="text/css" />

<p><span class="titulo">Aluno &raquo; Cadastro</span> <span class="titulo"> &raquo;</span> <span class="titulo">Aviso</span><br> 

</p>


<table width="100%" cellpadding="3" cellspacing="1">
        <tr>
          <td colspan="2" valign="top" align="center"> <br />
            <br />
            <br />
            <br />
            <span class="titulo">ATENÇÃO!</span><br />
            <br />
            <br />
            <span class="sobreTitulo">O aluno que você está tentando cadastrar no curso <font color="#0000FF">(<?php echo (int)$_SESSION['CODAGENDA']?>) <?php echo $cursoMatricula?></font><br />
já está matrículado ou cursando o curso <font color="#0000FF">(<?php echo (int)$_REQUEST['curso']?>)<?php echo $cursoAtual?></font> no mesmo período.</span><br />
            </span></td>
        </tr>
      
        <tr>
          <td valign="top">&nbsp;</td>
          <td align="left"></td>
        </tr>
        <tr>
          <td width="40%" valign="top">&nbsp;</td>
          <!-- <td width="60%" align="left"><strong>Deseja cadastrá-lo mesmo assim?</strong></td> -->
          <td width="60%" align="left"><strong>Não é possível cadastrá-lo</strong></td>
        </tr>
        <tr>
          <td colspan="2" valign="top"><table width="40%" border="0" align="center">
            <tr>
                <td width="42%">&nbsp;</td>
                <!-- <td width="12%"><input type="button" name="btnSim" id="btnSim" value="Sim" onclick="self.location='candidatoFormulario.php?id=<?php echo $obj->id?>&cpf=<?php echo $obj->cpf?>&acao=insert'" /></td> -->
                <!-- <td width="46%"><input type="button" name="btnNao" id="btnNao" value="Não" onclick="self.location='candidatoCadastro.php'" /></td> -->
                <td width="46%"><input type="button" name="btnNao" id="btnNao" value="OK" onclick="self.location='candidatoCadastro.php'" /></td>                
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td align="left"></td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td align="left"></td>
        </tr>
      </table>
