<?php
require_once '../util/config.php';
require_once '../dao/agendaDisciplinaProfessorDao.php';
require_once '../dao/agendaCursoDao.php';
require_once '../dao/diarioClasseDao.php';
Security::cursoSecurity();
$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);

$diarioDao = new DiarioClasseDao();

$projeto = new Projeto();
$projeto->get($agenda->local->projeto);

$agendaDiscplinaProfessorDao = new AgendaDisciplinaProfessorDao();
$professores = $agendaDiscplinaProfessorDao->listaProfessorAgendaAgrupado($_SESSION['CODAGENDA']);
$isAlterar = true; 
if(!empty($_REQUEST['id']))
{
   $obj = new DiarioClasse();
   $obj->get($obj->escape($_GET['id']));
   
  if(calculaDiferencaDataAtual(data_br($obj->data)) > 1){
     $isAlterar = false; 
  }
   
   
   
    if( $obj->agenda!=$_SESSION['CODAGENDA']){
        $_REQUEST['ERRO'] = 'FALTA DE CODIGO';
        $user = unserialize($_SESSION['USER']);
        logDao::gravaLog($user->login, 'diarioCadastroProfessor', 'ERRO(1056) :: tentou acessar outro diario de outro curso',$_REQUEST,'','Diario: '.$_GET['id']);
        die('ERRO(1056) :: ACESSO NEGADO');
   }
   
   $_POST = $obj->toArray();
   $_POST['data'] = data_br($_POST['data']);
   $lbBotao = "alterar";
   logDao::gravaLog($user->login, 'diarioCadastroProfessor', 'Acessou: ficha de cadastro de diario(alteracao)',$_REQUEST,'','Diario: '.$_GET['id']);
}else{
	die("ERRO: ACESSO NEGADO");
   $lbBotao = "gravar";
   logDao::gravaLog($user->login, 'diarioCadastroProfessor', 'Acessou: ficha de cadastro de diario(novo cadastro)',$_REQUEST);
}

$agendaDao = new AgendaCursoDao();
$alunos = $agendaDao->listaAlunoAgenda($_SESSION['CODAGENDA']);



?>
<link href="../intranet.css" rel="stylesheet" type="text/css">
<link href="../css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">

<!-- <script src="../../js/jquery-1.5.min.js" type="text/javascript"></script>-->

<script src="../js/jquery-1.7.2.min.js" type="text/javascript"></script>
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
                    <td><strong class="titulo">Relatórios de Classes :: Diário de Classe </strong></td>
                    <td align="right">
                     
            
      
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
           
           <input type="hidden" name ="totalAlunos" value="<?php echo count($alunos)?>" /> 
           
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
                    
                  
                        <?php echo $user->nome?>
                        
                        
                        <input type="hidden" name="professor" id="cbProfessor" value="<?php echo $user->professor?>" >
                               
                    
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
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2"><strong>Informações sobre os alunos</strong></td>
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
                      <td align="center"><input type="radio" name="falta-<?php echo $aluno->id ?>" id="faltasim-<?php echo $aluno->id ?>" value="1" class="validate[required]" <?php 
					  if(!empty($_REQUEST['id'])){
					     echo $diarioDao->isCheckedPresenca($_GET['id'], $aluno->id, 1);
					  }
					  
					  ?> />
                        Sim
                        <input type="radio" name="falta-<?php echo $aluno->id ?>" id="faltanao-<?php echo $aluno->id ?>" value="0" class="cssFalta validate[required]" <?php 
						if(!empty($_REQUEST['id'])){
						  echo $diarioDao->isCheckedPresenca($_GET['id'], $aluno->id, 0);
						}
						
						?> />
                        Não </td>
                    </tr>
                    <?php } ?>
                  </table></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="center">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                      <p><br />
                      <span style="font-size:9px;color:#F00">* campos de preenchimento obrigatório</span></p>
                      <p>
                        <?php if($isAlterar===true ){  ?>  
                        <input name="Continuar" type="submit" value="<?php echo $lbBotao?>"  />
                        <?php } ?>
                        
                        <input name="Continuar" type="button" value="voltar"  onclick="self.location='principal.php?acao=diarios'" />
                      </p></td>
                </tr>
            </table>
           </form>
        </td>
    </tr>
</table>
