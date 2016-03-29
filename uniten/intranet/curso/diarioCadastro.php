<?php
require_once '../util/config.php';
require_once '../dao/agendaCursoDao.php';
require_once '../dao/agendaDisciplinaProfessorDao.php';
Security::cursoSecurity();
$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);


$projeto = new Projeto();
$projeto->get($agenda->local->projeto);

$agendaDiscplinaProfessorDao = new AgendaDisciplinaProfessorDao();
$professores = $agendaDiscplinaProfessorDao->listaProfessorAgendaAgrupado($_SESSION['CODAGENDA']);

if(!empty($_GET['id']))
{
   $obj = new DiarioClasse();
   $obj->get($obj->escape($_GET['id']));
   
   if( $obj->agenda!=$_SESSION['CODAGENDA']){
        $_REQUEST['ERRO'] = 'FALTA DE CODIGO';
        $user = unserialize($_SESSION['USER']);
        logDao::gravaLog($user->login, 'diarioCadastro', '',$_REQUEST);
        die('ERRO(1056) :: ACESSO NEGADO');
   }
   
   $_POST = $obj->toArray();
   $_POST['data'] = data_br($_POST['data']);
   $lbBotao = "Alterar";
}else{
   die("ERRO: ACESSO NEGADO");
   $lbBotao = "Continuar";
}

$agendaDao = new AgendaCursoDao();
$alunos = $agendaDao->listaAlunoAgenda($_SESSION['CODAGENDA']);

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'diarioCadastro', '',$_REQUEST);
?>
<link href="../intranet.css" rel="stylesheet" type="text/css">
<link href="../css/validationEngine.jquery.css" rel="stylesheet" type="text/css">

<script src="../js/jquery-1.5.min.js" type="text/javascript"></script>
<script src="../js/jquery.maskedinput.js" type="text/javascript"></script>
<script src="../js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.limite-char-1.0.js" type="text/javascript"></script>
<script src="scripts/diarioCadastro.js" type="text/javascript"></script>
<table width="95%" border="0" cellspacing="0" cellpadding="3">
    <tr>
        <td valign="top" style="text-align:justify;">
              <p>
               <table width="100%" border="0">
                  <tr>
                    <td><strong class="titulo">Relatórios de Classes :: Diário de Classe</strong></td>
                    <td align="right">
                     
              <script language="JavaScript">
				var hoje = new Date()
				
				var dia = hoje.getDate();
				var dias = hoje.getDay();
				var mes = hoje.getMonth();
				var ano = hoje.getFullYear();
                                var hora = hoje.getHours();
                                var min =  hoje.getMinutes();
					if (dia < 10){
						dia = "0" + dia;
					}
					if (ano < 2000){
						ano = "19" + ano;
					}
				
				function CriaArray (n)
				{
				this.length = n
				}
				NomeDia = new CriaArray(7)
				NomeDia[0] = "Domingo"
				NomeDia[1] = "Segunda-feira"
				NomeDia[2] = "Terça-feira"
				NomeDia[3] = "Quarta-feira"
				NomeDia[4] = "Quinta-feira"
				NomeDia[5] = "Sexta-feira"
				NomeDia[6] = "Sábado"
				
				NomeMes = new CriaArray(12)
				NomeMes[0] = "janeiro"
				NomeMes[1] = "fevereiro"
				NomeMes[2] = "março"
				NomeMes[3] = "abril"
				NomeMes[4] = "maio"
				NomeMes[5] = "junho"
				NomeMes[6] = "julho"
				NomeMes[7] = "agosto"
				NomeMes[8] = "setembro"
				NomeMes[9] = "outubro"
				NomeMes[10] = "novembro"
				NomeMes[11] = "dezembro"
				
				document.write ("Sorocaba, " + dia + " de " + NomeMes[mes] + " de " + ano);
										
				</script> 
        <div align="right"><?php echo date("H:i")?>    
                    </td>
                  </tr>
                </table>

                </p>
        </td>
    </tr>
    <tr>
        <td>
          <form action="diarioLogic.php" method="post" id="form1">
           <input name="id" type="hidden" value="<?php echo @$_REQUEST['id']?>" />
           <input name="acao" type="hidden" value="gravar" />
           <input type="hidden" id="disciplina" value="<?php echo @$_POST['disciplina']?>" />
           <input type="hidden" id="datahoje" value="<?php echo date("d/m/Y")?>" />
            <table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr>
                    <td colspan="2"><strong>Dados do Curso</strong></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td width="28%">Projeto:</td>
                    <td width="72%">
                        <?php echo $projeto->nome; ?>
                    </td>
                </tr>
                <tr>
                    <td>Local:</td>
                    <td>
                        <?php echo $agenda->local->local; ?>
                    </td>
                </tr>
                <tr>
                    <td>Curso:</td>
                    <td>
                        <?php echo $agenda->curso->nome; ?>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Informações do Professor</strong></td>
                </tr>
                <tr>
                    <td colspan="2"><hr /></td>
                </tr>
                <tr>
                    <td>Professor:</td>
                    <td>
                    <select name="professor" id="cbProfessor" class="validate[required]">
                    <option value="">Selecione...</option>
                    <?php foreach ($professores as $professor) {?> 
                    <option value="<?php echo @$professor->proid?>" <?php if($professor->proid ==@$_POST['professor']) echo "selected"?>>
					    <?php echo @$professor->professor?>
                    </option>
                    <?php } ?>
                    
                   </select>
                    *
                    </td>
                </tr>
                <tr id="linhaDisciplinas" style="display:none">
                  <td>Disciplina:</td>
                  <td>
                     <span id="cbDisciplinas"><select name=""></select></span>
                  </td>
                </tr>
                <tr>
                    <td>Data da Aula:</td>
                    <td><label for="fileField"></label>
                    <input type="text" name="data" id="data" maxlength="10" size="10" class="validate[required]"  value="<?php echo @$_POST['data']?>" />
                    *</td>
                </tr>

                <tr>
                  <td>Horas Utilizadas:</td>
                  <td><input type="text" name="horas" id="horas" maxlength="4" size="4" class="validate[required]"   value="<?php echo @$_POST['horas']?>"/>
                    *ex: 1:00 ou 1:45</td>
                </tr>
                <tr>
                    <td>Conteúdo Programático:</td>
                    <td><label for="conteudo"></label>
                    <textarea name="conteudo" id="conteudo" cols="55" rows="4" class="validate[required]" ><?php echo @$_POST['conteudo']?></textarea> 
                    &nbsp;*</td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td><input name="Continuar" type="submit" value="<?php echo $lbBotao?>"  /></td>
                </tr>
            </table>
           </form>
        </td>
    </tr>
</table>
