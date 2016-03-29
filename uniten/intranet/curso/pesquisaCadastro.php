<?php
require_once '../util/config.php';
require_once '../dao/perguntaDao.php';
require_once '../dao/agendaCursoDao.php';
Security::admEcurso();
$agenda = new AgendaCurso();


$agenda->get($_SESSION['CODAGENDA']);


$perguntaDao = new PerguntaDao();
$perguntas = $perguntaDao->listaPerguntas('A');

$agendaDao = new AgendaCursoDao;
$alunos = $agendaDao->listaAlunoAgenda($_SESSION['CODAGENDA']);


$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'pesquisaCadastro', 'Acessou: cadastro de pesquisa ', $_REQUEST,'','Agenda: '.$_SESSION['CODAGENDA']);


?>
<link href="http://www.sorocaba.sp.gov.br/uniten/intranet/intranet.css" rel="stylesheet" type="text/css">
<link href="http://www.sorocaba.sp.gov.br/uniten/css/validationEngine.jquery.css" rel="stylesheet" type="text/css">

<script src="http://www.sorocaba.sp.gov.br/uniten/js/jquery-1.5.min.js" type="text/javascript"></script>
<script src="http://www.sorocaba.sp.gov.br/uniten/js/jquery.maskedinput.js" type="text/javascript"></script>
<script src="http://www.sorocaba.sp.gov.br/uniten/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="http://www.sorocaba.sp.gov.br/uniten/js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="http://www.sorocaba.sp.gov.br/uniten/js/jquery.limite-char-1.0.js" type="text/javascript"></script>
<script src="http://www.sorocaba.sp.gov.br/uniten/intranet/curso/scripts/pesquisaCadastro.js" type="text/javascript"></script>

<table width="100%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Pesquisa do Aluno :: Cadastro</strong></p>
        </td>
    </tr>
    <tr>
        <td>
         
            <form action="pesquisaLogic.php" method="post" name="form1" id="form1">
            
            <table width="100%" border="0" cellspacing="3" cellpadding="1">
                <tr>
                    <td colspan="2"><strong>Informações do Local</strong></td>
                </tr>
                <tr>
                    <td colspan="2"><hr /></td>
                </tr>
                <tr>
                    <td width="22%">Curso:</td>
                    <td width="78%"><?php echo $agenda->curso->nome?>
                    </td>
                </tr>
                <tr id="linhaDisciplinas">
                  <td>Local:</td>
                  <td>
                     <?php echo $agenda->local->local?>
                  </td>
                </tr>

                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Questionário</strong></td>
                </tr>
                <tr>
                  <td colspan="2" align="left"><hr /></td>
                </tr>
                <tr>
                    <td colspan="2" align="left"><table width="100%" border="0">
                      <tr>
                        <td colspan="2" bgcolor="#FFFFFF" ><table width="100%" border="0">
                          <tr>
                            <td width="8%" align="left"><strong>Alunos:</strong></td>
                            <td width="92%" align="left"><label for="select"></label>
                              <select name="aluno" id="aluno" style="text-transform:uppercase">
                                  <option value="">-- Não informado -- </option>
                                  <?php foreach ($alunos as $aluno) {?>
                                    <option value="<?php echo $aluno->id?>"><?php echo $aluno->aluno?></option>
                                  <?php } ?>
                              </select>                              
                            </td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td width="55%" bgcolor="#CCCCCC" ><strong>PERGUNTAS</strong></td>
                        <td align="CENTER" bgcolor="#CCCCCC"><strong>RESPOSTAS</strong></td>
                      </tr>
                      <?php 
                          $cont = 0;
                          foreach ($perguntas as $pergunta) { 
                          
                           
                                     if ($cont === 0) {
                                            $linha = "listaClara";
                                            $cont = 1;
                                      } else {
                                            $linha = "listaEscura";
                                            $cont = 0;
                                      }
                          
                          ?>
                          
                      
                      <tr class="<?php echo $linha ?>">
                        <td  style="text-transform: uppercase;"><?php echo $pergunta->titulo?></td>
                        <td align="right">
                        <?php if($pergunta->tipo=='N'){ ?>
                         <table width="100%" border="0">
                          <tr>
                            <td><input type="radio" name="<?php echo $pergunta->id?>" id="pessimo_<?php echo $pergunta->id?>" value="1" class="validate[required]"/>
                              Péssimo</td>
                            <td><input type="radio" name="<?php echo $pergunta->id?>" id="regular_<?php echo $pergunta->id?>" value="2" class="validate[required]" />
                              Regular </td>
                            <td><input type="radio" name="<?php echo $pergunta->id?>" id="bom_<?php echo $pergunta->id?>" value="3" class="validate[required]" />
                              Bom </td>
                            <td><input type="radio" name="<?php echo $pergunta->id?>" id="muitobom_<?php echo $pergunta->id?>" value="4"  class="validate[required]"/>
                              Muito Bom </td>
                            <td><input type="radio" name="<?php echo $pergunta->id?>" id="excelente_<?php echo $pergunta->id?>" value="5" class="validate[required]"/>
                              Excelente </td>
                          </tr>
                        </table>
                        <?php }else{ ?>
                        <table width="100%" border="0">
                          <tr>
                            <td width="21%"><input type="radio" class="validate[required]" name="<?php echo $pergunta->id?>" id="sim_<?php echo $pergunta->id?>" value="S" />
                              Sim</td>
                            <td width="79%"><input type="radio" class="validate[required]" name="<?php echo $pergunta->id?>" id="nao_<?php echo $pergunta->id?>" value="N" />
                              Não </td>
                           
                          </tr>
                        </table>
                        <?php }?>
                        </td>
                      </tr>
                      <?php }?>
                      <tr class="">
                        <td >&nbsp;</td>
                        <td align="right">&nbsp;</td>
                      </tr>
                      <tr class="">
                        <td ><strong>Comentários</strong></td>
                        <td align="right">&nbsp;</td>
                      </tr>
                      <tr class="">
                        <td colspan="2" ><textarea name="comentario" id="comentario"  cols="70" rows="4"></textarea>                        <label for="textarea"></label></td>
                      </tr>
                      
                  </table></td>
                </tr>
                <tr>
                  <td colspan="2" align="left">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" align="center">&nbsp;
                  <input name="btgravar" value="gravar" type="submit" />
                  <input name="btvoltar" value="voltar" type="button" onclick="self.location='pesquisaInfra.php'" /></td>
                </tr>
            </table>
            </form>
           
        </td>
    </tr>
</table>
